<!-- resources/views/recruteur/profil.blade.php -->

@extends('layouts.app')

@section('title', 'Mon profil')

@section('header')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">
                Mon profil
            </h1>
            <a href="{{ route('recruteur.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Retour
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
<form action="{{ route('recruteur.profil.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Informations personnelles
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Ces informations seront visibles par les candidats.
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
            </div>
        </div>
        
        <!-- Informations entreprise -->
        <div class="px-4 py-5 sm:px-6 border-t border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Informations sur l'entreprise
            </h3>
        </div>
        
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-6">
                <!-- Logo entreprise -->
                <div class="sm:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Logo</label>
                    <div class="mt-1 flex items-center">
                        <div x-data="{ logoPreview: '{{ auth()->user()->recruteurProfil->logo ? Storage::url(auth()->user()->recruteurProfil->logo) : '' }}' }" class="relative">
                            <img x-show="logoPreview" :src="logoPreview" class="h-16 w-16 rounded-full object-cover">
                            <div x-show="!logoPreview" class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-medium">
                                {{ substr(auth()->user()->recruteurProfil->entreprise, 0, 2) }}
                            </div>
                            <label for="logo" class="absolute bottom-0 right-0 bg-white p-1 rounded-full shadow-sm border border-gray-300 cursor-pointer">
                                <x-icons.camera class="h-4 w-4 text-gray-500" />
                                <input id="logo" name="logo" type="file" class="sr-only" @change="logoPreview = URL.createObjectURL($event.target.files[0])">
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Entreprise -->
                <div class="sm:col-span-5">
                    <label for="entreprise" class="block text-sm font-medium text-gray-700">Nom de l'entreprise</label>
                    <input type="text" name="entreprise" id="entreprise" value="{{ old('entreprise', auth()->user()->recruteurProfil->entreprise) }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('entreprise')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Secteur d'activité -->
                <div class="sm:col-span-3">
                    <label for="secteur_activite" class="block text-sm font-medium text-gray-700">Secteur d'activité</label>
                    <input type="text" name="secteur_activite" id="secteur_activite" value="{{ old('secteur_activite', auth()->user()->recruteurProfil->secteur_activite) }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('secteur_activite')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Poste occupé -->
                <div class="sm:col-span-3">
                    <label for="poste_occupe" class="block text-sm font-medium text-gray-700">Poste occupé</label>
                    <input type="text" name="poste_occupe" id="poste_occupe" value="{{ old('poste_occupe', auth()->user()->recruteurProfil->poste_occupe) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('poste_occupe')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Site web -->
                <div class="sm:col-span-3">
                    <label for="site_web" class="block text-sm font-medium text-gray-700">Site web</label>
                    <input type="url" name="site_web" id="site_web" value="{{ old('site_web', auth()->user()->recruteurProfil->site_web) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('site_web')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Description entreprise -->
                <div class="sm:col-span-6">
                    <label for="description_entreprise" class="block text-sm font-medium text-gray-700">Description de l'entreprise</label>
                    <textarea id="description_entreprise" name="description_entreprise" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('description_entreprise', auth()->user()->recruteurProfil->description_entreprise) }}</textarea>
                    @error('description_entreprise')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
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