<!-- resources/views/partials/navigation.blade.php -->

@if(auth()->user()->isCandidat())
    <!-- Navigation candidat -->
    <div>
        <x-nav-link href="{{ route('candidat.dashboard') }}" :active="request()->routeIs('candidat.dashboard')">
            <x-icons.dashboard class="flex-shrink-0 h-6 w-6" />
            <span class="ml-3">Tableau de bord</span>
        </x-nav-link>
        
        <x-nav-link href="{{ route('candidat.profil') }}" :active="request()->routeIs('candidat.profil')">
            <x-icons.user class="flex-shrink-0 h-6 w-6" />
            <span class="ml-3">Mon profil</span>
        </x-nav-link>
        
        <x-nav-link href="{{ route('candidat.offres') }}" :active="request()->routeIs('candidat.offres')">
            <x-icons.briefcase class="flex-shrink-0 h-6 w-6" />
            <span class="ml-3">Offres d'emploi</span>
        </x-nav-link>
        
        <x-nav-link href="{{ route('candidat.candidatures') }}" :active="request()->routeIs('candidat.candidatures')">
            <x-icons.document-text class="flex-shrink-0 h-6 w-6" />
            <span class="ml-3">Mes candidatures</span>
        </x-nav-link>
        
        <x-nav-link href="{{ route('documents.index') }}" :active="request()->routeIs('documents.index')">
            <x-icons.folder class="flex-shrink-0 h-6 w-6" />
            <span class="ml-3">Mes documents</span>
        </x-nav-link>
    </div>
@elseif(auth()->user()->isRecruteur())
    <!-- Navigation recruteur -->
    <div>
        <x-nav-link href="{{ route('recruteur.dashboard') }}" :active="request()->routeIs('recruteur.dashboard')">
            <x-icons.dashboard class="flex-shrink-0 h-6 w-6" />
            <span class="ml-3">Tableau de bord</span>
        </x-nav-link>
        
        <x-nav-link href="{{ route('recruteur.profil') }}" :active="request()->routeIs('recruteur.profil')">
            <x-icons.user class="flex-shrink-0 h-6 w-6" />
            <span class="ml-3">Mon profil</span>
        </x-nav-link>
        
        <x-nav-link href="{{ route('recruteur.offres') }}" :active="request()->routeIs('recruteur.offres')">
            <x-icons.briefcase class="flex-shrink-0 h-6 w-6" />
            <span class="ml-3">Mes offres</span>
        </x-nav-link>
        
        <x-nav-link href="{{ route('recruteur.recherche') }}" :active="request()->routeIs('recruteur.recherche')">
            <x-icons.search class="flex-shrink-0 h-6 w-6" />
            <span class="ml-3">Rechercher</span>
        </x-nav-link>
    </div>
@elseif(auth()->user()->isAdmin())
    <!-- Navigation admin -->
    <div>
        <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
            <x-icons.dashboard class="flex-shrink-0 h-6 w-6" />
            <span class="ml-3">Tableau de bord</span>
        </x-nav-link>
        
        <x-nav-link href="{{ route('admin.users') }}" :active="request()->routeIs('admin.users')">
            <x-icons.users class="flex-shrink-0 h-6 w-6" />
            <span class="ml-3">Utilisateurs</span>
        </x-nav-link>
        
        <x-nav-link href="{{ route('admin.offres') }}" :active="request()->routeIs('admin.offres')">
            <x-icons.briefcase class="flex-shrink-0 h-6 w-6" />
            <span class="ml-3">Offres</span>
        </x-nav-link>
        
        <x-nav-link href="{{ route('admin.competences') }}" :active="request()->routeIs('admin.competences')">
            <x-icons.tag class="flex-shrink-0 h-6 w-6" />
            <span class="ml-3">Compétences</span>
        </x-nav-link>
        
        <x-nav-link href="{{ route('admin.statistiques') }}" :active="request()->routeIs('admin.statistiques')">
            <x-icons.chart-bar class="flex-shrink-0 h-6 w-6" />
            <span class="ml-3">Statistiques</span>
        </x-nav-link>
    </div>
@endif

<!-- Navigation commune -->
<div class="mt-8 pt-8 border-t border-gray-200">
    <x-nav-link href="{{ route('notifications.index') }}" :active="request()->routeIs('notifications.index')">
        <x-icons.bell class="flex-shrink-0 h-6 w-6" />
        <span class="ml-3">Notifications</span>
        @if(auth()->user()->unreadNotifications->count())
            <span class="ml-auto inline-block py-0.5 px-2 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        @endif
    </x-nav-link>
    
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50 w-full">
            <x-icons.logout class="flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500" />
            <span class="ml-3">Déconnexion</span>
        </button>
    </form>
</div>