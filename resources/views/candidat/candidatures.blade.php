<!-- resources/views/candidat/candidatures.blade.php -->

@extends('layouts.app')

@section('title', 'Mes candidatures')

@section('header')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">
            Mes candidatures
        </h1>
    </div>
</div>
@endsection

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <ul class="divide-y divide-gray-200">
        @forelse($candidatures as $candidature)
            <li>
                <a href="{{ route('candidat.candidatures.show', $candidature) }}" class="block hover:bg-gray-50">
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
                                    <x-icons.building-office class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                                    {{ $candidature->offreEmploi->user->recruteurProfil->entreprise ?? 'Non spécifié' }}
                                </p>
                                <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                    <x-icons.map-pin class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                                    {{ $candidature->offreEmploi->localisation }}
                                </p>
                            </div>
                            <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                <x-icons.calendar class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                                <p>
                                    Postulé le 
                                    <time datetime="{{ $candidature->created_at->format('Y-m-d') }}">
                                        {{ $candidature->created_at->isoFormat('LL') }}
                                    </time>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
        @empty
            <li class="px-4 py-12 text-center">
                <x-icons.document-text class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune candidature</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Vous n'avez postulé à aucune offre pour le moment.
                </p>
                <div class="mt-6">
                    <a href="{{ route('candidat.offres') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <x-icons.briefcase class="mr-2 -ml-1 h-5 w-5" />
                        Voir les offres disponibles
                    </a>
                </div>
            </li>
        @endforelse
    </ul>
    
    @if($candidatures->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $candidatures->links() }}
        </div>
    @endif
</div>
<x-heroicon-o-user />
@endsection