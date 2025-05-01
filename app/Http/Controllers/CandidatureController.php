<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\OffreEmploi;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidatureController extends Controller
{
    public function index()
    {
        $candidatures = Candidature::with(['user.candidatProfil', 'offreEmploi.user.recruteurProfil'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.candidatures', compact('candidatures'));
    }

    public function store(Request $request, OffreEmploi $offre)
    {
        $user = Auth::user();

        if (!$user->isCandidat()) {
            return back()->with('error', 'Seuls les candidats peuvent postuler aux offres.');
        }

        if (!$offre->isValide()) {
            return back()->with('error', 'Cette offre n\'est plus disponible.');
        }

        if ($user->candidatures()->where('offre_emploi_id', $offre->_id)->exists()) {
            return back()->with('error', 'Vous avez déjà postulé à cette offre.');
        }

        $request->validate([
            'lettre_motivation' => 'required|string|min:100|max:2000',
            'cv_id' => 'required|exists:documents,_id,user_id,'.$user->_id.',type,cv',
        ]);

        $candidature = $user->candidatures()->create([
            'offre_emploi_id' => $offre->_id,
            'lettre_motivation' => $request->lettre_motivation,
            'statut' => 'en_revue',
        ]);

        $cv = Document::find($request->cv_id);
        $cv->documentable()->associate($candidature);
        $cv->save();

        return redirect()->route('candidat.candidatures')->with('success', 'Votre candidature a été soumise avec succès.');
    }

    public function show(Candidature $candidature)
    {
        $this->authorize('view', $candidature);
        $candidature->load('offreEmploi.user.recruteurProfil', 'documents');
        return view('candidat.candidature-show', compact('candidature'));
    }

    public function destroy(Candidature $candidature)
    {
        $this->authorize('delete', $candidature);
        $candidature->delete();
        return redirect()->route('candidat.candidatures')->with('success', 'Candidature annulée avec succès.');
    }

    public function updateStatus(Request $request, Candidature $candidature)
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

    public function statistics()
    {
        $candidaturesParStatut = Candidature::raw(function($collection) {
            return $collection->aggregate([
                ['$group' => [
                    '_id' => '$statut',
                    'total' => ['$sum' => 1]
                ]],
                ['$sort' => ['total' => -1]]
            ]);
        });

        $candidaturesParSpecialite = Candidature::raw(function($collection) {
            return $collection->aggregate([
                ['$lookup' => [
                    'from' => 'offre_emplois',
                    'localField' => 'offre_emploi_id',
                    'foreignField' => '_id',
                    'as' => 'offre'
                ]],
                ['$unwind' => '$offre'],
                ['$group' => [
                    '_id' => '$offre.specialite_requise',
                    'total' => ['$sum' => 1]
                ]],
                ['$sort' => ['total' => -1]]
            ]);
        });

        return view('admin.candidatures-statistiques', compact('candidaturesParStatut', 'candidaturesParSpecialite'));
    }
}