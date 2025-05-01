<?php

namespace App\Http\Controllers;

use App\Models\OffreEmploi;
use App\Models\Competence;
use Illuminate\Http\Request;

class OffreEmploiController extends Controller
{
    public function index()
    {
        $offres = OffreEmploi::where('statut', 'approuve')
            ->with('user.recruteurProfil')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
        $specialites = OffreEmploi::raw(function($collection) {
            return $collection->distinct('specialite_requise');
        });
    
        return view('offres.index', compact('offres', 'specialites'));
    }

    public function show(OffreEmploi $offre)
    {
        if (!$offre->isValide()) {
            abort(404);
        }

        $offre->load('user.recruteurProfil', 'competences');
        return view('offres.show', compact('offre'));
    }

    public function adminIndex()
    {
        $offres = OffreEmploi::with('user.recruteurProfil')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.offres', compact('offres'));
    }
}