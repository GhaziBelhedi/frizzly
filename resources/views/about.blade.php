@extends('layouts.app')
@section('title', 'Nous connaître')

@section('content')

{{-- ══════════════════════════════════════════════
     HERO
══════════════════════════════════════════════ --}}
<section class="relative overflow-hidden py-20 lg:py-28"
         style="background:linear-gradient(135deg,#FDECEA 0%,#FFF8E7 50%,#EBF4FF 100%);">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-10 right-10 w-40 h-40 rounded-full animate-blob"
             style="background:#FFC85730;"></div>
        <div class="absolute bottom-10 left-10 w-32 h-32 rounded-full animate-blob"
             style="background:#4DA3FF20; animation-delay:3s;"></div>
    </div>
    <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
        <span class="inline-block bg-primary/10 text-primary text-xs font-bold px-4 py-2 rounded-full mb-6 uppercase tracking-wide">
            À notre sujet · Tunisie 🇹🇳
        </span>
        <h1 class="text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
            Une vision née en <span class="text-primary">Tunisie</span>,<br>
            pour tous les enseignants
        </h1>
        <p class="text-xl text-gray-500 max-w-2xl mx-auto leading-relaxed">
            Frizzly est née à Tunis de la conviction que chaque enseignant mérite des outils modernes, adaptés et engageants pour transformer sa pratique pédagogique.
        </p>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     PRÉSENTATION
══════════════════════════════════════════════ --}}
<section class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <span class="text-primary font-bold text-xs uppercase tracking-widest">Notre histoire</span>
                <h2 class="text-4xl font-extrabold text-gray-900 mt-2 mb-6">Qui sommes-nous ?</h2>
                <p class="text-gray-500 leading-relaxed mb-4">
                    Frizzly est une startup EdTech tunisienne fondée par une étudiante en Éducation et Enseignement, passionnée par l'innovation pédagogique et le développement humain.
                </p>
                <p class="text-gray-500 leading-relaxed mb-4">
                    Née à <strong class="text-gray-700">Tunis 🇹🇳</strong>, Frizzly s'inspire des meilleures pratiques mondiales en éducation entrepreneuriale pour proposer une solution moderne, utile et réaliste au service des enseignants du monde francophone.
                </p>
                <p class="text-gray-500 leading-relaxed">
                    Notre plateforme combine cartes pédagogiques physiques, formation certifiante et outils numériques , tout ce qu'il faut pour transformer la posture professionnelle des enseignants du primaire.
                </p>
                <div class="flex items-center gap-3 mt-6 bg-green-light border border-green/20 rounded-2xl px-5 py-3">
                    <span class="text-2xl">🇹🇳</span>
                    <p class="text-sm text-green-dark font-medium">
                        Fièrement <strong>Tunisien</strong> — conçu à Tunis, pour les enseignants du monde entier.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                @foreach([
                    ['text-primary','bg-primary/5','2024','Année de fondation'],
                    ['text-gray-900','bg-secondary/20','500+','Enseignants actifs'],
                    ['text-blue','bg-blue-light','12k+','Élèves accompagnés'],
                    ['text-green','bg-green-light','5','Modules certifiants'],
                ] as $stat)
                <div class="rounded-2xl p-6 text-center {{ $stat[1] }}">
                    <p class="text-4xl font-extrabold {{ $stat[0] }} mb-1">{{ $stat[2] }}</p>
                    <p class="text-gray-500 text-sm">{{ $stat[3] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     VISION & MISSION
══════════════════════════════════════════════ --}}
<section class="py-20" style="background:linear-gradient(135deg,#F9FAFB,#EBF4FF);">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-6">

            {{-- Vision --}}
            <div class="bg-white rounded-3xl p-8 shadow-sm border-2 border-primary/10 card-hover">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-6 shadow-lg"
                     style="background:linear-gradient(135deg,#E94E3C,#F47C6E);">
                    <i class="bi bi-eye-fill text-white text-2xl"></i>
                </div>
                <span class="text-primary font-bold text-xs uppercase tracking-widest">Notre Vision</span>
                <h3 class="text-2xl font-extrabold text-gray-900 mt-1 mb-4">Ce que nous voulons bâtir</h3>
                <p class="text-gray-500 leading-relaxed">
                    Construire une nouvelle génération d'enseignants autonomes, innovants, confiants et capables de transformer les défis scolaires en opportunités d'apprentissage et de réussite.
                </p>
            </div>

            {{-- Mission --}}
            <div class="rounded-3xl p-8 shadow-xl text-white card-hover"
                 style="background:linear-gradient(135deg,#4DA3FF,#8E6CFF);">
                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center mb-6">
                    <i class="bi bi-compass-fill text-white text-2xl"></i>
                </div>
                <span class="text-white/70 font-bold text-xs uppercase tracking-widest">Notre Mission</span>
                <h3 class="text-2xl font-extrabold text-white mt-1 mb-4">Ce que nous faisons</h3>
                <p class="text-white/85 leading-relaxed mb-4">
                    Accompagner les enseignants dans leur évolution personnelle et professionnelle en leur offrant :
                </p>
                <ul class="space-y-2">
                    @foreach(['des programmes de formation adaptés','des ressources accessibles','des outils pratiques','un accompagnement moderne','des solutions concrètes aux réalités du terrain.'] as $item)
                    <li class="flex items-center gap-2 text-white/85 text-sm">
                        <i class="bi bi-check-circle-fill text-secondary shrink-0"></i>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     VALEURS — 5 colorful cards
