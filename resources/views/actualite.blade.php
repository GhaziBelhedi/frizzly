@extends('layouts.app')

@section('title', 'Actualité')
@section('description', 'Suivez les dernières nouvelles de Frizzly — formations, innovations pédagogiques, témoignages d\'enseignants et ressources.')

@section('content')

@php
$categories = [
    ['label' => 'Tout',          'value' => 'all',          'active' => true],
    ['label' => 'Formations',    'value' => 'formations',   'active' => false],
    ['label' => 'Pédagogie',     'value' => 'pedagogie',    'active' => false],
    ['label' => 'Innovation',    'value' => 'innovation',   'active' => false],
    ['label' => 'Témoignages',   'value' => 'temoignages',  'active' => false],
    ['label' => 'Ressources',    'value' => 'ressources',   'active' => false],
];

$featured = [
    'category'  => 'Formations',
    'cat_color' => 'bg-primary/10 text-primary',
    'date'      => '28 avril 2025',
    'read'      => '5 min',
    'title'     => 'Lancement du programme de formation 2025–2026 : 5 modules, 49 heures, une posture transformée',
    'excerpt'   => 'Frizzly ouvre officiellement les inscriptions pour la nouvelle cohorte. Découvrez les modules repensés, les nouvelles dates de sessions présentielles et les témoignages des participants de la première promotion.',
    'tag'       => 'Nouveau',
    'tag_color' => 'bg-accent-green text-white',
];

$articles = [
    [
        'category'  => 'Pédagogie',
        'cat_color' => 'bg-accent-purple/10 text-accent-purple',
        'date'      => '21 avril 2025',
        'read'      => '4 min',
        'title'     => 'Les compétences entrepreneuriales à l\'école primaire : pourquoi maintenant ?',
        'excerpt'   => 'Dans un contexte éducatif en mutation, l\'entrepreneuriat pédagogique s\'impose comme levier de transformation professionnelle pour les enseignants du primaire.',
        'icon'      => 'bi-lightbulb-fill',
        'icon_bg'   => 'bg-accent-purple/10',
        'icon_text' => 'text-accent-purple',
    ],
    [
        'category'  => 'Témoignages',
        'cat_color' => 'bg-accent-green/10 text-accent-green',
        'date'      => '14 avril 2025',
        'read'      => '3 min',
        'title'     => '« Frizzly a changé ma façon d\'enseigner » — 3 enseignantes témoignent',
        'excerpt'   => 'Après six mois de formation, trois participantes de cycles différents partagent leur vécu, leurs doutes surmontés et les transformations observées dans leur pratique quotidienne.',
        'icon'      => 'bi-chat-quote-fill',
        'icon_bg'   => 'bg-accent-green/10',
        'icon_text' => 'text-accent-green',
    ],
    [
        'category'  => 'Innovation',
        'cat_color' => 'bg-accent-orange/10 text-accent-orange',
        'date'      => '7 avril 2025',
        'read'      => '6 min',
        'title'     => 'Les cartes Frizzly en classe : retour sur 4 semaines d\'expérimentation',
        'excerpt'   => 'Comment 12 enseignants ont intégré les cartes pédagogiques dans leurs séances hebdomadaires. Résultats, ajustements et prochaines étapes du protocole.',
        'icon'      => 'bi-grid-3x3-gap-fill',
        'icon_bg'   => 'bg-accent-orange/10',
        'icon_text' => 'text-accent-orange',
    ],
    [
        'category'  => 'Ressources',
        'cat_color' => 'bg-accent-blue/10 text-accent-blue',
        'date'      => '31 mars 2025',
        'read'      => '2 min',
        'title'     => 'Nouveau guide : concevoir une séquence pédagogique originale sans manuel',
        'excerpt'   => 'Un guide pratique de 12 pages téléchargeable gratuitement, co-écrit avec les participants du Module 2. Méthodes, exemples réels et grille d\'auto-évaluation incluse.',
        'icon'      => 'bi-file-earmark-text-fill',
        'icon_bg'   => 'bg-accent-blue/10',
        'icon_text' => 'text-accent-blue',
    ],
    [
        'category'  => 'Formations',
        'cat_color' => 'bg-primary/10 text-primary',
        'date'      => '24 mars 2025',
        'read'      => '4 min',
        'title'     => 'Module 4 en ligne : Collaborer et co-construire en équipe pédagogique',
        'excerpt'   => 'Les ressources du Module 4 sont désormais accessibles sur la plateforme. Grilles d\'observation, protocoles de co-développement et enregistrements des sessions.',
        'icon'      => 'bi-diagram-3-fill',
        'icon_bg'   => 'bg-primary/10',
        'icon_text' => 'text-primary',
    ],
    [
        'category'  => 'Pédagogie',
        'cat_color' => 'bg-accent-purple/10 text-accent-purple',
        'date'      => '17 mars 2025',
        'read'      => '5 min',
        'title'     => 'L\'éducation entrepreneuriale vue par les experts : synthèse de littérature',
        'excerpt'   => 'Nous avons compilé les principales références scientifiques qui fondent notre approche — de Lumpkin & Dess (1996) à Le Boterf (2001), en passant par les travaux de Schön.',
        'icon'      => 'bi-journal-bookmark-fill',
        'icon_bg'   => 'bg-accent-purple/10',
        'icon_text' => 'text-accent-purple',
    ],
];
@endphp

