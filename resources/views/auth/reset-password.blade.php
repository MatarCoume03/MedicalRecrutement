@extends('layouts.app')

@section('title', 'Réinitialiser le mot de passe')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="card">
            <div class="card-header">
                <h1 class="text-xl font-semibold text-gray-800">Définir un nouveau mot de passe</h1>
            </div>
            
            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse Email</label>
                        <input id="email" type="email" 
                               class="form-input @error('email') border-red-500 @enderror" 
                               name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                        
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                        <input id="password" type="password" 
                               class="form-input @error('password') border-red-500 @enderror" 
                               name="password" required autocomplete="new-password">
                        
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                        <input id="password-confirm" type="password" 
                               class="form-input" 
                               name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Réinitialiser le mot de passe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection