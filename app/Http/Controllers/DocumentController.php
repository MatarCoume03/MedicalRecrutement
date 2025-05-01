<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Auth::user()
            ->documents()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('documents.index', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:cv,lettre_motivation,diplome,certificat,autre',
            'document' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'est_public' => 'boolean',
        ]);

        $file = $request->file('document');
        $path = $file->store('documents');

        Auth::user()->documents()->create([
            'type' => $request->type,
            'nom_fichier' => $file->getClientOriginalName(),
            'chemin' => $path,
            'mime_type' => $file->getMimeType(),
            'taille' => $file->getSize(),
            'est_public' => $request->has('est_public'),
        ]);

        return back()->with('success', 'Document téléversé avec succès.');
    }

    public function destroy(Document $document)
    {
        $this->authorize('delete', $document);
        Storage::delete($document->chemin);
        $document->delete();
        return back()->with('success', 'Document supprimé avec succès.');
    }
}