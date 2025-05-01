<!-- resources/views/recruteur/offre-create.blade.php -->

@extends('layouts.app')

@section('title', 'Créer une nouvelle offre')

@section('header')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">
                Publier une nouvelle offre
            </h1>
            <a href="{{ route('recruteur.offres') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Retour à la liste
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
<form action="{{ route('recruteur.offres.store') }}" method="POST">
    @csrf
    
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Informations générales
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Remplissez les détails de votre offre d'emploi.
            </p>
        </div>
        
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 gap-6">
                <!-- Titre -->
                <div>
                    <label for="titre" class="block text-sm font-medium text-gray-700">Titre de l'offre *</label>
                    <input type="text" name="titre" id="titre" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('titre')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description du poste *</label>
                    <textarea id="description" name="description" rows="6" required
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <!-- Spécialité -->
                    <div>
                        <label for="specialite_requise" class="block text-sm font-medium text-gray-700">Spécialité *</label>
                        <input type="text" name="specialite_requise" id="specialite_requise" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('specialite_requise')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Type de contrat -->
                    <div>
                        <label for="type_contrat" class="block text-sm font-medium text-gray-700">Type de contrat *</label>
                        <select id="type_contrat" name="type_contrat" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Sélectionnez...</option>
                            <option value="CDI">CDI</option>
                            <option value="CDD">CDD</option>
                            <option value="Interim">Intérim</option>
                            <option value="Freelance">Freelance</option>
                        </select>
                        @error('type_contrat')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Localisation -->
                    <div>
                        <label for="localisation" class="block text-sm font-medium text-gray-700">Localisation *</label>
                        <input type="text" name="localisation" id="localisation" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('localisation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <!-- Salaire -->
                    <div>
                        <label for="salaire_min" class="block text-sm font-medium text-gray-700">Salaire min (€)</label>
                        <input type="number" name="salaire_min" id="salaire_min" min="0"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('salaire_min')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="salaire_max" class="block text-sm font-medium text-gray-700">Salaire max (€)</label>
                        <input type="number" name="salaire_max" id="salaire_max" min="0"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('salaire_max')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Date limite -->
                    <div>
                        <label for="date_limite" class="block text-sm font-medium text-gray-700">Date limite *</label>
                        <input type="date" name="date_limite" id="date_limite" required min="{{ now()->format('Y-m-d') }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('date_limite')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Expérience et éducation -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="annees_experience_requises" class="block text-sm font-medium text-gray-700">Années d'expérience</label>
                        <input type="number" name="annees_experience_requises" id="annees_experience_requises" min="0"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('annees_experience_requises')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="niveau_etude_requis" class="block text-sm font-medium text-gray-700">Niveau d'étude</label>
                        <input type="text" name="niveau_etude_requis" id="niveau_etude_requis"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('niveau_etude_requis')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Urgent -->
                <div class="flex items-center">
                    <input id="is_urgent" name="is_urgent" type="checkbox"
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_urgent" class="ml-2 block text-sm text-gray-900">
                        Marquer comme offre urgente
                    </label>
                </div>
                
                <!-- Compétences requises -->
                <div class="border-t border-gray-200 pt-6" x-data="{ competences: {{ json_encode($competences) }}, competencesSelectionnees: [] }">
                    <h3 class="text-lg font-medium text-gray-900">Compétences requises</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Sélectionnez les compétences nécessaires pour ce poste.
                    </p>
                    
                    <div class="mt-4">
                        <!-- Recherche de compétences -->
                        <div class="relative">
                            <input type="text" x-model="searchQuery" @input.debounce.300ms="searchCompetences()"
                                   class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   placeholder="Rechercher une compétence...">
                        </div>
                        
                        <!-- Liste des compétences -->
                        <div class="mt-4 space-y-3">
                            <template x-for="(competence, index) in competencesSelectionnees" :key="competence.id">
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-md">
                                    <div class="flex items-center">
                                        <span x-text="competence.nom" class="text-sm font-medium text-gray-900"></span>
                                        <template x-if="competence.niveau">
                                            <span class="ml-2 text-xs text-gray-500" x-text="'(Niveau: ' + competence.niveau + ')'"></span>
                                        </template>
                                    </div>
                                    <input type="hidden" :name="'competences[' + index + '][id]'" :value="competence.id">
                                    <div class="flex items-center space-x-3">
                                        <select :name="'competences[' + index + '][niveau]'" x-model="competence.niveau"
                                                class="block w-full border border-gray-300 rounded-md shadow-sm py-1 px-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="">Niveau</option>
                                            <option value="debutant">Débutant</option>
                                            <option value="intermediaire">Intermédiaire</option>
                                            <option value="avance">Avancé</option>
                                            <option value="expert">Expert</option>
                                        </select>
                                        <button type="button" @click="competencesSelectionnees.splice(index, 1)" class="text-red-600 hover:text-red-500">
                                            <x-icons.trash class="h-5 w-5" />
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                        
                        <!-- Suggestions -->
                        <div x-show="searchQuery && filteredCompetences.length > 0" class="mt-2 border border-gray-200 rounded-md shadow-sm">
                            <ul class="divide-y divide-gray-200 max-h-60 overflow-y-auto">
                                <template x-for="competence in filteredCompetences" :key="competence.id">
                                    <li class="p-3 hover:bg-gray-50 cursor-pointer" 
                                        @click="addCompetence(competence); searchQuery = ''">
                                        <span x-text="competence.nom" class="text-sm font-medium text-gray-900"></span>
                                        <span x-show="competence.categorie" x-text="' (' + competence.categorie + ')'" class="text-xs text-gray-500"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                        
                        <!-- Compétence non trouvée -->
                        <div x-show="searchQuery && filteredCompetences.length === 0" class="mt-2 text-sm text-gray-500">
                            Aucune compétence trouvée. Vous pouvez demander à l'administrateur d'ajouter cette compétence.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="px-4 py-4 sm:px-6 border-t border-gray-200 bg-gray-50 text-right">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Publier l'offre
            </button>
        </div>
    </div>
</form>
<x-heroicon-o-user />
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('competenceSelection', () => ({
            searchQuery: '',
            competences: @json($competences),
            competencesSelectionnees: [],
            filteredCompetences: [],
            
            init() {
                this.filteredCompetences = this.competences;
            },
            
            searchCompetences() {
                if (this.searchQuery.length < 2) {
                    this.filteredCompetences = [];
                    return;
                }
                
                const query = this.searchQuery.toLowerCase();
                this.filteredCompetences = this.competences.filter(competence => 
                    competence.nom.toLowerCase().includes(query) &&
                    !this.competencesSelectionnees.some(c => c.id === competence.id)
                );
            },
            
            addCompetence(competence) {
                if (!this.competencesSelectionnees.some(c => c.id === competence.id)) {
                    this.competencesSelectionnees.push({
                        id: competence.id,
                        nom: competence.nom,
                        niveau: 'intermediaire'
                    });
                }
            }
        }));
    });
</script>
@endpush