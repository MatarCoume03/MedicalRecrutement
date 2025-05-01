<!-- resources/views/candidat/profil.blade.php -->

@extends('layouts.app')

@section('title', 'Mon profil')

@section('header')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">
                Mon profil
            </h1>
            <div class="flex items-center space-x-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                    {{ auth()->user()->candidatProfil->isComplete() ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ auth()->user()->candidatProfil->isComplete() ? 'Complet' : 'Incomplet' }}
                </span>
                <a href="{{ route('candidat.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Retour
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<form action="{{ route('candidat.profil.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Informations personnelles
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Ces informations seront visibles par les recruteurs.
            </p>
        </div>
        
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-6">
                <!-- Photo de profil -->
                <div class="sm:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Photo</label>
                    <div class="mt-1 flex items-center">
                        <div x-data="{ photoPreview: '{{ auth()->user()->photo ? Storage::url(auth()->user()->photo) : '' }}' }" class="relative">
                            <img x-show="photoPreview" :src="photoPreview" class="h-16 w-16 rounded-full object-cover">
                            <div x-show="!photoPreview" class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-medium">
                                {{ substr(auth()->user()->prenom, 0, 1) }}{{ substr(auth()->user()->nom, 0, 1) }}
                            </div>
                            <label for="photo" class="absolute bottom-0 right-0 bg-white p-1 rounded-full shadow-sm border border-gray-300 cursor-pointer">
                                <x-icons.camera class="h-4 w-4 text-gray-500" />
                                <input id="photo" name="photo" type="file" class="sr-only" @change="photoPreview = URL.createObjectURL($event.target.files[0])">
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Nom et prénom -->
                <div class="sm:col-span-3">
                    <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                    <input type="text" name="prenom" id="prenom" value="{{ old('prenom', auth()->user()->prenom) }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('prenom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="sm:col-span-2">
                    <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" name="nom" id="nom" value="{{ old('nom', auth()->user()->nom) }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('nom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Contact -->
                <div class="sm:col-span-3">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" value="{{ auth()->user()->email }}" disabled
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-100 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                
                <div class="sm:col-span-3">
                    <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                    <input type="text" name="telephone" id="telephone" value="{{ old('telephone', auth()->user()->telephone) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('telephone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Adresse -->
                <div class="sm:col-span-6">
                    <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse</label>
                    <input type="text" name="adresse" id="adresse" value="{{ old('adresse', auth()->user()->adresse) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('adresse')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Informations supplémentaires -->
                <div class="sm:col-span-2">
                    <label for="date_naissance" class="block text-sm font-medium text-gray-700">Date de naissance</label>
                    <input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance', optional(auth()->user()->candidatProfil->date_naissance)->format('Y-m-d')) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('date_naissance')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="sm:col-span-2">
                    <label for="genre" class="block text-sm font-medium text-gray-700">Genre</label>
                    <select id="genre" name="genre" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">Sélectionner...</option>
                        <option value="homme" {{ old('genre', auth()->user()->candidatProfil->genre) === 'homme' ? 'selected' : '' }}>Homme</option>
                        <option value="femme" {{ old('genre', auth()->user()->candidatProfil->genre) === 'femme' ? 'selected' : '' }}>Femme</option>
                        <option value="autre" {{ old('genre', auth()->user()->candidatProfil->genre) === 'autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                    @error('genre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="sm:col-span-2">
                    <label for="nationalite" class="block text-sm font-medium text-gray-700">Nationalité</label>
                    <input type="text" name="nationalite" id="nationalite" value="{{ old('nationalite', auth()->user()->candidatProfil->nationalite) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('nationalite')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="sm:col-span-3">
                    <label for="ville" class="block text-sm font-medium text-gray-700">Ville</label>
                    <input type="text" name="ville" id="ville" value="{{ old('ville', auth()->user()->candidatProfil->ville) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('ville')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="sm:col-span-3">
                    <label for="specialite_medicale" class="block text-sm font-medium text-gray-700">Spécialité médicale</label>
                    <input type="text" name="specialite_medicale" id="specialite_medicale" value="{{ old('specialite_medicale', auth()->user()->candidatProfil->specialite_medicale) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('specialite_medicale')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="sm:col-span-3">
                    <label for="niveau_etude" class="block text-sm font-medium text-gray-700">Niveau d'étude</label>
                    <input type="text" name="niveau_etude" id="niveau_etude" value="{{ old('niveau_etude', auth()->user()->candidatProfil->niveau_etude) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('niveau_etude')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="sm:col-span-3">
                    <label for="annees_experience" class="block text-sm font-medium text-gray-700">Années d'expérience</label>
                    <input type="number" name="annees_experience" id="annees_experience" min="0" value="{{ old('annees_experience', auth()->user()->candidatProfil->annees_experience) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('annees_experience')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Bio -->
                <div class="sm:col-span-6">
                    <label for="bio" class="block text-sm font-medium text-gray-700">À propos de moi</label>
                    <textarea id="bio" name="bio" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('bio', auth()->user()->candidatProfil->bio) }}</textarea>
                    @error('bio')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Langues -->
                <div class="sm:col-span-6" x-data="{ langues: {{ json_encode(old('langues', auth()->user()->candidatProfil->langues ?? [])) }}, nouvelleLangue: '' }">
                    <label class="block text-sm font-medium text-gray-700">Langues parlées</label>
                    <div class="mt-1">
                        <template x-for="(langue, index) in langues" :key="index">
                            <div class="flex items-center mb-2">
                                <input type="text" x-model="langues[index]" name="langues[]" 
                                       class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <button type="button" @click="langues.splice(index, 1)" class="ml-2 text-red-600 hover:text-red-800">
                                    <x-icons.trash class="h-5 w-5" />
                                </button>
                            </div>
                        </template>
                        <div class="flex">
                            <input type="text" x-model="nouvelleLangue" @keydown.enter.prevent="if (nouvelleLangue.trim() !== '') { langues.push(nouvelleLangue); nouvelleLangue = ''; }" 
                                   class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Ajouter une langue">
                            <button type="button" @click="if (nouvelleLangue.trim() !== '') { langues.push(nouvelleLangue); nouvelleLangue = ''; }" 
                                    class="ml-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Ajouter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Compétences -->
        <div class="px-4 py-5 sm:px-6 border-t border-gray-200" id="competences">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Mes compétences
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Ajoutez les compétences qui correspondent à votre profil.
            </p>
        </div>
        
        <div class="px-4 py-5 sm:p-6">
            <div class="space-y-4" x-data="{ competences: {{ json_encode($competences) }, mesCompetences: {{ json_encode(auth()->user()->competences->map(function($item) { return ['id' => $item->id, 'niveau' => $item->pivot->niveau]; })->toArray() } }, nouvelleCompetence: '' }">
                <!-- Compétences existantes -->
                <template x-for="(competence, index) in mesCompetences" :key="index">
                    <div class="flex items-center space-x-4">
                        <select x-model="mesCompetences[index].id" name="competences[][id]" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Sélectionner une compétence...</option>
                            <template x-for="competence in competences" :key="competence.id">
                                <option :value="competence.id" x-text="competence.nom" :selected="mesCompetences[index].id === competence.id"></option>
                            </template>
                        </select>
                        <select x-model="mesCompetences[index].niveau" name="competences[][niveau]" class="block w-48 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="debutant">Débutant</option>
                            <option value="intermediaire">Intermédiaire</option>
                            <option value="avance">Avancé</option>
                            <option value="expert">Expert</option>
                        </select>
                        <button type="button" @click="mesCompetences.splice(index, 1)" class="text-red-600 hover:text-red-800">
                            <x-icons.trash class="h-5 w-5" />
                        </button>
                    </div>
                </template>
                
                <!-- Ajouter une compétence -->
                <div class="flex items-center space-x-4">
                    <select x-model="nouvelleCompetence" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">Ajouter une compétence...</option>
                        <template x-for="competence in competences" :key="competence.id">
                            <option :value="competence.id" x-text="competence.nom"></option>
                        </template>
                    </select>
                    <select disabled class="block w-48 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-100">
                        <option>Niveau</option>
                    </select>
                    <button type="button" @click="if (nouvelleCompetence) { mesCompetences.push({id: nouvelleCompetence, niveau: 'intermediaire'}); nouvelleCompetence = ''; }" 
                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Ajouter
                    </button>
                </div>
                
                <!-- Compétence non listée -->
                <div class="mt-4">
                    <p class="text-sm text-gray-500 mb-2">Vous ne trouvez pas une compétence ?</p>
                    <a href="{{ route('competences.create') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <x-icons.plus class="mr-1 h-4 w-4" />
                        Proposer une nouvelle compétence
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="px-4 py-4 sm:px-6 border-t border-gray-200 bg-gray-50 text-right">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Enregistrer les modifications
            </button>
        </div>
    </div>
</form>
<x-heroicon-o-user />
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('competenceSearch', () => ({
            query: '',
            competences: [],
            
            init() {
                this.$watch('query', (value) => {
                    if (value.length < 2) return;
                    
                    fetch(`/api/competences/search?query=${encodeURIComponent(value)}`)
                        .then(response => response.json())
                        .then(data => this.competences = data);
                });
            }
        }));
    });
</script>
@endpush