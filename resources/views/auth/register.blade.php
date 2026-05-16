<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Créer un compte — Frizzly</title>

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
    <div class="hidden lg:flex lg:w-5/12 xl:w-2/5 bg-gradient-to-br from-accent-purple to-accent-blue flex-col justify-between p-12 relative overflow-hidden">

        {{-- Decorative circles --}}
        <div class="absolute -top-16 -left-16 w-64 h-64 bg-white/5 rounded-full"></div>
        <div class="absolute top-1/2 -right-12 w-52 h-52 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-8 left-8 w-44 h-44 bg-white/5 rounded-full"></div>
        <div class="absolute bottom-1/3 right-4 w-28 h-28 bg-secondary/15 rounded-full"></div>

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="relative z-10">
            <img src="{{ asset('logo.png') }}" alt="Frizzly" class="h-20 w-auto brightness-0 invert">
        </a>

        {{-- Middle --}}
        <div class="relative z-10">
            {{-- Benefits list --}}
            <h2 class="text-3xl font-extrabold text-white leading-tight mb-8">
                Rejoignez la<br>communauté Frizzly
            </h2>

            <div class="space-y-5">
                @php
                $benefits = [
                    ['icon' => 'bi-mortarboard-fill',   'text' => 'Accès complet aux 5 modules de formation'],
                    ['icon' => 'bi-robot',              'text' => 'ChatBot IA pédagogique disponible 24h/24'],
                    ['icon' => 'bi-grid-3x3-gap-fill',  'text' => 'Kit de cartes pédagogiques personnalisé'],
                    ['icon' => 'bi-people-fill',        'text' => 'Communauté de 500+ enseignants actifs'],
                    ['icon' => 'bi-award-fill',         'text' => 'Certificat de formation reconnu'],
                ];
                @endphp
                @foreach($benefits as $b)
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-white/15 rounded-xl flex items-center justify-center shrink-0">
                        <i class="bi {{ $b['icon'] }} text-white text-base"></i>
                    </div>
                    <p class="text-white/85 text-sm font-medium">{{ $b['text'] }}</p>
                </div>
                @endforeach
            </div>

            {{-- Testimonial --}}
            <div class="mt-10 bg-white/10 backdrop-blur-sm rounded-2xl p-5">
                <div class="flex gap-1 mb-2">
                    @for($i=0; $i<5; $i++)
                    <i class="bi bi-star-fill text-secondary text-xs"></i>
                    @endfor
                </div>
                <p class="text-white/80 text-sm italic leading-relaxed">
                    "Frizzly a complètement transformé ma façon d'enseigner. Je me sens enfin armée pour innover."
                </p>
                <p class="text-white/50 text-xs mt-2">— Claire B., Professeure CM2</p>
            </div>
        </div>

        <p class="relative z-10 text-white/40 text-xs">
            © {{ date('Y') }} Frizzly — Tous droits réservés
        </p>
    </div>

    {{-- ── RIGHT PANEL ─────────────────────────────────────────────── --}}
    <div class="flex-1 flex flex-col justify-center px-6 py-10 sm:px-10 lg:px-16 xl:px-20 overflow-y-auto">

        {{-- Mobile logo --}}
        <div class="lg:hidden mb-6 flex justify-center">
            <a href="{{ route('home') }}">
                <img src="{{ asset('logo.png') }}" alt="Frizzly" class="h-16 w-auto">
            </a>
        </div>

        <div class="max-w-lg w-full mx-auto">

            {{-- Header --}}
            <div class="mb-7">
                <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Créer un compte</h1>
                <p class="text-gray-500">Rejoignez Frizzly gratuitement et transformez votre pratique.</p>
            </div>

            {{-- Validation errors --}}
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6 text-sm">
                <p class="font-semibold mb-1 flex items-center gap-1"><i class="bi bi-exclamation-triangle-fill"></i> Veuillez corriger les erreurs :</p>
                <ul class="list-disc list-inside space-y-0.5 mt-1">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
                @csrf

                {{-- First + Last name --}}
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label for="prenom" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Prénom <span class="text-primary">*</span>
                        </label>
                        <input
                            type="text"
                            id="prenom"
                            name="prenom"
                            value="{{ old('prenom') }}"
                            placeholder="Jean"
                            required
                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 placeholder-gray-400 focus:border-primary focus:outline-none transition-colors duration-200 text-sm @error('prenom') border-red-400 @enderror">
                        @error('prenom')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="nom" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nom <span class="text-primary">*</span>
                        </label>
                        <input
                            type="text"
                            id="nom"
                            name="nom"
                            value="{{ old('nom') }}"
                            placeholder="Dupont"
                            required
                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 placeholder-gray-400 focus:border-primary focus:outline-none transition-colors duration-200 text-sm @error('nom') border-red-400 @enderror">
                        @error('nom')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Adresse email <span class="text-primary">*</span>
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
                            class="w-full border-2 border-gray-200 rounded-xl pl-11 pr-4 py-3 text-gray-800 placeholder-gray-400 focus:border-primary focus:outline-none transition-colors duration-200 text-sm @error('email') border-red-400 @enderror">
                    </div>
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Établissement --}}
                <div>
                    <label for="etablissement" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Établissement
                        <span class="text-gray-400 font-normal">(optionnel)</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 pointer-events-none">
                            <i class="bi bi-building-fill"></i>
                        </span>
                        <input
                            type="text"
                            id="etablissement"
                            name="etablissement"
                            value="{{ old('etablissement') }}"
                            placeholder="École primaire Jean Jaurès"
                            class="w-full border-2 border-gray-200 rounded-xl pl-11 pr-4 py-3 text-gray-800 placeholder-gray-400 focus:border-primary focus:outline-none transition-colors duration-200 text-sm">
                    </div>
                </div>

                {{-- Cycle --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Cycle d'enseignement <span class="text-primary">*</span>
                    </label>
                    <div class="grid grid-cols-3 gap-3" x-data="{ cycle: '{{ old('cycle') }}' }">
                        @foreach(['Cycle 1', 'Cycle 2', 'Cycle 3'] as $c)
                        <label class="cursor-pointer">
                            <input type="radio" name="cycle" value="{{ $c }}" class="sr-only peer" {{ old('cycle') === $c ? 'checked' : '' }} required>
                            <div class="border-2 border-gray-200 rounded-xl py-3 text-center text-sm font-semibold text-gray-600
                                peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary
                                hover:border-gray-300 transition-all duration-200 cursor-pointer">
                                {{ $c }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('cycle')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Mot de passe <span class="text-primary">*</span>
                    </label>
                    <div class="relative" x-data="{ show: false }">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 pointer-events-none">
                            <i class="bi bi-lock-fill"></i>
                        </span>
                        <input
                            :type="show ? 'text' : 'password'"
                            id="password"
                            name="password"
                            placeholder="8 caractères minimum"
                            required
                            class="w-full border-2 border-gray-200 rounded-xl pl-11 pr-12 py-3 text-gray-800 placeholder-gray-400 focus:border-primary focus:outline-none transition-colors duration-200 text-sm @error('password') border-red-400 @enderror">
                        <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 transition-colors">
                            <i :class="show ? 'bi-eye-slash-fill' : 'bi-eye-fill'" class="bi"></i>
                        </button>
                    </div>
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Confirmer le mot de passe <span class="text-primary">*</span>
                    </label>
                    <div class="relative" x-data="{ show: false }">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 pointer-events-none">
                            <i class="bi bi-shield-lock-fill"></i>
                        </span>
                        <input
                            :type="show ? 'text' : 'password'"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Répétez le mot de passe"
                            required
                            class="w-full border-2 border-gray-200 rounded-xl pl-11 pr-12 py-3 text-gray-800 placeholder-gray-400 focus:border-primary focus:outline-none transition-colors duration-200 text-sm">
                        <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 transition-colors">
                            <i :class="show ? 'bi-eye-slash-fill' : 'bi-eye-fill'" class="bi"></i>
                        </button>
                    </div>
                </div>

                {{-- Terms --}}
                <div class="flex items-start gap-3 pt-1">
                    <input
                        type="checkbox"
                        id="terms"
                        name="terms"
                        required
                        class="mt-0.5 w-4 h-4 rounded accent-primary shrink-0">
                    <label for="terms" class="text-xs text-gray-500 leading-relaxed">
                        J'accepte les
                        <a href="#" class="text-primary hover:underline font-medium">Conditions d'utilisation</a>
                        et la
                        <a href="#" class="text-primary hover:underline font-medium">Politique de confidentialité</a>
                        de Frizzly.
                    </label>
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full bg-primary text-white py-4 rounded-xl font-bold text-base hover:bg-primary-dark hover:-translate-y-0.5 transition-all duration-200 shadow-lg shadow-primary/30 flex items-center justify-center gap-2 mt-2">
                    <i class="bi bi-person-check-fill"></i>
                    Créer mon compte
                </button>
            </form>

            {{-- Divider --}}
            <div class="flex items-center gap-4 my-5">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-gray-400 text-xs font-medium">ou s'inscrire avec</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            {{-- Social --}}
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

            {{-- Login link --}}
            <p class="text-center text-sm text-gray-500 mt-6">
                Déjà un compte ?
                <a href="{{ route('login') }}" class="text-primary font-semibold hover:underline">
                    Se connecter
                </a>
            </p>

            {{-- Back to home --}}
            <div class="text-center mt-3">
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
