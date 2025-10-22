<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Supply') - Supply</title>
    
    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    @vite(['resources/css/app.css'])
    
    <!-- AlpineJS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @yield('styles')
</head>
<body class="bg-light">
    @include('partials.header')
    
    <div class="container-fluid">
        <div class="row">
            @auth
                @php
                    $user = auth()->user();
                @endphp
                @if($user && $user->role === 'vendeur')
                    <nav class="col-md-3 col-lg-2 d-md-block bg-white sidebar collapse">
                        @include('vendeur.partials.sidebar')
                    </nav>
                    
                    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                        @yield('content')
                    </main>
                @else
                    <main class="col-12 px-4 py-4">
                        @yield('content')
                    </main>
                @endif
            @else
                <main class="col-12 px-4 py-4">
                    @yield('content')
                </main>
            @endauth
        </div>
    </div>

    <!-- Bootstrap JS Bundle avec Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
