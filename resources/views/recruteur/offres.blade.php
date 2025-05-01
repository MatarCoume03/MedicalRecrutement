<!-- resources/views/recruteur/offres.blade.php -->

@extends('layouts.app')

@section('title', 'Mes offres d\'emploi')

@section('header')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
            <h1 class="text-3xl font-bold text-gray-900">
                Mes offres d'emploi
            </h1>
            <a href="{{ route('recruteur.offres.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <x-icons.plus class="mr-2 -ml-1 h-5 w-5" />
                Nouvelle offre
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <ul class="divide-y divide-gray-200">
        @forelse($offres as $offre)
            <li>
                <a href="{{ route('recruteur.offres.show', $offre) }}" class="block hover:bg-gray-50">
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
                                <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $offre->status_badge_color }}">
                                    {{ $offre->statut_label }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-2 sm:flex sm:justify-between">
                            <div class="sm:flex">
                                <p class="flex items-center text-sm text-gray-500">
                                    <x-icons.map-pin class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                                    {{ $offre->localisation }}
                                </p>
                                <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                    <x-icons.briefcase class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                                    {{ $offre->type_contrat }}
                                </p>
                            </div>
                            <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                <x-icons.document-text class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                                {{ $offre->candidatures_count }} candidatures
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="flex items-center text-sm text-gray-500">
                                <x-icons.calendar class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                                <p>
                                    Publiée le 
                                    <time datetime="{{ $offre->created_at->format('Y-m-d') }}">
                                        {{ $offre->created_at->isoFormat('LL') }}
                                    </time>
                                    • Clôture le 
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
            <li class="px-4 py-12 text-center">
                <x-icons.briefcase class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune offre</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Vous n'avez pas encore publié d'offres d'emploi.
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
    
    @if($offres->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $offres->links() }}
        </div>
    @endif
</div>
<x-heroicon-o-user />
@endsection