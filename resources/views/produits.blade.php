@extends('layouts.app')
@section('title', 'Frizzly Kit')

@section('content')

{{-- ══════════════════════════════════════════════
     HERO
══════════════════════════════════════════════ --}}
<section class="relative overflow-hidden py-20 lg:py-28"
         style="background:linear-gradient(135deg,#FFF8E7 0%,#FDECEA 50%,#F0ECFF 100%);">
    <div class="absolute top-0 right-0 w-72 h-72 rounded-full pointer-events-none"
         style="background:radial-gradient(circle, #FFC85740 0%, transparent 70%);"></div>
    <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
        <span class="inline-block text-secondary-dark font-bold text-xs uppercase tracking-widest bg-secondary/20 px-4 py-2 rounded-full mb-6">
            Kit pédagogique pour enseignants
        </span>
        <h1 class="text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
            Le <span class="text-primary">Frizzly Kit</span><br>
            pour l'enseignant de demain
        </h1>
        <p class="text-xl text-gray-500 max-w-2xl mx-auto leading-relaxed mb-10">
            Un dispositif pédagogique interactif pour développer vos compétences entrepreneuriales directement dans la pratique quotidienne de classe.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="#kit-contenu"
               class="inline-flex items-center gap-2 bg-primary text-white px-8 py-4 rounded-2xl font-bold text-lg
                      shadow-xl shadow-primary/30 hover:bg-primary-dark hover:-translate-y-0.5 transition-all duration-200">
                Découvrir le kit <i class="bi bi-box-seam-fill"></i>
            </a>
            <a href="{{ route('contact') }}"
               class="inline-flex items-center gap-2 bg-white text-gray-700 px-8 py-4 rounded-2xl font-bold text-lg
                      border-2 border-gray-200 hover:border-primary hover:text-primary transition-all duration-200">
                Commander <i class="bi bi-bag-fill"></i>
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     KIT OVERVIEW — 4 components
══════════════════════════════════════════════ --}}
<section id="kit-contenu" class="bg-white py-20 lg:py-28">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-primary font-bold text-xs uppercase tracking-widest">Composition du kit</span>
            <h2 class="text-4xl font-extrabold text-gray-900 mt-2 mb-3">4 outils pour transformer votre pratique</h2>
            <p class="text-gray-500">Une approche active où vous développez vos compétences dans la pratique quotidienne, en interaction avec vos apprenants.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
            $components = [
                [
                    'num'   => '01',
                    'icon'  => 'bi-grid-3x3-gap-fill',
                    'title' => 'Cartes pédagogiques',
                    'sub'   => 'Interactives',
                    'color' => '#4DA3FF',
                    'light' => '#EBF4FF',
                    'desc'  => 'Activités, défis et situations-problèmes organisés en trois dimensions : cognitif, conatif et social.',
                ],
                [
                    'num'   => '02',
                    'icon'  => 'bi-people-fill',
                    'title' => 'Cartes Socita',
                    'sub'   => 'Travail collaboratif',
                    'color' => '#2ECC71',
                    'light' => '#E8FAF0',
                    'desc'  => 'Un jeu interactif pour répartir les rôles des apprenants et dynamiser le travail de groupe en classe.',
                ],
                [
                    'num'   => '03',
                    'icon'  => 'bi-journal-richtext',
                    'title' => 'Livret de mini-formation',
                    'sub'   => '9 compétences',
                    'color' => '#FFC857',
                    'light' => '#FFF8E7',
                    'desc'  => 'Des capsules portant sur les neuf compétences entrepreneuriales fondamentales de l\'enseignant.',
                ],
                [
                    'num'   => '04',
                    'icon'  => 'bi-person-lines-fill',
                    'title' => 'Carnet d\'évolution',
                    'sub'   => 'Réflexion professionnelle',
                    'color' => '#8E6CFF',
                    'light' => '#F0ECFF',
                    'desc'  => 'Observez, analysez et auto-évaluez progressivement vos compétences professionnelles et entrepreneuriales.',
                ],
            ];
            @endphp

            @foreach($components as $c)
            <div class="rounded-3xl p-7 border-2 group card-hover"
                 style="background:{{ $c['light'] }}; border-color:{{ $c['color'] }}30;">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5 shadow-lg group-hover:scale-110 transition-transform duration-300"
                     style="background:{{ $c['color'] }};">
                    <i class="bi {{ $c['icon'] }} text-white text-2xl"></i>
                </div>
                <span class="inline-block text-xs font-bold px-2.5 py-1 rounded-full mb-3"
                      style="background:{{ $c['color'] }}20; color:{{ $c['color'] }};">
                    {{ $c['sub'] }}
                </span>
                <h3 class="text-lg font-extrabold text-gray-900 mb-2">{{ $c['title'] }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $c['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     CARTES PÉDAGOGIQUES — 3 dimensions
══════════════════════════════════════════════ --}}
<section class="py-20 lg:py-28" style="background:linear-gradient(135deg,#F9FAFB,#EBF4FF);">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-primary font-bold text-xs uppercase tracking-widest">Cartes pédagogiques</span>
            <h2 class="text-4xl font-extrabold text-gray-900 mt-2 mb-3">Trois dimensions de compétences</h2>
            <p class="text-gray-500">Chaque carte propose une activité, un défi ou une situation-problème adapté à la compétence ciblée.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @php
            $dimensions = [
                [
                    'icon'   => 'bi-lightbulb-fill',
                    'label'  => 'Cognitif et créatif',
                    'color'  => '#4DA3FF',
                    'light'  => '#EBF4FF',
                    'text'   => '#2D8EF5',
                    'skills' => ['Créativité','Pensée critique','Innovation','Résolution de problèmes'],
                    'types'  => ['Activité pédagogique','Situation-problème','Défi créatif'],
                    'desc'   => 'Des cartes pour stimuler l\'imagination, questionner les évidences et générer des solutions nouvelles face aux défis de la classe.',
                ],
                [
                    'icon'   => 'bi-lightning-charge-fill',
                    'label'  => 'Action et conatif',
                    'color'  => '#F97316',
                    'light'  => '#FEF3EA',
                    'text'   => '#D96010',
                    'skills' => ['Prise d\'initiative','Autonomie','Adaptabilité','Leadership','Gestion de l\'imprévu'],
                    'types'  => ['Défi pédagogique','Consigne interactive','Proposition de solution'],
                    'desc'   => 'Des cartes pour oser agir, prendre des décisions rapidement et s\'adapter avec assurance aux imprévus pédagogiques.',
                ],
                [
                    'icon'   => 'bi-people-fill',
                    'label'  => 'Social',
                    'color'  => '#2ECC71',
                    'light'  => '#E8FAF0',
                    'text'   => '#25A85E',
                    'skills' => ['Communication','Collaboration','Interaction sociale','Dynamique de groupe'],
                    'types'  => ['Activité collaborative','Situation-problème','Consigne interactive'],
                    'desc'   => 'Des cartes pour renforcer les liens, faciliter les échanges et créer une dynamique de classe positive et participative.',
                ],
            ];
            @endphp

            @foreach($dimensions as $d)
            <div class="group rounded-3xl overflow-hidden border-2 shadow-sm hover:shadow-2xl hover:-translate-y-3 transition-all duration-400 bg-white"
                 style="border-color:{{ $d['color'] }}30;">

                {{-- Header --}}
                <div class="h-40 relative flex items-center justify-center"
                     style="background:linear-gradient(135deg, {{ $d['light'] }}, {{ $d['color'] }}25);">
                    <div class="w-20 h-20 rounded-2xl shadow-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-400"
                         style="background:{{ $d['color'] }};">
                        <i class="bi {{ $d['icon'] }} text-white text-4xl"></i>
                    </div>
                </div>

                {{-- Body --}}
                <div class="p-7">
                    <h3 class="text-xl font-extrabold text-gray-900 mb-3">{{ $d['label'] }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-5">{{ $d['desc'] }}</p>

                    <p class="text-xs font-bold uppercase tracking-widest mb-3" style="color:{{ $d['color'] }};">Compétences développées</p>
                    <div class="flex flex-wrap gap-2 mb-5">
                        @foreach($d['skills'] as $skill)
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-lg"
                              style="background:{{ $d['color'] }}15; color:{{ $d['color'] }};">
                            {{ $skill }}
                        </span>
                        @endforeach
                    </div>

                    <p class="text-xs font-bold uppercase tracking-widest mb-3 text-gray-400">Types de cartes</p>
                    <ul class="space-y-1.5">
                        @foreach($d['types'] as $type)
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <div class="w-4 h-4 rounded-full flex items-center justify-center shrink-0"
                                 style="background:{{ $d['color'] }}20;">
                                <i class="bi bi-check-lg text-xs" style="color:{{ $d['color'] }};"></i>
                            </div>
                            {{ $type }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     CARTES SOCITA — 7 rôles
══════════════════════════════════════════════ --}}
<section class="bg-white py-20 lg:py-28">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-green font-bold text-xs uppercase tracking-widest">Jeu collaboratif</span>
            <h2 class="text-4xl font-extrabold text-gray-900 mt-2 mb-3">Les cartes <span class="text-primary">Socita</span></h2>
            <p class="text-gray-500">Un jeu interactif pour organiser les groupes, répartir les rôles et rendre les interactions plus participatives et dynamiques.</p>
        </div>

        <div class="grid grid-cols-3 md:grid-cols-4 gap-4 mb-12">
            @for($i = 1; $i <= 12; $i++)
            <div>
                <img src="{{ asset('pic/' . $i . '.jpeg') }}"
                     alt="Carte Socita {{ $i }}"
                     class="w-full h-full rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 object-cover aspect-square">
            </div>
            @endfor
        </div>

        
    </div>
