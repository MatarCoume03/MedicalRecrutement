<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use Illuminate\Http\Request;

class CompetenceController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $competences = Competence::where('nom', 'like', "%$query%")
            ->where('is_validated', true)
            ->limit(10)
            ->get();

        return response()->json($competences);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:competences,nom',
            'categorie' => 'nullable|string|max:255',
        ]);

        Competence::create([
            'nom' => $request->nom,
            'categorie' => $request->categorie,
            'is_validated' => false,
        ]);

        return back()->with('success', 'Compétence soumise pour validation.');
    }
}