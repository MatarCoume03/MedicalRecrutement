<!-- resources/views/partials/sidebar.blade.php -->

<!-- Mobile sidebar -->
<div class="lg:hidden" x-show="sidebarOpen" @click.away="sidebarOpen = false">
    <div class="fixed inset-0 flex z-40">
        <div class="fixed inset-0">
            <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
        </div>
        <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white">
            <div class="absolute top-0 right-0 -mr-14 p-1">
                <button @click="sidebarOpen = false" class="flex items-center justify-center h-12 w-12 rounded-full focus:outline-none focus:bg-gray-600">
                    <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                <div class="flex-shrink-0 flex items-center px-4">
                    <x-application-logo class="h-8 w-auto" />
                </div>
                <nav class="mt-5 px-2">
                    @include('partials.navigation')
                </nav>
            </div>
        </div>
        <div class="flex-shrink-0 w-14"></div>
    </div>
</div>

<!-- Desktop sidebar -->
<div class="hidden lg:flex lg:flex-shrink-0">
    <div class="flex flex-col w-64 border-r border-gray-200 bg-white">
        <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
            <div class="flex items-center flex-shrink-0 px-4">
                <x-application-logo class="h-8 w-auto" />
            </div>
            <nav class="mt-5 flex-1 px-2 bg-white">
                @include('partials.navigation')
            </nav>
        </div>
    </div>
</div>