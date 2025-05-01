<!-- resources/views/candidat/candidature-show.blade.php -->

@extends('layouts.app')

@section('title', 'Candidature pour ' . $candidature->offreEmploi->titre)

@section('header')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    Candidature pour "{{ $candidature->offreEmploi->titre }}"
                </h1>
                <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <x-icons.building-office class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                        {{ $candidature->offreEmploi->user->recruteurProfil->entreprise ?? 'Non spécifié' }}
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <x-icons.calendar class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                        Postulé le {{ $candidature->created_at->isoFormat('LL') }}
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $candidature->status_badge_color }}">
                            {{ $candidature->statut_label }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 md:mt-0">
                <form action="{{ route('candidat.candidatures.destroy', $candidature) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette candidature ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <x-icons.trash class="mr-2 -ml-1 h-5 w-5" />
                        Annuler la candidature
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <!-- Détails de la candidature -->
    <div class="lg:col-span-2">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Détails de votre candidature
                </h3>
            </div>
            
            <div class="px-4 py-5 sm:p-6">
                <div class="prose max-w-none">
                    <h3 class="text-lg font-medium text-gray-900">Lettre de motivation</h3>
                    <div class="mt-2 p-4 bg-gray-50 rounded-md">
                        {!! nl2br(e($candidature->lettre_motivation)) !!}
                    </div>
                    
                    <h3 class="mt-6 text-lg font-medium text-gray-900">CV envoyé</h3>
                    <div class="mt-2">
                        @if($candidature->documents->count() > 0)
                            @foreach($candidature->documents as $document)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-md">
                                    <div class="flex items-center">
                                        <x-icons.document class="h-5 w-5 text-gray-400" />
                                        <span class="ml-2 text-sm font-medium text-gray-900">{{ $document->nom_fichier }}</span>
                                    </div>
                                    <a href="{{ $document->url }}" target="_blank" class="ml-4 text-sm font-medium text-blue-600 hover:text-blue-500">
                                        Télécharger
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <p class="text-sm text-gray-500">Aucun document trouvé</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Feedback -->
        @if($candidature->feedback)
            <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Feedback du recruteur
                    </h3>
                </div>
                
                <div class="px-4 py-5 sm:p-6">
                    <div class="prose max-w-none">
                        <div class="p-4 bg-blue-50 rounded-md">
                            {!! nl2br(e($candidature->feedback)) !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Détails de l'offre -->
    <div class="lg:col-span-1">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Détails de l'offre
                </h3>
            </div>
            
            <div class="px-4 py-5 sm:p-6">
                <h4 class="text-md font-medium text-gray-900">{{ $candidature->offreEmploi->titre }}</h4>
                
                <dl class="mt-4 space-y-4">
                    <div class="flex items-start">
                        <dt class="flex-shrink-0">
                            <x-icons.briefcase class="h-5 w-5 text-gray-400" />
                        </dt>
                        <dd class="ml-3 text-sm text-gray-700">
                            <p class="font-medium">Type de contrat</p>
                            <p class="mt-1">{{ $candidature->offreEmploi->type_contrat }}</p>
                        </dd>
                    </div>
                    
                    <div class="flex items-start">
                        <dt class="flex-shrink-0">
                            <x-icons.map-pin class="h-5 w-5 text-gray-400" />
                        </dt>
                        <dd class="ml-3 text-sm text-gray-700">
                            <p class="font-medium">Localisation</p>
                            <p class="mt-1">{{ $candidature->offreEmploi->localisation }}</p>
                        </dd>
                    </div>
                    
                    <div class="flex items-start">
                        <dt class="flex-shrink-0">
                            <x-icons.calendar class="h-5 w-5 text-gray-400" />
                        </dt>
                        <dd class="ml-3 text-sm text-gray-700">
                            <p class="font-medium">Date limite</p>
                            <p class="mt-1">{{ $candidature->offreEmploi->date_limite->isoFormat('LL') }}</p>
                        </dd>
                    </div>
                    
                    <div class="flex items-start">
                        <dt class="flex-shrink-0">
                            <x-icons.tag class="h-5 w-5 text-gray-400" />
                        </dt>
                        <dd class="ml-3 text-sm text-gray-700">
                            <p class="font-medium">Spécialité</p>
                            <p class="mt-1">{{ $candidature->offreEmploi->specialite_requise }}</p>
                        </dd>
                    </div>
                </dl>
                
                <div class="mt-6">
                    <a href="{{ route('candidat.offres.show', $candidature->offreEmploi) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Voir l'offre complète
                    </a>
                </div>
            </div>
        </div>
        
        <!-- À propos du recruteur -->
        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    À propos du recruteur
                </h3>
            </div>
            
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    @if($candidature->offreEmploi->user->recruteurProfil->logo)
                        <img class="h-12 w-12 rounded-full" src="{{ Storage::url($candidature->offreEmploi->user->recruteurProfil->logo) }}" alt="Logo de l'entreprise">
                    @else
                        <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-medium">
                            {{ substr($candidature->offreEmploi->user->recruteurProfil->entreprise, 0, 2) }}
                        </div>
                    @endif
                    <div class="ml-4">
                        <h4 class="text-sm font-medium text-gray-900">{{ $candidature->offreEmploi->user->recruteurProfil->entreprise }}</h4>
                        <p class="text-sm text-gray-500">{{ $candidature->offreEmploi->user->recruteurProfil->secteur_activite }}</p>
                    </div>
                </div>
                
                @if($candidature->offreEmploi->user->recruteurProfil->description_entreprise)
                    <div class="mt-4 text-sm text-gray-700">
                        {{ Str::limit($candidature->offreEmploi->user->recruteurProfil->description_entreprise, 200) }}
                    </div>
                @endif
                
                <div class="mt-4">
                    <a href="mailto:{{ $candidature->offreEmploi->user->email }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500">
                        <x-icons.mail class="mr-1 h-4 w-4" />
                        Contacter le recruteur
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<x-heroicon-o-user />
@endsection