<!-- resources/views/candidat/offres.blade.php -->

@extends('layouts.app')

@section('title', 'Offres d\'emploi')

@section('header')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-4 md:mb-0">
                Offres d'emploi
            </h1>
            
            <!-- Filtres -->
            <div x-data="{ filtersOpen: false }" class="relative">
                <button @click="filtersOpen = !filtersOpen" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <x-icons.filter class="mr-2 h-4 w-4" />
                    Filtres
                </button>
                
                <!-- Panel des filtres -->
                <div x-show="filtersOpen" @click.away="filtersOpen = false" 
                     class="origin-top-right absolute right-0 mt-2 w-72 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                    <form class="p-4 space-y-4" method="GET" action="{{ route('candidat.offres') }}">
                        <!-- Recherche par mot-clé -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Mot-clé</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        
                        <!-- Spécialité -->
                        <div>
                            <label for="specialite" class="block text-sm font-medium text-gray-700">Spécialité</label>
                            <select id="specialite" name="specialite" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Toutes spécialités</option>
                                @foreach($specialites as $specialite)
                                    <option value="{{ $specialite }}" {{ request('specialite') === $specialite ? 'selected' : '' }}>{{ $specialite }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Localisation -->
                        <div>
                            <label for="localisation" class="block text-sm font-medium text-gray-700">Localisation</label>
                            <input type="text" name="localisation" id="localisation" value="{{ request('localisation') }}"
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        
                        <!-- Type de contrat -->
                        <div>
                            <label for="type_contrat" class="block text-sm font-medium text-gray-700">Type de contrat</label>
                            <select id="type_contrat" name="type_contrat" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Tous types</option>
                                <option value="CDI" {{ request('type_contrat') === 'CDI' ? 'selected' : '' }}>CDI</option>
                                <option value="CDD" {{ request('type_contrat') === 'CDD' ? 'selected' : '' }}>CDD</option>
                                <option value="Interim" {{ request('type_contrat') === 'Interim' ? 'selected' : '' }}>Intérim</option>
                                <option value="Freelance" {{ request('type_contrat') === 'Freelance' ? 'selected' : '' }}>Freelance</option>
                            </select>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex space-x-3">
                            <button type="submit" class="flex-1 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Appliquer
                            </button>
                            <a href="{{ route('candidat.offres') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Réinitialiser
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <ul class="divide-y divide-gray-200">
        @forelse($offres as $offre)
            <li>
                <a href="{{ route('candidat.offres.show', $offre) }}" class="block hover:bg-gray-50">
                    <div class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <p class="text-sm font-medium text-blue-600 truncate">{{ $offre->titre }}</p>
                                @if($offre->is_urgent)
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Urgent
                                    </span>
                                @endif
                            </div>
                            <div class="ml-2 flex-shrink-0 flex">
                                <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $offre->type_contrat }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-2 sm:flex sm:justify-between">
                            <div class="sm:flex">
                                <p class="flex items-center text-sm text-gray-500">
                                    <x-icons.building-office class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                                    {{ $offre->user->recruteurProfil->entreprise ?? 'Non spécifié' }}
                                </p>
                                <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                    <x-icons.map-pin class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                                    {{ $offre->localisation }}
                                </p>
                            </div>
                            <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                <x-icons.calendar class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                                <p>
                                    Publiée le 
                                    <time datetime="{{ $offre->created_at->format('Y-m-d') }}">
                                        {{ $offre->created_at->isoFormat('LL') }}
                                    </time>
                                </p>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="flex items-center text-sm text-gray-500">
                                <x-icons.tag class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                                <p class="truncate">
                                    {{ $offre->competences->take(3)->pluck('nom')->join(', ') }}
                                    @if($offre->competences->count() > 3)
                                        +{{ $offre->competences->count() - 3 }} autres
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
        @empty
            <li class="px-4 py-12 text-center">
                <x-icons.briefcase class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune offre disponible</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Aucune offre ne correspond à vos critères de recherche.
                </p>
                <div class="mt-6">
                    <a href="{{ route('candidat.offres') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <x-icons.refresh class="mr-2 -ml-1 h-5 w-5" />
                        Réinitialiser les filtres
                    </a>
                </div>
            </li>
        @endforelse
    </ul>
    
    @if($offres->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $offres->withQueryString()->links() }}
        </div>
    @endif
</div>
<x-heroicon-o-user />
@endsection