<!-- resources/views/recruteur/offre-show.blade.php -->

@extends('layouts.app')

@section('title', $offre->titre)

@section('header')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    {{ $offre->titre }}
                </h1>
                <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $offre->status_badge }}">
                            {{ $offre->statut }}
                        </span>
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <x-icons.calendar class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                        Clôture le {{ $offre->date_limite->isoFormat('LL') }}
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <x-icons.users class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                        {{ $offre->candidatures_count }} candidature(s)
                    </div>
                </div>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
                <a href="{{ route('recruteur.offres.edit', $offre) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <x-icons.pencil class="mr-2 -ml-1 h-5 w-5" />
                    Modifier
                </a>
                <a href="{{ route('recruteur.candidatures', $offre) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Voir candidatures
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <!-- Détails de l'offre -->
    <div class="lg:col-span-2">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Détails de l'offre
                </h3>
            </div>
            
            <div class="px-4 py-5 sm:p-6">
                <div class="prose max-w-none">
                    <h3 class="text-lg font-medium text-gray-900">Description du poste</h3>
                    {!! $offre->description !!}
                    
                    <h3 class="mt-6 text-lg font-medium text-gray-900">Profil recherché</h3>
                    <ul class="list-disc pl-5">
                        <li>Spécialité : {{ $offre->specialite_requise }}</li>
                        @if($offre->annees_experience_requises)
                            <li>{{ $offre->annees_experience_requises }} ans d'expérience minimum</li>
                        @endif
                        @if($offre->niveau_etude_requis)
                            <li>Niveau d'étude : {{ $offre->niveau_etude_requis }}</li>
                        @endif
                    </ul>
                </div>
                
                <!-- Compétences requises -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900">Compétences requises</h3>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($offre->competences as $competence)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $competence->nom }}
                                @if($competence->pivot->niveau_requis)
                                    ({{ ucfirst($competence->pivot->niveau_requis) }})
                                @endif
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Informations complémentaires -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Statut et dates -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Statut
                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <dl class="space-y-4">
                    <div class="flex items-start">
                        <dt class="flex-shrink-0">
                            <x-icons.status class="h-5 w-5 text-gray-400" />
                        </dt>
                        <dd class="ml-3 text-sm text-gray-700">
                            <p class="font-medium">Statut</p>
                            <p class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $offre->status_badge }}">
                                    {{ $offre->statut }}
                                </span>
                            </p>
                        </dd>
                    </div>
                    
                    <div class="flex items-start">
                        <dt class="flex-shrink-0">
                            <x-icons.calendar class="h-5 w-5 text-gray-400" />
                        </dt>
                        <dd class="ml-3 text-sm text-gray-700">
                            <p class="font-medium">Date de publication</p>
                            <p class="mt-1">{{ $offre->created_at->isoFormat('LL') }}</p>
                        </dd>
                    </div>
                    
                    <div class="flex items-start">
                        <dt class="flex-shrink-0">
                            <x-icons.clock class="h-5 w-5 text-gray-400" />
                        </dt>
                        <dd class="ml-3 text-sm text-gray-700">
                            <p class="font-medium">Date limite</p>
                            <p class="mt-1">{{ $offre->date_limite->isoFormat('LL') }}</p>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
        
        <!-- Candidatures -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Candidatures
                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <x-icons.users class="h-8 w-8 text-gray-400" />
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">Total</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $offre->candidatures_count }}</p>
                        </div>
                    </div>
                    <a href="{{ route('recruteur.candidatures', $offre) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Voir toutes
                    </a>
                </div>
                
                <div class="mt-6 grid grid-cols-3 gap-4 text-center">
                    <div>
                        <p class="text-sm font-medium text-gray-500">En attente</p>
                        <p class="text-lg font-semibold text-yellow-600">{{ $offre->candidatures_en_attente }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">En revue</p>
                        <p class="text-lg font-semibold text-blue-600">{{ $offre->candidatures_en_revue }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Acceptées</p>
                        <p class="text-lg font-semibold text-green-600">{{ $offre->candidatures_acceptees }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Actions
                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6 space-y-4">
                @if($offre->statut === 'en_attente')
                    <p class="text-sm text-gray-500">Cette offre est en attente de validation par l'administrateur.</p>
                @endif
                
                <a href="{{ route('recruteur.offres.edit', $offre) }}" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <x-icons.pencil class="mr-2 h-4 w-4" />
                    Modifier l'offre
                </a>
                
                <form action="{{ route('recruteur.offres.destroy', $offre) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <x-icons.trash class="mr-2 h-4 w-4" />
                        Supprimer l'offre
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<x-heroicon-o-user />
@endsection