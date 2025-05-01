<!-- resources/views/layouts/guest.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - MedicalRecruit</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col sm:justify-center items-center px-4 sm:px-0">
        <!-- Logo -->
        <div class="pt-8 sm:pt-0">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" alt="MedicalRecruit Logo" class="h-16">
            </a>
        </div>

        <!-- Contenu principal -->
        <div class="w-full sm:max-w-md mt-8 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg">
            @yield('content')
        </div>

        <!-- Liens secondaires -->
        <div class="w-full sm:max-w-md mt-4 text-center text-sm text-gray-600">
            @yield('secondary-content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>