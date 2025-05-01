<!-- resources/views/recruteur/candidatures.blade.php -->

@extends('layouts.app')

@section('title', 'Candidatures pour ' . $offre->titre)

@section('header')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    Candidatures pour "{{ $offre->titre }}"
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
                        {{ $candidatures->total() }} candidature(s)
                    </div>
                </div>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('recruteur.offres.show', $offre) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Retour à l'offre
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="flex flex-col">
    <!-- Filtres -->
    <div class="bg-white shadow sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:p-6">
            <form method="GET" action="{{ route('recruteur.candidatures', $offre) }}" class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                    <select id="statut" name="statut" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">Tous les statuts</option>
                        <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="en_revue" {{ request('statut') === 'en_revue' ? 'selected' : '' }}>En revue</option>
                        <option value="entretien" {{ request('statut') === 'entretien' ? 'selected' : '' }}>Entretien</option>
                        <option value="accepte" {{ request('statut') === 'accepte' ? 'selected' : '' }}>Accepté</option>
                        <option value="rejete" {{ request('statut') === 'rejete' ? 'selected' : '' }}>Rejeté</option>
                    </select>
                </div>
                
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Recherche</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           placeholder="Nom, email...">
                </div>
                
                <div class="flex items-end space-x-3">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Filtrer
                    </button>
                    <a href="{{ route('recruteur.candidatures', $offre) }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Liste des candidatures -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <ul class="divide-y divide-gray-200">
            @forelse($candidatures as $candidature)
                <li>
                    <div class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    @if($candidature->user->photo)
                                        <img class="h-10 w-10 rounded-full" src="{{ Storage::url($candidature->user->photo) }}" alt="">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-medium">
                                            {{ substr($candidature->user->prenom, 0, 1) }}{{ substr($candidature->user->nom, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-blue-600">{{ $candidature->user->fullName }}</p>
                                    <p class="text-sm text-gray-500">{{ $candidature->user->email }}</p>
                                </div>
                            </div>
                            <div class="ml-2 flex-shrink-0 flex">
                                <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $candidature->status_badge_color }}">
                                    {{ $candidature->statut_label }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-2 sm:flex sm:justify-between">
                            <div class="sm:flex">
                                <p class="flex items-center text-sm text-gray-500">
                                    <x-icons.calendar class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                                    Postulé le {{ $candidature->created_at->isoFormat('LL') }}
                                </p>
                            </div>
                            <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                <a href="{{ route('recruteur.candidatures.show', $candidature) }}" class="text-blue-600 hover:text-blue-500">
                                    Voir détails
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-4 py-12 text-center">
                    <x-icons.document-text class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune candidature</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Aucune candidature ne correspond à vos critères de recherche.
                    </p>
                </li>
            @endforelse
        </ul>
        
        @if($candidatures->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $candidatures->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
<x-heroicon-o-user />
@endsection