</section>

{{-- ══════════════════════════════════════════════
     HOW TO USE — 5 étapes
══════════════════════════════════════════════ --}}
<section class="py-20" style="background:linear-gradient(135deg,#F9FAFB,#EBF4FF);">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-blue font-bold text-xs uppercase tracking-widest">Méthode d'utilisation</span>
            <h2 class="text-4xl font-extrabold text-gray-900 mt-2">Comment utiliser le Frizzly Kit ?</h2>
        </div>

        <div class="grid md:grid-cols-3 lg:grid-cols-5 gap-5">
            @php
            $steps = [
                ['1','#8E6CFF','bi-book-fill',          'Découverte',            'Consultez les capsules du livret pour découvrir les compétences entrepreneuriales ciblées.'],
                ['2','#4DA3FF','bi-grid-3x3-gap-fill',   'Choix des cartes',     'Sélectionnez les cartes selon vos objectifs, les besoins de la classe et la compétence à travailler.'],
                ['3','#2ECC71','bi-play-fill',            'Mise en pratique',     'Réalisez l\'activité, le défi ou la situation en classe avec vos apprenants.'],
                ['4','#FFC857','bi-chat-left-text-fill',  'Réflexion',            'Réfléchissez à votre expérience, vos réactions et les compétences mobilisées durant la pratique.'],
                ['5','#E94E3C','bi-clipboard2-check-fill','Auto-évaluation',      'Complétez le carnet d\'évolution pour suivre le développement de votre posture professionnelle.'],
            ];
            @endphp

            @foreach($steps as $s)
            <div class="bg-white rounded-2xl p-6 text-center card-hover shadow-sm">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-md"
                     style="background:{{ $s[1] }};">
                    <i class="bi {{ $s[2] }} text-white text-2xl"></i>
                </div>
                <span class="inline-block text-xs font-bold px-3 py-1 rounded-full mb-3"
                      style="background:{{ $s[1] }}15; color:{{ $s[1] }};">
                    Étape {{ $s[0] }}
                </span>
                <h4 class="font-bold text-gray-900 mb-2">{{ $s[3] }}</h4>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $s[4] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     KIT INFO + PRICING
