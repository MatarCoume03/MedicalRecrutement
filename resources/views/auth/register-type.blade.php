<!-- resources/views/auth/register-type.blade.php -->

@extends('layouts.guest')

@section('title', 'Choisir un type de compte')

@section('content')
<div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Créer un compte
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Choisissez le type de compte que vous souhaitez créer
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <div class="grid grid-cols-1 gap-4">
                <a href="{{ route('register', ['type' => 'candidat']) }}" class="inline-flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                     <x-icons.user class="mr-3 -ml-1 h-5 w-5" />  <!-- Icône utilisateur -->
                    Je suis un candidat
                </a>
                
                <a href="{{ route('register', ['type' => 'recruteur']) }}" class="inline-flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <x-icons.building-office class="mr-3 -ml-1 h-5 w-5" />  <!-- Icône entreprise -->
                    Je suis un recruteur
                </a>
            </div>
            
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">
                            Déjà inscrit ?
                        </span>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('login') }}" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Se connecter
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection