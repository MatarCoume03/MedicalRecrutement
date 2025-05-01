<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OffreEmploi;
use App\Models\Competence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'candidats' => User::where('type', 'candidat')->count(),
            'recruteurs' => User::where('type', 'recruteur')->count(),
            'offres' => OffreEmploi::count(),
            'offres_en_attente' => OffreEmploi::where('statut', 'en_attente')->count(),
        ];

        $offresEnAttente = OffreEmploi::with('user.recruteurProfil')
            ->where('statut', 'en_attente')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'offresEnAttente'));
    }

    public function statistics()
    {
        $offresParSpecialite = OffreEmploi::raw(function($collection) {
            return $collection->aggregate([
                ['$group' => [
                    '_id' => '$specialite_requise',
                    'total' => ['$sum' => 1]
                ]],
                ['$sort' => ['total' => -1]]
            ]);
        });

        $candidatsParVille = User::where('type', 'candidat')
            ->with('candidatProfil')
            ->get()
            ->groupBy('candidatProfil.ville')
            ->map->count();

        return view('admin.statistiques', compact('offresParSpecialite', 'candidatsParVille'));
    }

    public function index()
    {
        $users = User::with(['candidatProfil', 'recruteurProfil'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function toggleUser(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        $action = $user->is_active ? 'activé' : 'désactivé';
        return back()->with('success', "Utilisateur $action avec succès.");
    }

    public function validateOffer(OffreEmploi $offre)
    {
        $offre->update(['statut' => 'approuve']);
        return back()->with('success', 'Offre validée avec succès.');
    }

    public function rejectOffer(Request $request, OffreEmploi $offre)
    {
        $request->validate(['raison' => 'required|string|max:1000']);
        
        $offre->update([
            'statut' => 'rejete',
            'feedback_validation' => $request->raison,
        ]);

        return back()->with('success', 'Offre rejetée avec succès.');
    }

    public function offres()
    {
        $offres = OffreEmploi::with('user.recruteurProfil')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.offres', compact('offres'));
    }

    public function competences()
    {
        $competences = Competence::orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.competences', compact('competences'));
    }

    public function validateCompetence(Competence $competence)
    {
        $competence->update(['is_validated' => true]);
        return back()->with('success', 'Compétence validée avec succès.');
    }

    public function destroyCompetence(Competence $competence)
    {
        $competence->delete();
        return back()->with('success', 'Compétence supprimée avec succès.');
    }
}