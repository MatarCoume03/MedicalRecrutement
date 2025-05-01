<!-- resources/views/candidat/offre-show.blade.php -->

@extends('layouts.app')

@section('title', $offre->titre)

@section('header')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
            <div>
                <div class="flex items-center">
                    <h1 class="text-3xl font-bold text-gray-900">
                        {{ $offre->titre }}
                    </h1>
                    @if($offre->is_urgent)
                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Urgent
                        </span>
                    @endif
                </div>
                <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <x-icons.building-office class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                        {{ $offre->user->recruteurProfil->entreprise ?? 'Non spécifié' }}
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <x-icons.map-pin class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                        {{ $offre->localisation }}
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <x-icons.calendar class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" />
                        Clôture le {{ $offre->date_limite->isoFormat('LL') }}
                    </div>
                </div>
            </div>
            
            <div class="mt-4 md:mt-0">
                @if($hasApplied)
                    <span class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600">
                        <x-icons.check class="mr-2 -ml-1 h-5 w-5" />
                        Déjà postulé
                    </span>
                @else
                    <button @click="open = true" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <x-icons.paper-airplane class="mr-2 -ml-1 h-5 w-5" />
                        Postuler
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Détails de l'offre
        </h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">
            Publiée le {{ $offre->created_at->isoFormat('LL') }}
        </p>
    </div>
    
    <div class="px-4 py-5 sm:p-6">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Colonne principale -->
            <div class="lg:col-span-2">
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
            
            <!-- Colonne latérale -->
            <div class="lg:col-span-1">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900">Informations</h3>
                    
                    <dl class="mt-4 space-y-4">
                        <div class="flex items-start">
                            <dt class="flex-shrink-0">
                                <x-icons.briefcase class="h-5 w-5 text-gray-400" />
                            </dt>
                            <dd class="ml-3 text-sm text-gray-700">
                                <p class="font-medium">Type de contrat</p>
                                <p class="mt-1">{{ $offre->type_contrat }}</p>
                            </dd>
                        </div>
                        
                        <div class="flex items-start">
                            <dt class="flex-shrink-0">
                                <x-icons.map-pin class="h-5 w-5 text-gray-400" />
                            </dt>
                            <dd class="ml-3 text-sm text-gray-700">
                                <p class="font-medium">Localisation</p>
                                <p class="mt-1">{{ $offre->localisation }}</p>
                            </dd>
                        </div>
                        
                        <div class="flex items-start">
                            <dt class="flex-shrink-0">
                                <x-icons.calendar class="h-5 w-5 text-gray-400" />
                            </dt>
                            <dd class="ml-3 text-sm text-gray-700">
                                <p class="font-medium">Date limite</p>
                                <p class="mt-1">{{ $offre->date_limite->isoFormat('LL') }}</p>
                            </dd>
                        </div>
                        
                        @if($offre->salaire_min || $offre->salaire_max)
                            <div class="flex items-start">
                                <dt class="flex-shrink-0">
                                    <x-icons.currency-euro class="h-5 w-5 text-gray-400" />
                                </dt>
                                <dd class="ml-3 text-sm text-gray-700">
                                    <p class="font-medium">Salaire</p>
                                    <p class="mt-1">
                                        @if($offre->salaire_min && $offre->salaire_max)
                                            {{ number_format($offre->salaire_min, 0, ',', ' ') }} - {{ number_format($offre->salaire_max, 0, ',', ' ') }} €
                                        @elseif($offre->salaire_min)
                                            À partir de {{ number_format($offre->salaire_min, 0, ',', ' ') }} €
                                        @else
                                            Jusqu'à {{ number_format($offre->salaire_max, 0, ',', ' ') }} €
                                        @endif
                                    </p>
                                </dd>
                            </div>
                        @endif
                    </dl>
                    
                    <!-- À propos du recruteur -->
                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900">À propos du recruteur</h3>
                        <div class="mt-4 flex items-center">
                            @if($offre->user->recruteurProfil->logo)
                                <img class="h-12 w-12 rounded-full" src="{{ Storage::url($offre->user->recruteurProfil->logo) }}" alt="Logo de l'entreprise">
                            @else
                                <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-medium">
                                    {{ substr($offre->user->recruteurProfil->entreprise, 0, 2) }}
                                </div>
                            @endif
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">{{ $offre->user->recruteurProfil->entreprise }}</h4>
                                <p class="text-sm text-gray-500">{{ $offre->user->recruteurProfil->secteur_activite }}</p>
                            </div>
                        </div>
                        
                        @if($offre->user->recruteurProfil->description_entreprise)
                            <div class="mt-4 text-sm text-gray-700">
                                {{ Str::limit($offre->user->recruteurProfil->description_entreprise, 200) }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de postulation -->
<div x-data="{ open: false }" x-cloak>
    <div x-show="open" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div>
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                        <x-icons.paper-airplane class="h-6 w-6 text-blue-600" />
                    </div>
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Postuler à cette offre
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Vous êtes sur le point de postuler à l'offre "{{ $offre->titre }}". Veuillez vérifier les informations ci-dessous.
                            </p>
                        </div>
                    </div>
                </div>
                
                <form class="mt-5 space-y-4" action="{{ route('candidat.postuler', $offre) }}" method="POST">
                    @csrf
                    
                    <div>
                        <label for="lettre_motivation" class="block text-sm font-medium text-gray-700">Lettre de motivation</label>
                        <div class="mt-1">
                            <textarea id="lettre_motivation" name="lettre_motivation" rows="4" required class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('lettre_motivation') }}</textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            Expliquez pourquoi vous êtes le candidat idéal pour ce poste.
                        </p>
                        @error('lettre_motivation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="cv_id" class="block text-sm font-medium text-gray-700">CV à envoyer</label>
                        <select id="cv_id" name="cv_id" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Sélectionnez un CV</option>
                            @foreach(auth()->user()->documents->where('type', 'cv') as $document)
                                <option value="{{ $document->id }}" {{ old('cv_id') == $document->id ? 'selected' : '' }}>
                                    {{ $document->nom_fichier }} ({{ $document->taille_formatee }})
                                </option>
                            @endforeach
                        </select>
                        @error('cv_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <div class="mt-2">
                            <a href="{{ route('documents.index') }}" class="text-sm text-blue-600 hover:text-blue-500">
                                <x-icons.plus class="inline h-4 w-4" />
                                Ajouter un nouveau CV
                            </a>
                        </div>
                    </div>
                    
                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:col-start-2 sm:text-sm">
                            Envoyer ma candidature
                        </button>
                        <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<x-heroicon-o-user />
@endsection