<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion — Frizzly</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
        <style type="text/tailwindcss">
            @theme {
                --color-primary:       #E94E3C;
                --color-primary-dark:  #C73D2D;
                --color-secondary:     #FFC857;
                --color-accent-purple: #8B5CF6;
                --color-accent-blue:   #3B82F6;
                --color-accent-green:  #10B981;
                --color-accent-orange: #F97316;
                --font-sans: 'Poppins', ui-sans-serif, system-ui, sans-serif;
            }
        </style>
    @endif
</head>
<body class="font-sans antialiased bg-gray-50 min-h-screen">

<div class="min-h-screen flex">

    {{-- ── LEFT PANEL ─────────────────────────────────────────────── --}}
    <div class="hidden lg:flex lg:w-5/12 xl:w-2/5 bg-primary flex-col justify-between p-12 relative overflow-hidden">

        {{-- Decorative circles --}}
        <div class="absolute -top-20 -left-20 w-72 h-72 bg-white/5 rounded-full"></div>
        <div class="absolute top-1/3 -right-16 w-56 h-56 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-10 left-10 w-48 h-48 bg-white/5 rounded-full"></div>
        <div class="absolute bottom-1/4 -right-8 w-32 h-32 bg-secondary/20 rounded-full"></div>

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="relative z-10">
            <img src="{{ asset('logo.png') }}" alt="Frizzly" class="h-20 w-auto brightness-0 invert">
        </a>

        {{-- Middle content --}}
        <div class="relative z-10">
            {{-- Floating card illustration --}}
            <div class="flex gap-3 mb-10">
                @foreach([['🎤','blue'],['🤝','green'],['🃏','yellow'],['👑','purple']] as $card)
                <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-3 text-center w-16 transform
                    {{ $loop->index === 0 ? 'rotate-[-5deg]' : '' }}
                    {{ $loop->index === 1 ? 'rotate-[3deg] translate-y-2' : '' }}
                    {{ $loop->index === 2 ? 'rotate-[-2deg]' : '' }}
                    {{ $loop->index === 3 ? 'rotate-[4deg] translate-y-1' : '' }}">
                    <span class="text-2xl">{{ $card[0] }}</span>
                </div>
                @endforeach
            </div>

            <h2 class="text-4xl font-extrabold text-white leading-tight mb-4">
                Bienvenue<br>sur Frizzly
            </h2>
            <p class="text-white/75 leading-relaxed text-lg">
                La plateforme éducative qui transforme la posture professionnelle des enseignants.
            </p>

            {{-- Stats --}}
            <div class="flex gap-8 mt-8">
                <div>
                    <p class="text-3xl font-extrabold text-white">500+</p>
                    <p class="text-white/60 text-sm">Enseignants</p>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-white">5</p>
                    <p class="text-white/60 text-sm">Modules</p>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-white">9</p>
                    <p class="text-white/60 text-sm">Compétences</p>
                </div>
            </div>
        </div>

        {{-- Footer text --}}
        <p class="relative z-10 text-white/40 text-xs">
            © {{ date('Y') }} Frizzly — Tous droits réservés
        </p>
    </div>

    {{-- ── RIGHT PANEL ─────────────────────────────────────────────── --}}
    <div class="flex-1 flex flex-col justify-center px-6 py-12 sm:px-10 lg:px-16 xl:px-24">

        {{-- Mobile logo --}}
        <div class="lg:hidden mb-8 flex justify-center">
            <a href="{{ route('home') }}">
                <img src="{{ asset('logo.png') }}" alt="Frizzly" class="h-16 w-auto">
            </a>
        </div>

        <div class="max-w-md w-full mx-auto">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Connexion</h1>
                <p class="text-gray-500">Connectez-vous à votre espace Frizzly.</p>
            </div>

            {{-- Session error --}}
            @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6 flex items-center gap-2 text-sm">
                <i class="bi bi-exclamation-circle-fill shrink-0"></i>
                {{ session('error') }}
            </div>
            @endif

            {{-- Validation errors --}}
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6 text-sm">
                <p class="font-semibold mb-1 flex items-center gap-1"><i class="bi bi-exclamation-triangle-fill"></i> Veuillez corriger les erreurs suivantes :</p>
                <ul class="list-disc list-inside space-y-0.5 mt-1">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Adresse email
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 pointer-events-none">
                            <i class="bi bi-envelope-fill"></i>
                        </span>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="jean.dupont@ecole.fr"
                            required
                            autofocus
                            class="w-full border-2 border-gray-200 rounded-xl pl-11 pr-4 py-3.5 text-gray-800 placeholder-gray-400 focus:border-primary focus:outline-none transition-colors duration-200 text-sm @error('email') border-red-400 @enderror">
                    </div>
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-semibold text-gray-700">
                            Mot de passe
                        </label>
                        <a href="#" class="text-xs text-primary hover:underline font-medium">Mot de passe oublié ?</a>
                    </div>
                    <div class="relative" x-data="{ show: false }">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 pointer-events-none">
                            <i class="bi bi-lock-fill"></i>
                        </span>
                        <input
                            :type="show ? 'text' : 'password'"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            required
                            class="w-full border-2 border-gray-200 rounded-xl pl-11 pr-12 py-3.5 text-gray-800 placeholder-gray-400 focus:border-primary focus:outline-none transition-colors duration-200 text-sm @error('password') border-red-400 @enderror">
                        <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 transition-colors">
                            <i :class="show ? 'bi-eye-slash-fill' : 'bi-eye-fill'" class="bi"></i>
                        </button>
                    </div>
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div class="flex items-center gap-3">
                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                        class="w-4 h-4 rounded accent-primary">
                    <label for="remember" class="text-sm text-gray-600">Se souvenir de moi</label>
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full bg-primary text-white py-4 rounded-xl font-bold text-base hover:bg-primary-dark hover:-translate-y-0.5 transition-all duration-200 shadow-lg shadow-primary/30 flex items-center justify-center gap-2">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Se connecter
                </button>
            </form>

            {{-- Divider --}}
            <div class="flex items-center gap-4 my-6">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-gray-400 text-xs font-medium">ou continuer avec</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            {{-- Social logins --}}
            <div class="grid grid-cols-2 gap-3">
                <button type="button"
                    class="flex items-center justify-center gap-2 border-2 border-gray-200 rounded-xl py-3 text-sm font-semibold text-gray-700 hover:border-gray-300 hover:bg-gray-50 transition-all duration-200">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Google
                </button>
                <button type="button"
                    class="flex items-center justify-center gap-2 border-2 border-gray-200 rounded-xl py-3 text-sm font-semibold text-gray-700 hover:border-gray-300 hover:bg-gray-50 transition-all duration-200">
                    <i class="bi bi-microsoft text-blue-600 text-lg"></i>
                    Microsoft
                </button>
            </div>

            {{-- Register link --}}
            <p class="text-center text-sm text-gray-500 mt-8">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="text-primary font-semibold hover:underline">
                    Créer un compte
                </a>
            </p>

            {{-- Back to home --}}
            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="text-xs text-gray-400 hover:text-gray-600 transition-colors inline-flex items-center gap-1">
                    <i class="bi bi-arrow-left"></i> Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
</div>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