{{-- ═══════════════════════════════════════════
     HERO
═══════════════════════════════════════════ --}}
<section class="relative overflow-hidden bg-gradient-to-br from-accent-orange/8 via-white to-primary/5 py-16 lg:py-24">
    <div class="absolute -top-16 -right-16 w-80 h-80 bg-accent-orange/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-12 -left-12 w-60 h-60 bg-primary/8 rounded-full blur-3xl pointer-events-none"></div>
    <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
        <span class="inline-flex items-center gap-2 bg-accent-orange/10 text-accent-orange text-xs font-bold px-4 py-2 rounded-full mb-6 uppercase tracking-widest">
            <i class="bi bi-newspaper"></i> Actualité Frizzly
        </span>
        <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 leading-tight mb-4">
            Ce qui se passe chez <span class="text-primary">Frizzly</span>
        </h1>
        <p class="text-lg text-gray-500 max-w-xl mx-auto leading-relaxed">
            Formations, innovations pédagogiques, témoignages d'enseignants et ressources gratuites — toute l'actualité en un seul endroit.
        </p>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     CATEGORIES FILTER
═══════════════════════════════════════════ --}}
<section class="bg-white border-b border-gray-100 sticky top-[80px] z-30">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center gap-2 overflow-x-auto py-3 scrollbar-none">
            @foreach($categories as $cat)
            <button class="shrink-0 text-sm font-semibold px-4 py-2 rounded-full transition-all duration-200
                           {{ $cat['active']
                               ? 'bg-primary text-white shadow-sm shadow-primary/30'
                               : 'text-gray-500 hover:text-primary hover:bg-primary/8 bg-gray-100' }}">
                {{ $cat['label'] }}
            </button>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     FEATURED ARTICLE
