<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to KomuniTech</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400&family=Montserrat:wght@700&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #46627D, #8EC0E7);
            color: #0B1F3A;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }
        .container {
            background: linear-gradient(to bottom, #6BB1F3, #A2D3F9);
            border-radius: 1rem;
            box-shadow: 0 12px 40px rgba(0,0,0,0.25);
            padding: 3rem;
            max-width: 850px;
            margin: auto;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeInUp 1s ease-out;
        }
        .container:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 50px rgba(0,0,0,0.3);
        }
        .btn {
            padding: 0.9rem 2.2rem;
            border-radius: 0.75rem;
            font-weight: 700;
            font-size: 1.1rem;
            transition: transform 0.2s ease, box-shadow 0.3s ease;
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
            display: inline-block;
            min-width: 160px; /* ensures same size */
            text-align: center;
        }
        .btn:hover {
            transform: scale(1.08);
            box-shadow: 0 10px 25px rgba(0,0,0,0.25);
        }
        .btn-register {
            background: linear-gradient(90deg, #4ADE80, #7bb192ff); /* green gradient */
            color: #0B1F3A;
        }
        .btn-login {
            background: linear-gradient(90deg, #3B82F6, #587ac3ff); /* blue gradient */
            color: #fff;
        }
        .logo {
            width: 240px;
            height: auto;
            filter: drop-shadow(0 12px 15px rgba(0,0,0,0.35));
            transform: perspective(700px) rotateX(4deg) rotateY(4deg);
            transition: transform 0.4s ease, filter 0.4s ease;
            animation: floatLogo 4s ease-in-out infinite;
        }
        .logo:hover {
            transform: perspective(700px) rotateX(0deg) rotateY(0deg) scale(1.08);
            filter: drop-shadow(0 16px 20px rgba(0,0,0,0.4));
        }
        .headline {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            color: #061D3B;
            font-size: 2.5rem;
            line-height: 1.2;
            animation: fadeIn 1.2s ease-in-out;
        }
        .subtext {
            color: #374151;
            font-size: 1.1rem;
            line-height: 1.6;
            animation: fadeIn 1.5s ease-in-out;
        }
        .btn-group {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 2rem;
            animation: fadeIn 2s ease-in-out;
        }
        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes floatLogo {
            0%, 100% { transform: translateY(0) rotateX(4deg) rotateY(4deg); }
            50% { transform: translateY(-10px) rotateX(4deg) rotateY(4deg); }
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="container text-center space-y-6">
        <!-- Logo -->
        <img src="{{ asset('images/komunitech-logo.png') }}" alt="KomuniTech Logo" class="logo mx-auto">

        <!-- Headline -->
        <h1 class="headline">Welcome to KomuniTech</h1>
        <p class="subtext max-w-xl mx-auto">
            Your trusted platform for requesting verified barangay documents.<br>
            Built for transparency, powered by technology.
        </p>

        <!-- Call to Action -->
        <div class="btn-group">
            <a href="{{ route('register') }}" class="btn btn-register">
                Register
            </a>
            <a href="{{ route('login') }}" class="btn btn-login">
                Login
            </a>
        </div>
    </div>
</body>
</html>
