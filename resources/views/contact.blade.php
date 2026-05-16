@extends('layouts.app')

@section('title', 'Contact')
@section('description', 'Contactez l\'équipe Frizzly pour toute question ou pour commander votre kit pédagogique.')

@section('content')

{{-- ═══════════════════════════════════════════
     HERO
═══════════════════════════════════════════ --}}
<section class="bg-gradient-to-br from-primary/5 via-white to-accent-purple/5 py-20 lg:py-24">
    <div class="max-w-3xl mx-auto px-6 text-center">
        <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="bi bi-envelope-fill text-primary text-2xl"></i>
        </div>
        <h1 class="text-5xl font-extrabold text-gray-900 mb-4">Parlons-nous</h1>
        <p class="text-xl text-gray-500 leading-relaxed">
            Une question, une commande ou simplement envie d'en savoir plus ? Notre équipe répond sous 24h.
        </p>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     CONTACT SECTION
═══════════════════════════════════════════ --}}
<section class="bg-white py-16 lg:py-24">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid lg:grid-cols-5 gap-12">

            {{-- ── Left: contact info ────────────────────── --}}
            <div class="lg:col-span-2 space-y-8">
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Informations de contact</h2>
                    <p class="text-gray-500 text-sm">Nous sommes disponibles du lundi au vendredi, de 9h à 18h.</p>
                </div>

                {{-- Contact cards --}}
                <div class="space-y-4">
                    <div class="flex items-start gap-4 bg-gray-50 rounded-2xl p-5">
                        <div class="w-11 h-11 bg-primary/10 rounded-xl flex items-center justify-center shrink-0">
                            <i class="bi bi-envelope-fill text-primary text-lg"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Email</p>
                            <a href="mailto:hello@frizzly.fr" class="text-primary hover:underline text-sm">hello@frizzly.fr</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 bg-gray-50 rounded-2xl p-5">
                        <div class="w-11 h-11 bg-accent-blue/10 rounded-xl flex items-center justify-center shrink-0">
                            <i class="bi bi-telephone-fill text-accent-blue text-lg"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Téléphone</p>
                            <a href="tel:+33123456789" class="text-gray-600 hover:text-primary text-sm">+2161 23 45 67 89</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 bg-gray-50 rounded-2xl p-5">
                        <div class="w-11 h-11 bg-accent-green/10 rounded-xl flex items-center justify-center shrink-0">
                            <i class="bi bi-geo-alt-fill text-accent-green text-lg"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Adresse</p>
                            <p class="text-gray-600 text-sm">15 rue de la Pédagogie<br>75001 Tunis</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 bg-gray-50 rounded-2xl p-5">
                        <div class="w-11 h-11 bg-secondary/20 rounded-xl flex items-center justify-center shrink-0">
                            <i class="bi bi-clock-fill text-secondary-dark text-lg"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Horaires</p>
                            <p class="text-gray-600 text-sm">Lun – Ven : 9h – 18h<br>Réponse email sous 24h</p>
                        </div>
                    </div>
                </div>

                {{-- Social links --}}
                <div>
                    <p class="font-semibold text-gray-700 mb-3 text-sm">Suivez-nous</p>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-gray-100 hover:bg-primary hover:text-white rounded-full flex items-center justify-center text-gray-600 transition-all duration-200">
                            <i class="bi bi-twitter-x text-sm"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-100 hover:bg-primary hover:text-white rounded-full flex items-center justify-center text-gray-600 transition-all duration-200">
                            <i class="bi bi-linkedin text-sm"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-100 hover:bg-primary hover:text-white rounded-full flex items-center justify-center text-gray-600 transition-all duration-200">
                            <i class="bi bi-instagram text-sm"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-100 hover:bg-primary hover:text-white rounded-full flex items-center justify-center text-gray-600 transition-all duration-200">
                            <i class="bi bi-youtube text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- ── Right: form ───────────────────────────── --}}
            <div class="lg:col-span-3">
                <div class="bg-white rounded-3xl border border-gray-100 shadow-xl p-8 lg:p-10">
                    <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Envoyez-nous un message</h2>
                    <p class="text-gray-500 text-sm mb-8">Remplissez le formulaire et nous vous répondrons rapidement.</p>

                    @if(session('success'))
                        <div class="bg-accent-green/10 border border-accent-green/30 text-accent-green rounded-xl p-4 mb-6 flex items-center gap-3">
                            <i class="bi bi-check-circle-fill text-xl"></i>
                            <p class="font-medium">{{ session('success') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                        @csrf

                        {{-- Name row --}}
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label for="prenom" class="block text-sm font-semibold text-gray-700 mb-1.5">Prénom <span class="text-primary">*</span></label>
                                <input
                                    type="text"
                                    id="prenom"
                                    name="prenom"
                                    placeholder="Jean"
                                    required
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 placeholder-gray-400 focus:border-primary focus:outline-none transition-colors duration-200 text-sm">
                            </div>
                            <div>
                                <label for="nom" class="block text-sm font-semibold text-gray-700 mb-1.5">Nom <span class="text-primary">*</span></label>
                                <input
                                    type="text"
                                    id="nom"
                                    name="nom"
                                    placeholder="Dupont"
                                    required
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 placeholder-gray-400 focus:border-primary focus:outline-none transition-colors duration-200 text-sm">
                            </div>
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email <span class="text-primary">*</span></label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="jean.dupont@ecole.fr"
                                required
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 placeholder-gray-400 focus:border-primary focus:outline-none transition-colors duration-200 text-sm">
                        </div>

                        {{-- Subject --}}
                        <div>
                            <label for="sujet" class="block text-sm font-semibold text-gray-700 mb-1.5">Sujet</label>
                            <select
                                id="sujet"
                                name="sujet"
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 focus:border-primary focus:outline-none transition-colors duration-200 text-sm bg-white">
                                <option value="">Choisissez un sujet…</option>
                                <option value="demo">Demande de démo</option>
                                <option value="commande">Commander un kit</option>
                                <option value="formation">Informations formation</option>
                                <option value="partenariat">Partenariat / École</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>

                        {{-- Message --}}
                        <div>
                            <label for="message" class="block text-sm font-semibold text-gray-700 mb-1.5">Message <span class="text-primary">*</span></label>
                            <textarea
                                id="message"
                                name="message"
                                rows="5"
                                placeholder="Décrivez votre demande ou question…"
                                required
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-800 placeholder-gray-400 focus:border-primary focus:outline-none transition-colors duration-200 text-sm resize-none"></textarea>
                        </div>

                        {{-- GDPR --}}
                        <div class="flex items-start gap-3">
                            <input
                                type="checkbox"
                                id="rgpd"
                                name="rgpd"
                                required
                                class="mt-0.5 w-4 h-4 accent-primary rounded">
                            <label for="rgpd" class="text-xs text-gray-500 leading-relaxed">
                                J'accepte que Frizzly traite mes données personnelles conformément à sa
                                <a href="#" class="text-primary hover:underline">politique de confidentialité</a>
                                pour répondre à ma demande.
                            </label>
                        </div>

                        {{-- Submit --}}
                        <button
                            type="submit"
                            class="w-full bg-primary text-white py-4 rounded-xl font-bold text-lg hover:bg-primary-dark hover:-translate-y-0.5 transition-all duration-200 shadow-lg shadow-primary/30 flex items-center justify-center gap-2">
                            <i class="bi bi-send-fill"></i>
                            Envoyer le message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     FAQ
═══════════════════════════════════════════ --}}
<section class="bg-gray-50 py-20">
    <div class="max-w-3xl mx-auto px-6">
        <div class="text-center mb-12">
            <span class="text-primary font-semibold text-sm uppercase tracking-widest">Questions fréquentes</span>
            <h2 class="text-3xl font-extrabold text-gray-900 mt-2">FAQ</h2>
        </div>

        <div class="space-y-3" x-data="{ open: null }">
            @php
            $faqs = [
                ['q' => 'Combien de temps faut-il pour recevoir le kit ?', 'a' => 'Les kits sont expédiés sous 3 à 5 jours ouvrés. Vous recevrez un email de confirmation avec un numéro de suivi.'],
                ['q' => 'Est-ce que Frizzly est adapté à tous les niveaux scolaires ?', 'a' => 'Oui ! Nos cartes et notre programme sont conçus pour le primaire, le collège et le lycée. Nous proposons également une adaptation pour l\'enseignement supérieur.'],
                ['q' => 'Puis-je tester la plateforme avant de m\'abonner ?', 'a' => 'Absolument. Nous offrons un accès gratuit de 30 jours à toutes les fonctionnalités. Aucune carte de crédit requise.'],
                ['q' => 'Comment fonctionne le ChatBot IA ?', 'a' => 'Notre ChatBot est entraîné sur des ressources pédagogiques validées. Il répond à vos questions sur l\'apprentissage coopératif, propose des activités et vous aide à adapter les rôles à votre contexte.'],
            ];
            @endphp

            @foreach($faqs as $i => $faq)
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm"
                 x-data="{ open: false }">
                <button
                    @click="open = !open"
                    class="w-full flex items-center justify-between px-6 py-5 text-left font-semibold text-gray-900 hover:text-primary transition-colors duration-200">
                    <span>{{ $faq['q'] }}</span>
                    <i class="bi bi-chevron-down text-gray-400 transition-transform duration-300 shrink-0 ml-4"
                       :class="open ? 'rotate-180 text-primary' : ''"></i>
                </button>
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="px-6 pb-5">
                    <p class="text-gray-500 leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