══════════════════════════════════════════════ --}}
<section class="bg-white py-20">
    <div class="max-w-5xl mx-auto px-6">
        <div class="rounded-3xl overflow-hidden shadow-2xl"
             style="background:linear-gradient(135deg,#E94E3C,#FFC857);">
            <div class="grid lg:grid-cols-2">
                <div class="p-10 lg:p-14">
                    <span class="inline-block bg-white/20 text-white text-xs font-bold px-3 py-1.5 rounded-full mb-5">Frizzly Kit — Contenu complet</span>
                    <h2 class="text-3xl font-extrabold text-white mb-6">Ce que contient le kit</h2>
                    <ul class="space-y-3">
                        @foreach([
                            'Cartes pédagogiques interactives (3 dimensions)',
                            'Cartes Socita — 7 rôles collaboratifs',
                            'Livret de mini-formation (9 compétences entrepreneuriales)',
                            'Carnet d\'évolution professionnelle',
                            'Support pédagogique par email',
                        ] as $item)
                        <li class="flex items-center gap-3 text-white/90 text-sm">
                            <div class="w-5 h-5 bg-white/25 rounded-full flex items-center justify-center shrink-0">
                                <i class="bi bi-check-lg text-white text-xs"></i>
                            </div>
                            {{ $item }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="bg-white/10 flex items-center justify-center p-10">
                    <div class="bg-white rounded-3xl p-8 text-center shadow-2xl w-full max-w-xs">
                        <p class="text-gray-500 text-sm font-medium mb-1">Prix par kit enseignant</p>
                        <p class="text-6xl font-extrabold text-primary mb-1">49TND</p>
                        <p class="text-gray-400 text-xs mb-6">Livraison incluse en Tunisie 🇹🇳</p>
                        <a href="{{ route('contact') }}"
                           class="block bg-primary text-white py-3.5 rounded-xl font-bold text-base
                                  hover:bg-primary-dark hover:-translate-y-0.5 transition-all duration-200 shadow-lg shadow-primary/30">
                            Commander maintenant
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
