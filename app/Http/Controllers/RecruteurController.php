<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OffreEmploi;
use App\Models\Candidature;
use App\Models\Competence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use MongoDB\Laravel\Eloquent\Builder;

class RecruteurController extends Controller
{
    public function dashboard()
{
    // Récupérer d'abord les IDs des offres
    $offreIds = OffreEmploi::where('user_id', auth()->id())->pluck('_id')->toArray();

    // Si aucune offre, éviter les erreurs avec tableau vide
    if (empty($offreIds)) {
        $offreIds = [null]; // Solution de repli
    }

    // Calcul des statistiques
    $stats = [
        'offres_actives' => OffreEmploi::where([
            'user_id' => auth()->id(),
            'statut' => 'active'
        ])->count(),

        'candidatures_total' => Candidature::whereIn('offre_emploi_id', $offreIds)->count(),

        'candidatures_entretien' => Candidature::where([
            'offre_emploi_id' => ['$in' => $offreIds],
            'statut' => 'entretien'
        ])->count()
    ];

    // Récupération des données
    return view('recruteur.dashboard', [
        'stats' => $stats,
        'candidaturesRecent' => Candidature::whereIn('offre_emploi_id', $offreIds)
            ->with(['user', 'offreEmploi'])
            ->latest()
            ->take(5)
            ->get(),
        'offresRecent' => OffreEmploi::where('user_id', auth()->id())
            ->with(['candidatures'])
            ->latest()
            ->take(3)
            ->get()
    ]);
}

    public function showProfile()
    {
        $user = Auth::user()->load('recruteurProfil');
        return view('recruteur.profil', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'entreprise' => 'required|string|max:255',
            'secteur_activite' => 'required|string|max:255',
            'poste_occupe' => 'required|string|max:255',
            'site_web' => 'nullable|url|max:255',
            'logo' => 'nullable|image|max:2048',
            'description_entreprise' => 'nullable|string|max:2000',
        ]);

        $user->update($request->only(['nom', 'prenom', 'telephone', 'adresse']));

        foreach (['photo', 'logo'] as $imageField) {
            if ($request->hasFile($imageField)) {
                $oldImage = $imageField === 'photo' ? $user->photo : $user->recruteurProfil->logo;
                if ($oldImage) {
                    Storage::delete($oldImage);
                }
                $path = $request->file($imageField)->store('profiles');
                if ($imageField === 'photo') {
                    $user->photo = $path;
                    $user->save();
                } else {
                    $user->recruteurProfil->logo = $path;
                    $user->recruteurProfil->save();
                }
            }
        }

        $profilData = collect($data)
            ->except(['nom', 'prenom', 'telephone', 'adresse', 'photo', 'logo'])
            ->toArray();
            
        $user->recruteurProfil->update($profilData);

