<!-- resources/views/partials/header.blade.php -->

<div class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
        <!-- Mobile menu button -->
        <div class="lg:hidden">
            <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-600 focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
        
        <!-- Right side -->
        <div class="flex items-center space-x-4">
            <!-- Notifications -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open; notificationsOpen = true" class="p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none">
                    <span class="sr-only">Notifications</span>
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    @if(auth()->user()->unreadNotifications->count())
                        <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                    @endif
                </button>
                
                <!-- Notifications dropdown -->
                <div x-show="open" @click.away="open = false" 
                     class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-200 z-50">
                    <div class="py-1">
                        <div class="px-4 py-3 flex justify-between items-center bg-gray-50">
                            <p class="text-sm font-medium text-gray-900">Notifications</p>
                            <button @click="markAllAsRead()" class="text-sm text-blue-600 hover:text-blue-800">Tout marquer comme lu</button>
                        </div>
                        <div class="max-h-96 overflow-y-auto">
                            @forelse(auth()->user()->notifications->take(5) as $notification)
                                <a href="{{ $notification->data['url'] ?? '#' }}" 
                                   class="block px-4 py-3 hover:bg-gray-50 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }}">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 pt-0.5">
                                            <svg class="h-5 w-5 {{ $notification->read_at ? 'text-gray-400' : 'text-blue-400' }}" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <p class="text-sm font-medium text-gray-900">{{ $notification->data['title'] ?? 'Notification' }}</p>
                                            <p class="text-sm text-gray-500">{{ $notification->data['message'] ?? '' }}</p>
                                            <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="px-4 py-3 text-center text-sm text-gray-500">
                                    Aucune notification
                                </div>
                            @endforelse
                        </div>
                        <div class="px-4 py-2 bg-gray-50 text-center">
                            <a href="{{ route('notifications.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">Voir toutes</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Profile dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 max-w-xs rounded-full focus:outline-none">
                    <span class="sr-only">Ouvrir le menu utilisateur</span>
                    @if(auth()->user()->photo)
                        <img class="h-8 w-8 rounded-full" src="{{ Storage::url(auth()->user()->photo) }}" alt="Photo de profil">
                    @else
                        <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-medium">
                            {{ substr(auth()->user()->prenom, 0, 1) }}{{ substr(auth()->user()->nom, 0, 1) }}
                        </div>
                    @endif
                    <span class="hidden lg:inline-block text-sm font-medium text-gray-700">{{ auth()->user()->prenom }}</span>
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                
                <div x-show="open" @click.away="open = false" 
                     class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 py-1 z-50">
                    <div class="px-4 py-2 border-b">
                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->fullName }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <a href="{{ auth()->user()->isCandidat() ? route('candidat.profil') : route('recruteur.profil') }}" 
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Déconnexion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>