══════════════════════════════════════════════ --}}
<section class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-purple font-bold text-xs uppercase tracking-widest">Ce qui nous guide</span>
            <h2 class="text-4xl font-extrabold text-gray-900 mt-2">Nos valeurs</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @php
            $values = [
                ['bi-lightbulb-fill',        '#E94E3C', '#FDECEA', 'Innovation',        'Imaginer de nouvelles réponses aux besoins éducatifs actuels.'],
                ['bi-lightning-charge-fill', '#8E6CFF', '#F0ECFF', 'Engagement',        'Servir la réussite des enseignants et des apprenants.'],
                ['bi-trophy-fill',           '#FFC857', '#FFF8E7', 'Excellence',        'Offrir un contenu sérieux, utile et de qualité.'],
                ['bi-heart-fill',            '#EC4899', '#FDF0F7', 'Humanité',          'Respecter la réalité humaine du métier enseignant.'],
                ['bi-arrow-repeat',          '#2ECC71', '#E8FAF0', 'Évolution continue','Apprendre, progresser et s\'adapter durablement.'],
            ];
            @endphp

            @foreach($values as $v)
            <div class="rounded-2xl p-6 text-center card-hover border-2"
                 style="background:{{ $v[2] }}; border-color:{{ $v[1] }}20;">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-md"
                     style="background:{{ $v[1] }};">
                    <i class="bi {{ $v[0] }} text-white text-xl"></i>
                </div>
                <h4 class="font-bold text-gray-900 mb-2 text-sm lg:text-base">{{ $v[3] }}</h4>
                <p class="text-gray-500 text-xs leading-relaxed">{{ $v[4] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     OBJECTIFS
══════════════════════════════════════════════ --}}
<section class="py-20" style="background:linear-gradient(135deg,#F0ECFF,#EBF4FF);">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-14 items-start">
            <div>
                <span class="text-primary font-bold text-xs uppercase tracking-widest">Ce que nous visons</span>
                <h2 class="text-4xl font-extrabold text-gray-900 mt-2 mb-5">Nos Objectifs</h2>
                <p class="text-gray-500 leading-relaxed mb-6">
                    Frizzly s'engage à produire un impact concret et durable sur la pratique pédagogique des enseignants, en agissant sur leur posture, leurs compétences et leur environnement de travail.
                </p>
                <a href="{{ route('programme') }}"
                   class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3.5 rounded-xl font-bold
                          shadow-lg shadow-primary/25 hover:bg-primary-dark hover:-translate-y-0.5 transition-all duration-200">
                    <i class="bi bi-mortarboard-fill"></i> Voir le programme
                </a>
            </div>

            <div class="space-y-3">
                @php
                $colors = ['#E94E3C','#4DA3FF','#2ECC71','#8E6CFF','#FFC857','#F97316','#EC4899'];
                $objectives = [
                    'Renforcer la posture professionnelle des enseignants.',
                    'Développer les compétences entrepreneuriales en milieu éducatif.',
                    'Encourager l\'innovation pédagogique.',
                    'Favoriser la confiance professionnelle et l\'autonomie.',
                    'Répondre aux défis contemporains de l\'enseignement.',
                    'Valoriser la formation continue.',
                    'Créer une dynamique positive dans les établissements scolaires.',
                ];
                @endphp
                @foreach($objectives as $i => $obj)
                <div class="flex items-center gap-4 bg-white rounded-2xl px-5 py-4 shadow-sm card-hover border-l-4"
                     style="border-color:{{ $colors[$i] }};">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-extrabold text-xs shrink-0 shadow-sm"
                         style="background:{{ $colors[$i] }};">
                        {{ str_pad($i+1,2,'0',STR_PAD_LEFT) }}
                    </div>
                    <p class="text-gray-700 font-medium text-sm">{{ $obj }}</p>
                    <i class="bi bi-check-circle-fill text-green ml-auto shrink-0 text-sm"></i>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     FONDATRICE
