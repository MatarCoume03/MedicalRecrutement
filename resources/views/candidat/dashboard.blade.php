<!-- resources/views/candidat/dashboard.blade.php -->

@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('header')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">
                Bonjour, {{ auth()->user()->prenom }} !
            </h1>
            <a href="{{ route('candidat.offres') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Voir toutes les offres
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <!-- Profil complet -->
    <div class="lg:col-span-1">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                        <x-icons.user class="h-6 w-6 text-white" />
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <h3 class="text-lg font-medium text-gray-900">Profil complet</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            @if(auth()->user()->candidatProfil->isComplete())
                                <span class="text-green-600">100% complet</span>
                            @else
                                <span class="text-yellow-600">{{ auth()->user()->candidatProfil->completionPercentage() }}% complet</span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('candidat.profil') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500">
                        Compléter mon profil
                        <x-icons.chevron-right class="ml-1 h-4 w-4" />
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Compétences -->
    <div class="lg:col-span-1">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                        <x-icons.tag class="h-6 w-6 text-white" />
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <h3 class="text-lg font-medium text-gray-900">Compétences</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ auth()->user()->competences->count() }} compétences enregistrées
                        </p>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('candidat.profil') }}#competences" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500">
                        Gérer mes compétences
                        <x-icons.chevron-right class="ml-1 h-4 w-4" />
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents -->
    <div class="lg:col-span-1">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                        <x-icons.folder class="h-6 w-6 text-white" />
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <h3 class="text-lg font-medium text-gray-900">Documents</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ auth()->user()->documents->count() }} documents téléversés
                        </p>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('documents.index') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500">
                        Gérer mes documents
                        <x-icons.chevron-right class="ml-1 h-4 w-4" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Offres récentes -->
<div class="mt-8">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Offres récentes</h2>
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @forelse($offresRecent as $offre)
                <li>
                    <a href="{{ route('candidat.offres.show', $offre) }}" class="block hover:bg-gray-50">
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-blue-600 truncate">{{ $offre->titre }}</p>
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
                                        Clôture le 
                                        <time datetime="{{ $offre->date_limite->format('Y-m-d') }}">
                                            {{ $offre->date_limite->isoFormat('LL') }}
                                        </time>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            @empty
                <li class="px-4 py-4 text-center text-gray-500">
                    Aucune offre récente disponible
                </li>
            @endforelse
        </ul>
    </div>
</div>

<!-- Candidatures récentes -->
<div class="mt-8">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Mes dernières candidatures</h2>
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @forelse($candidatures as $candidature)
                <li>
                    <div class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-blue-600 truncate">
                                {{ $candidature->offreEmploi->titre }}
                            </p>
                            <div class="ml-2 flex-shrink-0 flex">
                                <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $candidature->status_badge_color }}">
                                    {{ $candidature->statut_label }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-2 sm:flex sm:justify-between">
                            <div class="sm:flex">
                                <p class="flex items-center text-sm text-gray-500">
                                    <x-icons.building-office class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                                    {{ $candidature->offreEmploi->user->recruteurProfil->entreprise ?? 'Non spécifié' }}
                                </p>
                                <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                    <x-icons.calendar class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                                    Postulé le 
                                    <time datetime="{{ $candidature->created_at->format('Y-m-d') }}">
                                        {{ $candidature->created_at->isoFormat('LL') }}
                                    </time>
                                </p>
                            </div>
                            <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                <a href="{{ route('candidat.candidatures.show', $candidature) }}" class="text-blue-600 hover:text-blue-500">
                                    Voir détails
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-4 py-4 text-center text-gray-500">
                    Vous n'avez postulé à aucune offre pour le moment
                </li>
            @endforelse
        </ul>
    </div>
    @if($candidatures->count() > 0)
        <div class="px-4 py-4 sm:px-6 text-right">
            <a href="{{ route('candidat.candidatures') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                Voir toutes mes candidatures
            </a>
        </div>
    @endif
</div>
<x-heroicon-o-user />
@endsection