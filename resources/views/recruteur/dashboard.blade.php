<!-- resources/views/recruteur/dashboard.blade.php -->

@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('header')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">
            Bonjour, {{ auth()->user()->prenom }} !
        </h1>
    </div>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <!-- Statistiques -->
    <div class="lg:col-span-3">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Statistiques
                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                    <x-icons.briefcase class="h-6 w-6 text-white" />
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-500 truncate">Offres actives</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['offres_actives'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-4 sm:px-6">
                            <div class="text-sm">
                                <a href="{{ route('recruteur.offres') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                                    Voir toutes les offres
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                    <x-icons.document-text class="h-6 w-6 text-white" />
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-500 truncate">Candidatures totales</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['candidatures_total'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-4 sm:px-6">
                            <div class="text-sm">
                                <a href="{{ route('recruteur.candidatures') }}" class="font-medium text-blue-600 hover:text-blue-500">
                                    Voir les candidatures
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                    <x-icons.user-group class="h-6 w-6 text-white" />
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-500 truncate">Candidats en entretien</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['candidatures_entretien'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-4 sm:px-6">
                            <div class="text-sm">
                                <a href="{{ route('recruteur.candidatures') }}?statut=entretien" class="font-medium text-green-600 hover:text-green-500">
                                    Voir les entretiens
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dernières candidatures -->
    <div class="lg:col-span-2">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Dernières candidatures
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Les 5 dernières candidatures reçues
                </p>
            </div>
            <div class="bg-white">
                <ul class="divide-y divide-gray-200">
                    @forelse($candidaturesRecent as $candidature)
                        <li>
                            <a href="{{ route('recruteur.candidatures.show', $candidature) }}" class="block hover:bg-gray-50">
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-blue-600 truncate">{{ $candidature->offreEmploi->titre }}</p>
                                        <div class="ml-2 flex-shrink-0 flex">
                                            <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $candidature->status_badge_color }}">
                                                {{ $candidature->statut_label }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-2 sm:flex sm:justify-between">
                                        <div class="sm:flex">
                                            <p class="flex items-center text-sm text-gray-500">
                                                <x-icons.user class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                                                {{ $candidature->user->fullName }}
                                            </p>
                                            <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                                <x-icons.calendar class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                                                Postulé le {{ $candidature->created_at->isoFormat('LL') }}
                                            </p>
                                        </div>
                                        <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                            <x-icons.star class="flex-shrink-0 mr-1.5 h-5 w-5 text-yellow-400" />
                                            <p>
                                                {{ $candidature->matching_score }}% de match
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @empty
                        <li class="px-4 py-12 text-center">
                            <x-icons.document-text class="mx-auto h-12 w-12 text-gray-400" />
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune candidature récente</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Vous n'avez pas encore reçu de candidatures.
                            </p>
                        </li>
                    @endforelse
                </ul>
            </div>
            @if($candidaturesRecent->count() > 0)
                <div class="bg-gray-50 px-4 py-4 sm:px-6 border-t border-gray-200">
                    <div class="text-sm">
                        <a href="{{ route('recruteur.candidatures', $offre) }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Voir toutes les candidatures
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Offres récentes -->
    <div class="lg:col-span-1">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Vos offres récentes
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Les 3 dernières offres publiées
                </p>
            </div>
            <div class="bg-white">
                <ul class="divide-y divide-gray-200">
                    @forelse($offresRecent as $offre)
                        <li>
                            <a href="{{ route('recruteur.offres.show', $offre) }}" class="block hover:bg-gray-50">
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-blue-600 truncate">{{ $offre->titre }}</p>
                                        <div class="ml-2 flex-shrink-0 flex">
                                            <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $offre->status_badge_color }}">
                                                {{ $offre->statut_label }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-2 sm:flex sm:justify-between">
                                        <div class="sm:flex">
                                            <p class="flex items-center text-sm text-gray-500">
                                                <x-icons.calendar class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                                                Publiée le {{ $offre->created_at->isoFormat('LL') }}
                                            </p>
                                        </div>
                                        <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                            <x-icons.document-text class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                                            {{ $offre->candidatures_count }} candidatures
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @empty
                        <li class="px-4 py-12 text-center">
                            <x-icons.briefcase class="mx-auto h-12 w-12 text-gray-400" />
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune offre récente</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Vous n'avez pas encore publié d'offres.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('recruteur.offres.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <x-icons.plus class="mr-2 -ml-1 h-5 w-5" />
                                    Créer une offre
                                </a>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>
            @if($offresRecent->count() > 0)
                <div class="bg-gray-50 px-4 py-4 sm:px-6 border-t border-gray-200">
                    <div class="text-sm">
                        <a href="{{ route('recruteur.offres') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Voir toutes les offres
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<x-heroicons.user class="h-5 w-5" />
@endsection