══════════════════════════════════════════════ --}}
<section class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-primary font-bold text-xs uppercase tracking-widest">Derrière Frizzly</span>
            <h2 class="text-4xl font-extrabold text-gray-900 mt-2">La fondatrice</h2>
        </div>

        <div class="max-w-3xl mx-auto">
            <div class="rounded-3xl p-8 lg:p-12 shadow-xl flex flex-col lg:flex-row items-center gap-10 border-2 border-primary/10"
                 style="background:linear-gradient(135deg,#FDECEA,#FFF8E7);">
                <div class="w-36 h-36 shrink-0 rounded-full overflow-hidden shadow-2xl animate-float border-4 border-white">
                    <img src="{{ asset('maram.jpeg') }}" alt="Maram Ben Samir" class="w-full h-full object-cover">
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-gray-900 mb-1">Maram Ben Samir</h3>
                    <p class="text-primary font-bold mb-1">Fondatrice de Frizzly</p>
                    <p class="text-gray-400 text-sm mb-4">🇹🇳 Tunis, Tunisie</p>
                    <p class="text-gray-600 leading-relaxed mb-3">
                        Étudiante en Éducation et Enseignement, passionnée par l'innovation pédagogique, le développement humain et les projets éducatifs à impact.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Frizzly est née de sa volonté de proposer une solution moderne, utile et réaliste au service des enseignants.
                    </p>
                    <div class="flex gap-3 mt-5">
                        <a href="#" class="w-9 h-9 bg-white hover:bg-primary hover:text-white rounded-xl flex items-center justify-center text-gray-600 transition-all duration-200 shadow-sm">
                            <i class="bi bi-linkedin text-sm"></i>
                        </a>
                        <a href="#" class="w-9 h-9 bg-white hover:bg-primary hover:text-white rounded-xl flex items-center justify-center text-gray-600 transition-all duration-200 shadow-sm">
                            <i class="bi bi-twitter-x text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     ÉQUIPE DE FORMATION
══════════════════════════════════════════════ --}}
<section class="py-20" style="background:linear-gradient(135deg,#F9FAFB,#E8FAF0);">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-green font-bold text-xs uppercase tracking-widest">Notre équipe</span>
            <h2 class="text-4xl font-extrabold text-gray-900 mt-2">Notre Équipe de Formation</h2>
            <p class="text-gray-500 mt-3">
                Les programmes Frizzly sont assurés par des spécialistes qualifiés dans les domaines suivants :
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @php
            $domains = [
                ['bi-book-fill',           '#E94E3C', '#FDECEA', 'Sciences de l\'éducation',              'Théories et pratiques éducatives, fondements pédagogiques et recherche en éducation.'],
                ['bi-person-video3',        '#4DA3FF', '#EBF4FF', 'Formation des formateurs',              'Ingénierie de formation et accompagnement des professionnels de l\'éducation.'],
                ['bi-award-fill',           '#2ECC71', '#E8FAF0', 'Développement professionnel enseignant','Accompagnement de la posture professionnelle et de la progression de carrière.'],
                ['bi-rocket-takeoff-fill',  '#8E6CFF', '#F0ECFF', 'Compétences entrepreneuriales',        'Maîtrise du référentiel EntreComp et des méthodes de développement entrepreneurial.'],
                ['bi-emoji-smile-fill',     '#FFC857', '#FFF8E7', 'Soft skills',                          'Communication, leadership et intelligence émotionnelle en contexte éducatif.'],
                ['bi-lightbulb-fill',       '#F97316', '#FEF3EA', 'Innovation pédagogique',               'Conception de dispositifs innovants, approches actives et intégration numérique.'],
            ];
            @endphp

            @foreach($domains as $d)
            <div class="bg-white rounded-2xl p-6 card-hover shadow-sm border-2" style="border-color:{{ $d[1] }}18;">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4 shadow-md" style="background:{{ $d[1] }};">
                    <i class="bi {{ $d[0] }} text-white text-xl"></i>
                </div>
                <h4 class="font-bold text-gray-900 mb-2">{{ $d[3] }}</h4>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $d[4] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 relative overflow-hidden" style="background:linear-gradient(135deg,#E94E3C,#8E6CFF);">
    <div class="absolute inset-0 animate-gradient opacity-20"
         style="background:linear-gradient(135deg,#E94E3C,#FFC857,#4DA3FF);background-size:300% 300%;"></div>
    <div class="max-w-3xl mx-auto px-6 text-center relative z-10">
        <h2 class="text-3xl font-extrabold text-white mb-4">Vous partagez notre vision ?</h2>
        <p class="text-white/80 mb-8">Rejoignez la communauté Frizzly 🇹🇳 et transformez votre pratique pédagogique.</p>
        <a href="{{ route('contact') }}"
           class="inline-flex items-center gap-2 bg-white text-primary px-8 py-4 rounded-2xl font-bold text-lg
                  hover:bg-secondary hover:text-gray-900 transition-all duration-200 shadow-2xl hover:-translate-y-1">
            <i class="bi bi-envelope-fill"></i> Contactez-nous
        </a>
    </div>
</section>

@endsection
