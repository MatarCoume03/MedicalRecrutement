<!-- resources/views/recruteur/candidature-show.blade.php -->

@extends('layouts.app')

@section('title', 'Candidature de ' . $candidature->user->fullName)

@section('header')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    Candidature de {{ $candidature->user->fullName }}
                </h1>
                <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $candidature->status_badge_color }}">
                            {{ $candidature->statut_label }}
                        </span>
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <x-icons.briefcase class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                        Pour "{{ $candidature->offreEmploi->titre }}"
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <x-icons.calendar class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                        Postulé le {{ $candidature->created_at->isoFormat('LL') }}
                    </div>
                </div>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('recruteur.candidatures', $candidature->offreEmploi) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Retour aux candidatures
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <!-- Profil du candidat -->
    <div class="lg:col-span-1">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Profil du candidat
                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    @if($candidature->user->photo)
                        <img class="h-16 w-16 rounded-full" src="{{ Storage::url($candidature->user->photo) }}" alt="">
                    @else
                        <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-medium">
                            {{ substr($candidature->user->prenom, 0, 1) }}{{ substr($candidature->user->nom, 0, 1) }}
                        </div>
                    @endif
                    <div class="ml-4">
                        <h4 class="text-lg font-medium text-gray-900">{{ $candidature->user->fullName }}</h4>
                        <p class="text-sm text-gray-500">{{ $candidature->user->email }}</p>
                        <p class="text-sm text-gray-500">{{ $candidature->user->telephone }}</p>
                    </div>
                </div>
                
                <div class="mt-6 space-y-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900">Spécialité</h4>
                        <p class="mt-1 text-sm text-gray-700">{{ $candidature->user->candidatProfil->specialite_medicale ?? 'Non spécifié' }}</p>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-medium text-gray-900">Expérience</h4>
                        <p class="mt-1 text-sm text-gray-700">
                            {{ $candidature->user->candidatProfil->annees_experience ?? '0' }} ans
                        </p>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-medium text-gray-900">Localisation</h4>
                        <p class="mt-1 text-sm text-gray-700">
                            {{ $candidature->user->candidatProfil->ville ?? 'Non spécifié' }}
                        </p>
                    </div>
                </div>
                
                <div class="mt-6">
                    <a href="{{ route('recruteur.candidats.show', $candidature->user) }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500">
                        Voir le profil complet
                        <x-icons.chevron-right class="ml-1 h-4 w-4" />
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Compétences -->
        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Compétences
                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                @if($candidature->user->competences->count() > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach($candidature->user->competences as $competence)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $competence->nom }}
                                @if($competence->pivot->niveau)
                                    ({{ ucfirst($competence->pivot->niveau) }})
                                @endif
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">Aucune compétence renseignée</p>
                @endif
            </div>
        </div>
        
        <!-- Actions -->
        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Gérer la candidature
                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <form action="{{ route('recruteur.candidatures.status', $candidature) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="statut" class="block text-sm font-medium text-gray-700">Statut *</label>
                            <select id="statut" name="statut" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="en_attente" {{ $candidature->statut === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                <option value="en_revue" {{ $candidature->statut === 'en_revue' ? 'selected' : '' }}>En revue</option>
                                <option value="entretien" {{ $candidature->statut === 'entretien' ? 'selected' : '' }}>Entretien</option>
                                <option value="accepte" {{ $candidature->statut === 'accepte' ? 'selected' : '' }}>Accepté</option>
                                <option value="rejete" {{ $candidature->statut === 'rejete' ? 'selected' : '' }}>Rejeté</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="feedback" class="block text-sm font-medium text-gray-700">Feedback</label>
                            <textarea id="feedback" name="feedback" rows="3"
                                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('feedback', $candidature->feedback) }}</textarea>
                            <p class="mt-2 text-sm text-gray-500">
                                Ce feedback sera visible par le candidat.
                            </p>
                        </div>
                        
                        <div class="pt-2">
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Enregistrer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Détails de la candidature -->
    <div class="lg:col-span-2">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Détails de la candidature
                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="prose max-w-none">
                    <h3 class="text-lg font-medium text-gray-900">Lettre de motivation</h3>
                    <div class="mt-2 p-4 bg-gray-50 rounded-md">
                        {!! nl2br(e($candidature->lettre_motivation)) !!}
                    </div>
                    
                    <h3 class="mt-6 text-lg font-medium text-gray-900">Documents joints</h3>
                    <div class="mt-2 space-y-3">
                        @forelse($candidature->documents as $document)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-md">
                                <div class="flex items-center">
                                    <x-icons.document class="h-5 w-5 text-gray-400" />
                                    <span class="ml-2 text-sm font-medium text-gray-900">{{ $document->nom_fichier }}</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="text-xs text-gray-500">{{ $document->taille_formatee }}</span>
                                    <a href="{{ $document->url }}" target="_blank" class="text-blue-600 hover:text-blue-500">
                                        <x-icons.download class="h-5 w-5" />
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Aucun document joint</p>
                        @endforelse
                    </div>
                    
                    @if($candidature->feedback)
                        <h3 class="mt-6 text-lg font-medium text-gray-900">Votre feedback</h3>
                        <div class="mt-2 p-4 bg-blue-50 rounded-md">
                            {!! nl2br(e($candidature->feedback)) !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Détails de l'offre -->
        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Détails de l'offre
                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <h4 class="text-md font-medium text-gray-900">{{ $candidature->offreEmploi->titre }}</h4>
                
                <div class="mt-4 prose max-w-none">
                    {!! Str::limit($candidature->offreEmploi->description, 300) !!}
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('recruteur.offres.show', $candidature->offreEmploi) }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500">
                        Voir l'offre complète
                        <x-icons.chevron-right class="ml-1 h-4 w-4" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<x-heroicon-o-user />
@endsection