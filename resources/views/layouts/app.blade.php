<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <!-- Friendly & Cute vibe font -->
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVJkEZSMUkrQ6usKGiOW03DjWvR5ffggM02Love3kcQzvpCro7WBh7u7pAoV7YHozDeSiAeWr0A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <!-- Apply cute font globally -->
    <body class="font-sans antialiased bg-neutral-50 pt-16 overflow-x-hidden">
        <div class="min-h-screen flex flex-col relative z-0">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @yield('header')

            <!-- Page Content -->
            <main class="flex-grow relative z-0">
                @yield('content')
            </main>

            <!-- Footer (optional) -->
            @include('layouts.footer')
        </div>

        <!-- Scripts Section for page-specific JS -->
        @yield('scripts')
    </body>
</html>
