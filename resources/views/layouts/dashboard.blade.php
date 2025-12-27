<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Supply</title>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: false }">
    <!-- Topbar -->
    @include('partials.dashboard.topbar')

    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('partials.dashboard.sidebar')

        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
            <!-- Header avec titre de page -->
            <div class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-2xl font-semibold text-gray-900">
                        @yield('header')
                    </h1>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>