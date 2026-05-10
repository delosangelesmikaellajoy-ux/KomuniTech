<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400&family=Montserrat:wght@700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: linear-gradient(135deg, #46627D, #8EC0E7); /* KomuniTech gradient */
            font-family: 'Inter', sans-serif;
            color: #0B1F3A;
        }
        .container {
            background: linear-gradient(to bottom, #6BB1F3, #A2D3F9);
            border-radius: 1rem;
            box-shadow: 0 12px 40px rgba(0,0,0,0.25);
            padding: 2rem;
            max-width: 500px;
            margin: auto;
        }
        .logo {
            width: 100px;
            height: auto;
            margin-bottom: 1rem;
            filter: drop-shadow(0 8px 12px rgba(0,0,0,0.3));
        }
        .headline {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            color: #0B1F3A;
            margin-bottom: 1rem;
        }
        .form-section {
            text-align: left; /* align inputs to the left */
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <!-- Container -->
        <div class="w-full sm:max-w-md mt-6 container shadow-md overflow-hidden sm:rounded-lg">
            <!-- Logo inside container -->
            <div class="text-center">
                <a href="/">
                    <img src="{{ asset('images/komunitech-logo.png') }}" alt="KomuniTech Logo" class="logo mx-auto">
                </a>
                <h1 class="headline">KomuniTech Portal</h1>
            </div>

            <!-- Form section -->
            <div class="form-section mt-4">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
