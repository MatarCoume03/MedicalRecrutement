<!-- resources/views/partials/mobile-nav.blade.php -->
<nav x-data="{ open: false }" class="bg-white shadow-md lg:hidden">
    <!-- Menu mobile -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo/Brand -->
            <div class="flex-shrink-0">
                <a href="{{ route('recruteur.dashboard') }}" class="flex items-center">
                    <x-application-logo class="h-8 w-auto" />
                    <span class="ml-2 text-lg font-semibold">Recruteur</span>
                </a>
            </div>

            <!-- Menu Button -->
            <div class="-mr-2 flex items-center">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-900 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu Items -->
    <div x-show="open" @click.away="open = false" class="pt-2 pb-3 space-y-1 bg-white shadow-lg">
        <!-- Dashboard -->
        <a href="{{ route('recruteur.dashboard') }}" class="block px-4 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">
            <x-icons.home class="inline h-5 w-5 mr-2" />
            Tableau de bord
        </a>

        <!-- Offres d'emploi -->
        <a href="{{ route('recruteur.offres.index') }}" class="block px-4 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">
            <x-icons.briefcase class="inline h-5 w-5 mr-2" />
            Mes offres
        </a>

        <!-- Candidatures -->
        <a href="{{ route('recruteur.candidatures.index') }}" class="block px-4 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">
            <x-icons.document-text class="inline h-5 w-5 mr-2" />
            Candidatures
        </a>

        <!-- Recherche de candidats -->
        <a href="{{ route('recruteur.candidats.search') }}" class="block px-4 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">
            <x-icons.user-group class="inline h-5 w-5 mr-2" />
            Trouver des candidats
        </a>

        <!-- Profil -->
        <a href="{{ route('recruteur.profil.edit') }}" class="block px-4 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">
            <x-icons.user class="inline h-5 w-5 mr-2" />
            Mon profil
        </a>

        <!-- Déconnexion -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left block px-4 py-2 text-base font-medium text-gray-700 hover:text-red-600 hover:bg-gray-50">
                <x-icons.logout class="inline h-5 w-5 mr-2" />
                Déconnexion
            </button>
        </form>
    </div>
</nav>

<style>
    [x-cloak] { display: none !important; }
</style>