═══════════════════════════════════════════ --}}
<section class="bg-white py-14">
    <div class="max-w-7xl mx-auto px-6">

        <div class="flex items-center gap-3 mb-8">
            <div class="w-1 h-6 bg-primary rounded-full"></div>
            <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">À la une</span>
        </div>

        <div class="group bg-gradient-to-br from-primary/5 to-white rounded-2xl border border-primary/15 overflow-hidden hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 cursor-pointer">
            <div class="grid lg:grid-cols-[1fr_2.2fr] gap-0">

                {{-- Visual panel --}}
                <div class="bg-gradient-to-br from-primary to-primary-dark flex items-center justify-center min-h-[200px] lg:min-h-0 relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-4 left-4 w-24 h-24 rounded-full bg-white"></div>
                        <div class="absolute bottom-4 right-4 w-16 h-16 rounded-full bg-white"></div>
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-40 h-40 rounded-full bg-white"></div>
                    </div>
                    <div class="relative z-10 text-center p-8">
                        <i class="bi bi-mortarboard-fill text-white text-5xl mb-3 block"></i>
                        <span class="{{ $featured['tag_color'] }} text-xs font-bold px-3 py-1 rounded-full">{{ $featured['tag'] }}</span>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-8 lg:p-10 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <span class="{{ $featured['cat_color'] }} text-xs font-bold px-3 py-1 rounded-full">{{ $featured['category'] }}</span>
                            <span class="text-gray-400 text-xs">·</span>
                            <span class="text-gray-400 text-xs">{{ $featured['date'] }}</span>
                            <span class="text-gray-400 text-xs">·</span>
                            <span class="text-gray-400 text-xs flex items-center gap-1">
                                <i class="bi bi-clock text-[10px]"></i> {{ $featured['read'] }}
                            </span>
                        </div>
                        <h2 class="text-2xl lg:text-3xl font-extrabold text-gray-900 leading-snug mb-4 group-hover:text-primary transition-colors duration-200">
                            {{ $featured['title'] }}
                        </h2>
                        <p class="text-gray-500 leading-relaxed text-[15px]">{{ $featured['excerpt'] }}</p>
                    </div>
                    <div class="mt-6">
                        <span class="inline-flex items-center gap-2 text-primary font-bold text-sm group-hover:gap-3 transition-all duration-200">
                            Lire l'article <i class="bi bi-arrow-right"></i>
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     ARTICLES GRID
═══════════════════════════════════════════ --}}
<section class="bg-gray-50 py-14">
    <div class="max-w-7xl mx-auto px-6">

        <div class="flex items-center gap-3 mb-8">
            <div class="w-1 h-6 bg-accent-orange rounded-full"></div>
            <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">Derniers articles</span>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($articles as $article)
            <div class="group bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-250 overflow-hidden cursor-pointer flex flex-col">

                {{-- Card top color strip --}}
                <div class="h-1 {{ str_replace(['bg-', '/10'], ['bg-', ''], explode(' ', $article['cat_color'])[0]) }}
                             opacity-60"></div>

                <div class="p-6 flex flex-col flex-1">

                    {{-- Meta --}}
                    <div class="flex items-center justify-between mb-4">
                        <span class="{{ $article['cat_color'] }} text-[11px] font-bold px-2.5 py-1 rounded-full">{{ $article['category'] }}</span>
                        <span class="text-gray-400 text-[11px] flex items-center gap-1">
                            <i class="bi bi-clock text-[9px]"></i> {{ $article['read'] }}
                        </span>
                    </div>

                    {{-- Icon + Title --}}
                    <div class="flex items-start gap-3 mb-3">
                        <div class="w-9 h-9 {{ $article['icon_bg'] }} rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                            <i class="bi {{ $article['icon'] }} {{ $article['icon_text'] }} text-base"></i>
                        </div>
                        <h3 class="text-gray-900 font-extrabold text-[15px] leading-snug group-hover:text-primary transition-colors duration-200">
                            {{ $article['title'] }}
                        </h3>
                    </div>

                    {{-- Excerpt --}}
                    <p class="text-gray-500 text-sm leading-relaxed flex-1">{{ $article['excerpt'] }}</p>

                    {{-- Footer --}}
                    <div class="flex items-center justify-between mt-5 pt-4 border-t border-gray-100">
                        <span class="text-gray-400 text-xs">{{ $article['date'] }}</span>
                        <span class="text-primary text-xs font-bold flex items-center gap-1 group-hover:gap-2 transition-all duration-200">
                            Lire <i class="bi bi-arrow-right text-[10px]"></i>
                        </span>
                    </div>

                </div>
            </div>
            @endforeach
        </div>

        {{-- Load more --}}
        <div class="text-center mt-10">
            <button class="inline-flex items-center gap-2 border-2 border-gray-200 text-gray-600 hover:border-primary hover:text-primary px-7 py-3 rounded-full font-semibold text-sm transition-all duration-200">
                <i class="bi bi-arrow-down-circle"></i> Voir plus d'articles
            </button>
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════
     NEWSLETTER CTA
═══════════════════════════════════════════ --}}
<section class="bg-white py-16">
    <div class="max-w-2xl mx-auto px-6 text-center">
        <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-5">
            <i class="bi bi-bell-fill text-primary text-2xl"></i>
        </div>
        <h2 class="text-2xl font-extrabold text-gray-900 mb-3">Ne ratez aucune actualité</h2>
        <p class="text-gray-500 text-sm leading-relaxed mb-7">
            Recevez chaque semaine les nouveaux articles, ressources et annonces de formation directement dans votre boîte mail.
        </p>
        <form class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
            <input type="email"
                   placeholder="votre@email.com"
                   class="flex-1 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
            <button type="submit"
                    class="bg-primary text-white px-6 py-3 rounded-xl font-bold text-sm hover:bg-primary-dark hover:-translate-y-0.5 transition-all duration-200 shadow-md shadow-primary/25 whitespace-nowrap">
                S'abonner
            </button>
        </form>
        <p class="text-xs text-gray-400 mt-3">Aucun spam. Désinscription en un clic.</p>
    </div>
</section>

@endsection
