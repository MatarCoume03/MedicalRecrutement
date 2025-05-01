<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OffreEmploi;
use App\Models\Candidature;
use App\Models\Competence;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use MongoDB\Laravel\Eloquent\Builder;

class CandidatController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $offresRecent = OffreEmploi::where('statut', 'approuve')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        $candidatures = $user->candidatures()
            ->with('offreEmploi')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('candidat.dashboard', compact('user', 'offresRecent', 'candidatures'));
    }

    public function showProfile()
    {
        $user = Auth::user()->load('competences');
        $competences = Competence::where('is_validated', true)->get();
        
        return view('candidat.profil', compact('user', 'competences'));
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
            'date_naissance' => 'nullable|date',
            'genre' => 'nullable|in:homme,femme,autre',
            'nationalite' => 'nullable|string|max:100',
            'ville' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:1000',
            'specialite_medicale' => 'nullable|string|max:100',
            'annees_experience' => 'nullable|integer|min:0',
            'niveau_etude' => 'nullable|string|max:100',
            'langues' => 'nullable|array',
            'langues.*' => 'string|max:50',
            'competences' => 'nullable|array',
            'competences.*.id' => 'exists:competences,_id',
            'competences.*.niveau' => 'required_with:competences.*.id|in:debutant,intermediaire,avance,expert',
        ]);

        $user->update($request->only(['nom', 'prenom', 'telephone', 'adresse']));

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::delete($user->photo);
            }
            $path = $request->file('photo')->store('profiles');
            $user->photo = $path;
            $user->save();
        }

        $profilData = collect($data)
            ->except(['nom', 'prenom', 'telephone', 'adresse', 'photo', 'competences'])
            ->toArray();
            
        $user->candidatProfil->update($profilData);

        if ($request->has('competences')) {
            $competencesSync = [];
            foreach ($request->competences as $comp) {
                $competencesSync[$comp['id']] = ['niveau' => $comp['niveau']];
            }
            $user->competences()->sync($competencesSync);
        }

        return redirect()->route('candidat.profil')->with('success', 'Profil mis à jour avec succès.');
    }

    public function searchOffres(Request $request)
    {
        $query = OffreEmploi::where('statut', 'approuve')
            ->with('user.recruteurProfil')
            ->orderBy('created_at', 'desc');

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('titre', 'like', '%'.$request->search.'%')
                  ->orWhere('description', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->has('specialite')) {
            $query->where('specialite_requise', $request->specialite);
        }

        if ($request->has('localisation')) {
            $query->where('localisation', 'like', '%'.$request->localisation.'%');
        }

        if ($request->has('type_contrat')) {
            $query->where('type_contrat', $request->type_contrat);
        }

        $offres = $query->paginate(10);

        return view('candidat.offres', compact('offres'));
    }

    public function showOffre(OffreEmploi $offre)
    {
        $hasApplied = Auth::user()->candidatures()
            ->where('offre_emploi_id', $offre->_id)
            ->exists();

        return view('candidat.offre-show', compact('offre', 'hasApplied'));
    }

    public function postuler(Request $request, OffreEmploi $offre)
    {
        $user = Auth::user();

        if ($user->candidatures()->where('offre_emploi_id', $offre->_id)->exists()) {
            return back()->with('error', 'Vous avez déjà postulé à cette offre.');
        }

        $request->validate([
            'lettre_motivation' => 'required|string|min:100|max:2000',
            'cv_id' => 'required|exists:documents,_id,user_id,'.$user->_id,
        ]);

        $candidature = $user->candidatures()->create([
            'offre_emploi_id' => $offre->_id,
            'lettre_motivation' => $request->lettre_motivation,
        ]);

        $cv = Document::find($request->cv_id);
        $cv->documentable()->associate($candidature);
        $cv->save();

        return redirect()->route('candidat.candidatures')->with('success', 'Votre candidature a été soumise avec succès.');
    }

    public function mesCandidatures()
    {
        $candidatures = Auth::user()
            ->candidatures()
            ->with('offreEmploi.user.recruteurProfil')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('candidat.candidatures', compact('candidatures'));
    }

    public function showCandidature(Candidature $candidature)
    {
        $this->authorize('view', $candidature);
        return view('candidat.candidature-show', compact('candidature'));
    }

    public function annulerCandidature(Candidature $candidature)
    {
        $this->authorize('delete', $candidature);
        $candidature->delete();
        return redirect()->route('candidat.candidatures')->with('success', 'Candidature annulée avec succès.');
    }
}