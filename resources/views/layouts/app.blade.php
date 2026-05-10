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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <!-- Apply cute font globally -->
    <body class="font-[Quicksand] antialiased">
        <!-- Full page background gradient -->
        <div class="min-h-screen bg-gradient-to-b from-[#46627D] to-[#8EC0E7] flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @yield('header')

            <!-- Page Content -->
            <main class="flex-grow px-6 py-8">
                @yield('content')
            </main>
        </div>
    </body>
</html>