        return redirect()->route('recruteur.profil')->with('success', 'Profil mis à jour avec succès.');
    }

        public function mesCandidatures()
    {
        $offreIds = OffreEmploi::where('user_id', auth()->id())->pluck('_id');
        $candidatures = Candidature::whereIn('offre_emploi_id', $offreIds)
                        ->with(['user', 'offreEmploi'])
                        ->paginate(10);

        return view('recruteur.candidatures', ['candidatures' => $candidatures]);
    }

    public function mesOffres()
    {
        $offres = Auth::user()
            ->offresEmploi()
            ->withCount('candidatures')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('recruteur.offres', compact('offres'));
    }

    public function createOffre()
    {
        $competences = Competence::where('is_validated', true)->get();
        return view('recruteur.offre-create', compact('competences'));
    }

    public function storeOffre(Request $request)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string|min:100|max:5000',
            'specialite_requise' => 'required|string|max:255',
            'annees_experience_requises' => 'nullable|integer|min:0',
            'niveau_etude_requis' => 'nullable|string|max:255',
            'type_contrat' => 'required|string|max:100',
            'localisation' => 'required|string|max:255',
            'salaire_min' => 'nullable|numeric|min:0',
            'salaire_max' => 'nullable|numeric|min:0|gt:salaire_min',
            'date_limite' => 'required|date|after:today',
            'is_urgent' => 'boolean',
            'competences' => 'required|array|min:1',
            'competences.*.id' => 'required|exists:competences,_id',
            'competences.*.niveau' => 'required|in:debutant,intermediaire,avance,expert',
            'competences.*.obligatoire' => 'boolean',
        ]);

        $offre = Auth::user()->offresEmploi()->create([
            'titre' => $data['titre'],
            'description' => $data['description'],
            'specialite_requise' => $data['specialite_requise'],
            'annees_experience_requises' => $data['annees_experience_requises'],
            'niveau_etude_requis' => $data['niveau_etude_requis'],
            'type_contrat' => $data['type_contrat'],
            'localisation' => $data['localisation'],
            'salaire_min' => $data['salaire_min'],
            'salaire_max' => $data['salaire_max'],
            'date_limite' => $data['date_limite'],
            'is_urgent' => $request->has('is_urgent'),
            'statut' => 'en_attente',
        ]);

        $competencesSync = [];
        foreach ($data['competences'] as $comp) {
            $competencesSync[$comp['id']] = [
                'niveau_requis' => $comp['niveau'],
                'est_obligatoire' => $comp['obligatoire'] ?? false,
            ];
        }
        $offre->competences()->sync($competencesSync);

        return redirect()->route('recruteur.offres')->with('success', 'Offre créée avec succès. En attente de validation.');
    }

    public function showOffre(OffreEmploi $offre)
    {
        $this->authorize('view', $offre);
        $offre->load('competences');
        return view('recruteur.offre-show', compact('offre'));
    }

    public function editOffre(OffreEmploi $offre)
    {
        $this->authorize('update', $offre);
        $competences = Competence::where('is_validated', true)->get();
        $offre->load('competences');
        
        return view('recruteur.offre-edit', compact('offre', 'competences'));
    }

    public function updateOffre(Request $request, OffreEmploi $offre)
    {
        $this->authorize('update', $offre);

        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string|min:100|max:5000',
            'specialite_requise' => 'required|string|max:255',
            'annees_experience_requises' => 'nullable|integer|min:0',
            'niveau_etude_requis' => 'nullable|string|max:255',
            'type_contrat' => 'required|string|max:100',
            'localisation' => 'required|string|max:255',
            'salaire_min' => 'nullable|numeric|min:0',
            'salaire_max' => 'nullable|numeric|min:0|gt:salaire_min',
            'date_limite' => 'required|date|after:today',
            'is_urgent' => 'boolean',
            'competences' => 'required|array|min:1',
            'competences.*.id' => 'required|exists:competences,_id',
            'competences.*.niveau' => 'required|in:debutant,intermediaire,avance,expert',
            'competences.*.obligatoire' => 'boolean',
        ]);

        $offre->update([
            'titre' => $data['titre'],
            'description' => $data['description'],
            'specialite_requise' => $data['specialite_requise'],
            'annees_experience_requises' => $data['annees_experience_requises'],
            'niveau_etude_requis' => $data['niveau_etude_requis'],
            'type_contrat' => $data['type_contrat'],
            'localisation' => $data['localisation'],
            'salaire_min' => $data['salaire_min'],
            'salaire_max' => $data['salaire_max'],
            'date_limite' => $data['date_limite'],
            'is_urgent' => $request->has('is_urgent'),
            'statut' => 'en_attente',
        ]);

        $competencesSync = [];
        foreach ($data['competences'] as $comp) {
            $competencesSync[$comp['id']] = [
                'niveau_requis' => $comp['niveau'],
                'est_obligatoire' => $comp['obligatoire'] ?? false,
            ];
        }
        $offre->competences()->sync($competencesSync);

        return redirect()->route('recruteur.offres')->with('success', 'Offre mise à jour avec succès.');
    }

    public function destroyOffre(OffreEmploi $offre)
    {
        $this->authorize('delete', $offre);
        $offre->delete();
        return redirect()->route('recruteur.offres')->with('success', 'Offre supprimée avec succès.');
    }

    public function candidaturesOffre(OffreEmploi $offre)
    {
        $this->authorize('view', $offre);

        $candidatures = $offre->candidatures()
            ->with('user.candidatProfil')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('recruteur.candidatures', compact('offre', 'candidatures'));
    }

    public function showCandidature(Candidature $candidature)
    {
        $this->authorize('view', $candidature);
        $candidature->load('user.candidatProfil', 'user.competences', 'offreEmploi');
        
        return view('recruteur.candidature-show', compact('candidature'));
    }

    public function updateCandidatureStatus(Request $request, Candidature $candidature)
    {
        $this->authorize('update', $candidature);

        $request->validate([
            'statut' => 'required|in:en_revue,entretien,accepte,rejete',
            'feedback' => 'nullable|string|max:1000',
        ]);

        $candidature->update([
            'statut' => $request->statut,
            'feedback' => $request->feedback,
        ]);

        return back()->with('success', 'Statut de la candidature mis à jour.');
    }

    public function searchCandidats(Request $request)
    {
        $query = User::where('type', 'candidat')
            ->with('candidatProfil', 'competences')
            ->whereHas('candidatProfil');

            if ($request->has('search')) {
                $query->where(function($q) use ($request) {
                    $q->where('nom', 'regex', '/.*'.$request->search.'.*/i')
                      ->orWhere('prenom', 'regex', '/.*'.$request->search.'.*/i');
                });
            }

        if ($request->has('specialite')) {
            $query->whereHas('candidatProfil', function($q) use ($request) {
                $q->where('specialite_medicale', $request->specialite);
            });
        }

        if ($request->has('competences')) {
            $query->whereHas('competences', function($q) use ($request) {
                $q->whereIn('_id', $request->competences);
            }, '>=', count($request->competences));
        }

        if ($request->has('ville')) {
            $query->whereHas('candidatProfil', function($q) use ($request) {
                $q->where('ville', 'like', '%'.$request->ville.'%');
            });
        }

        $candidats = $query->paginate(10);
        $competences = Competence::where('is_validated', true)->get();

        return view('recruteur.candidats', compact('candidats', 'competences'));
    }

    public function showCandidat(User $candidat)
    {
        if (!$candidat->isCandidat()) {
            abort(404);
        }

        $candidat->load('candidatProfil', 'competences', 'documents');
        return view('recruteur.candidat-show', compact('candidat'));
    }
}