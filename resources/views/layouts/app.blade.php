<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', 'Frizzly — La plateforme éducative innovante pour les enseignants')">
    <title>@yield('title', 'Frizzly') — Plateforme Éducative</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
        <style type="text/tailwindcss">
            @theme {
                --color-primary:        #E94E3C;
                --color-primary-dark:   #C73D2D;
                --color-primary-light:  #FDECEA;
                --color-secondary:      #FFC857;
                --color-secondary-dark: #F0AD3A;
                --color-secondary-light:#FFF8E7;
                --color-blue:           #4DA3FF;
                --color-blue-dark:      #2D8EF5;
                --color-blue-light:     #EBF4FF;
                --color-purple:         #8E6CFF;
                --color-purple-dark:    #7356E8;
                --color-purple-light:   #F0ECFF;
                --color-green:          #2ECC71;
                --color-green-dark:     #25A85E;
                --color-green-light:    #E8FAF0;
                --color-orange:         #F97316;
                --color-orange-light:   #FEF3EA;
                --color-pink:           #EC4899;
                --color-pink-light:     #FDF0F7;
                --color-accent-blue:    #4DA3FF;
                --color-accent-purple:  #8E6CFF;
                --color-accent-green:   #2ECC71;
                --color-accent-orange:  #F97316;
                --color-accent-pink:    #EC4899;
                --animate-float:        float 3s ease-in-out infinite;
                --animate-float-slow:   float 5s ease-in-out 0.5s infinite;
                --animate-wiggle:       wiggle 3s ease-in-out infinite;
                --font-sans: 'Poppins', ui-sans-serif, system-ui, sans-serif;
            }
        </style>
    @endif

    {{-- Global animation & utility CSS (works with both Vite and CDN) --}}
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-14px); }
        }
        @keyframes wiggle {
            0%, 100% { transform: rotate(-4deg) translateY(0); }
            50%       { transform: rotate(4deg)  translateY(-4px); }
        }
        @keyframes gradient-x {
            0%, 100% { background-position: 0% 50%; }
            50%       { background-position: 100% 50%; }
        }
        @keyframes blob {
            0%, 100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
            50%       { border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; }
        }
        .animate-float       { animation: float 3s ease-in-out infinite; }
        .animate-float-slow  { animation: float 5s ease-in-out 0.5s infinite; }
        .animate-float-delay { animation: float 3.5s ease-in-out 1s infinite; }
        .animate-wiggle      { animation: wiggle 3s ease-in-out infinite; }
        .animate-blob        { animation: blob 7s ease-in-out infinite; }
        .animate-gradient    { background-size: 200% 200%; animation: gradient-x 5s ease infinite; }

        .card-hover {
            transition: transform 0.3s cubic-bezier(.25,.8,.25,1), box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        }
        .glass {
            background: rgba(255,255,255,0.18);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255,255,255,0.3);
        }
        .gradient-text {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        /* Smooth scroll */
        html { scroll-behavior: smooth; }
        /* Selection color */
        ::selection { background: #E94E3C33; }
    </style>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('head')
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    @stack('scripts')
</body>
</html>
