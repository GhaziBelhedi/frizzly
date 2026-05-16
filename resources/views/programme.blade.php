@extends('layouts.app')

@section('title', 'Programme de Formation')
@section('description', 'Développer la posture professionnelle de l\'enseignant du primaire à travers les compétences entrepreneuriales — 5 modules · 49 heures.')

@section('content')

{{-- ═══════════════════════════════════════════
     HERO
═══════════════════════════════════════════ --}}
<section class="bg-gradient-to-br from-accent-blue/10 via-white to-primary/5 py-20 lg:py-28 relative overflow-hidden">
    <div class="absolute -top-10 -right-10 w-72 h-72 bg-accent-blue/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-10 -left-10 w-60 h-60 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="max-w-5xl mx-auto px-6 text-center relative z-10">
        <span class="inline-block bg-primary/10 text-primary text-sm font-semibold px-4 py-2 rounded-full mb-6">
            <i class="bi bi-mortarboard-fill mr-1"></i> Programme de Formation
        </span>
        <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 leading-tight mb-4">
            Développer la <span class="text-primary">posture professionnelle</span><br>
            de l'enseignant du primaire
        </h1>
        <p class="text-xl font-semibold text-gray-700 mb-3">à travers les compétences entrepreneuriales</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="#modules"
               class="inline-flex items-center gap-2 bg-primary text-white px-8 py-4 rounded-2xl font-bold text-lg shadow-lg shadow-primary/30 hover:bg-primary-dark hover:-translate-y-0.5 transition-all duration-200">
                <i class="bi bi-play-fill"></i>
                Découvrir les modules
            </a>
            <a href="{{ route('contact') }}"
               class="inline-flex items-center gap-2 bg-white text-gray-700 px-8 py-4 rounded-2xl font-bold text-lg border-2 border-gray-200 hover:border-primary hover:text-primary transition-all duration-200">
                S'inscrire <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     STATS BAR
═══════════════════════════════════════════ --}}
<section class="bg-white py-10 border-b border-gray-100">
    <div class="max-w-5xl mx-auto px-6">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 text-center">
            <div>
                <p class="text-3xl font-extrabold text-primary">5</p>
                <p class="text-gray-500 text-sm mt-1">Modules progressifs</p>
            </div>
            <div>
                <p class="text-3xl font-extrabold text-accent-blue">49h</p>
                <p class="text-gray-500 text-sm mt-1">Formation présentielle</p>
            </div>
            <div>
                <p class="text-3xl font-extrabold text-accent-green">9</p>
                <p class="text-gray-500 text-sm mt-1">Compétences entrepreneuriales</p>
            </div>
            <div>
                <p class="text-3xl font-extrabold text-accent-purple">Cycles 1·2·3</p>
                <p class="text-gray-500 text-sm mt-1">Enseignants du primaire</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     PRÉSENTATION GÉNÉRALE
═══════════════════════════════════════════ --}}
<section class="bg-gray-50 py-16">
    <div class="max-w-5xl mx-auto px-6">
        <div class="bg-white rounded-3xl p-8 lg:p-12 border border-gray-100 shadow-sm">
            <div class="flex items-start gap-5">
                <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center shrink-0">
                    <i class="bi bi-file-text-fill text-primary text-2xl"></i>
                </div>
                <div>
                    <span class="text-primary font-semibold text-sm uppercase tracking-widest">I. Présentation générale</span>
                    <h2 class="text-2xl font-extrabold text-gray-900 mt-1 mb-5">À propos du programme</h2>
                    <div class="space-y-4 text-gray-600 leading-relaxed">
                        <p>
Ce programme de formation vise à développer les compétences entrepreneuriales des enseignants du primaire afin de transformer leur posture professionnelle sur les plans pédagogique, relationnel et institutionnel. Structuré en cinq modules progressifs et complémentaires, il couvre neuf compétences clés et combine des apports théoriques, des activités pratiques en classe ainsi qu’une démarche réflexive collective.                        </p>
                       
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     PRINCIPES DIRECTEURS
═══════════════════════════════════════════ --}}
<section class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-primary font-semibold text-sm uppercase tracking-widest">Ce qui guide la formation</span>
            <h2 class="text-4xl font-extrabold text-gray-900 mt-2">Principes directeurs</h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @php
            $principles = [
                [
                    'num'   => '01',
                    'icon'  => 'bi-geo-alt-fill',
                    'color' => 'text-primary',
                    'bg'    => 'bg-primary/10',
                    'title' => 'Ancrage situationnel',
                    'desc'  => 'Chaque compétence est développée dans et par des situations professionnelles réelles, non simulées.',
                ],
                [
                    'num'   => '02',
                    'icon'  => 'bi-arrow-up-right-circle-fill',
                    'color' => 'text-accent-blue',
                    'bg'    => 'bg-accent-blue/10',
                    'title' => 'Progressivité',
                    'desc'  => 'Les modules suivent une logique du développement individuel vers l\'action collective, de la réflexion vers l\'initiative.',
                ],
                [
                    'num'   => '03',
                    'icon'  => 'bi-people-fill',
                    'color' => 'text-accent-green',
                    'bg'    => 'bg-accent-green/10',
                    'title' => 'Réciprocité',
                    'desc'  => 'La formation repose sur l\'intelligence collective des pairs — chaque enseignant est à la fois apprenant et ressource.',
                ],
                [
                    'num'   => '04',
                    'icon'  => 'bi-journal-text',
                    'color' => 'text-accent-purple',
                    'bg'    => 'bg-accent-purple/10',
                    'title' => 'Réflexivité permanente',
                    'desc'  => 'Le journal de bord réflexif est le fil conducteur de l\'ensemble du parcours.',
                ],
                [
                    'num'   => '05',
                    'icon'  => 'bi-book-fill',
                    'color' => 'text-secondary-dark',
                    'bg'    => 'bg-secondary/20',
                    'title' => 'Ancrage scientifique',
                    'desc'  => 'Chaque dispositif est justifié par au moins une référence théorique issue de la littérature en sciences de l\'éducation ou en entrepreneuriat.',
                ],
            ];
            @endphp

            @foreach($principles as $p)
            <div class="bg-gray-50 rounded-2xl p-6 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 {{ $p['bg'] }} rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-200">
                        <i class="bi {{ $p['icon'] }} {{ $p['color'] }} text-xl"></i>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-400">{{ $p['num'] }}</span>
                        <h4 class="font-bold text-gray-900 mb-1">{{ $p['title'] }}</h4>
                        <p class="text-gray-500 text-sm leading-relaxed">{{ $p['desc'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     PUBLIC CIBLE & CONTEXTE
═══════════════════════════════════════════ --}}
<section class="bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-primary font-semibold text-sm uppercase tracking-widest">II. Public & Contexte</span>
            <h2 class="text-4xl font-extrabold text-gray-900 mt-2">Pour qui, où et comment ?</h2>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            {{-- Public cible --}}
            <div class="bg-white rounded-2xl p-7 shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4">
                    <i class="bi bi-person-fill text-primary text-xl"></i>
                </div>
                <h3 class="text-xl font-extrabold text-gray-900 mb-4">Public cible</h3>
                <ul class="space-y-3 text-sm text-gray-600">
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check-circle-fill text-primary mt-0.5 shrink-0"></i>
                        <span>Enseignants du primaire en exercice, tous cycles confondus (cycle 1, 2 et 3).</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check-circle-fill text-primary mt-0.5 shrink-0"></i>
                        <span>Enseignants <strong>volontaires</strong> — la dimension entrepreneuriale doit être librement choisie.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check-circle-fill text-primary mt-0.5 shrink-0"></i>
                        <span>Aucun prérequis en entrepreneuriat ; seule une disposition à l'expérimentation et à la réflexivité est attendue.</span>
                    </li>
                </ul>
            </div>

            {{-- Contexte institutionnel --}}
            <div class="bg-white rounded-2xl p-7 shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-accent-blue/10 rounded-xl flex items-center justify-center mb-4">
                    <i class="bi bi-building-fill text-accent-blue text-xl"></i>
                </div>
                <h3 class="text-xl font-extrabold text-gray-900 mb-4">Contexte institutionnel</h3>
                
            </div>

            {{-- Intervenants --}}
            <div class="bg-white rounded-2xl p-7 shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-accent-green/10 rounded-xl flex items-center justify-center mb-4">
                    <i class="bi bi-person-video3 text-accent-green text-xl"></i>
                </div>
                <h3 class="text-xl font-extrabold text-gray-900 mb-4">Intervenants</h3>
                <ul class="space-y-3 text-sm text-gray-600">
                    <li class="flex items-start gap-2">
                        <span class="w-2 h-2 bg-accent-green rounded-full mt-1.5 shrink-0"></span>
                        <span>Un <strong>formateur spécialisé</strong> en développement professionnel enseignant (intervenant externe).</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="w-2 h-2 bg-accent-blue rounded-full mt-1.5 shrink-0"></span>
                        <span>Un <strong>conseiller pédagogique de circonscription</strong> (garant de la cohérence institutionnelle).</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="w-2 h-2 bg-accent-purple rounded-full mt-1.5 shrink-0"></span>
                        <span>Les <strong>pairs formateurs</strong> issus du groupe de formation (dès le module 4, après développement des compétences collaboratives).</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     OBJECTIFS
═══════════════════════════════════════════ --}}
<section class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-primary font-semibold text-sm uppercase tracking-widest">III. Objectifs du programme</span>
            <h2 class="text-4xl font-extrabold text-gray-900 mt-2">Que vise-t-on ?</h2>
        </div>

        <div class="grid lg:grid-cols-2 gap-10">
            {{-- Objectif général --}}
            <div class="bg-primary rounded-2xl p-8">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-5">
                    <i class="bi bi-bullseye text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-extrabold text-white mb-4">Objectif général</h3>
                <p class="text-white/90 leading-relaxed">
                    Transformer la posture professionnelle des enseignants du primaire en développant <strong class="text-white">neuf compétences entrepreneuriales transversales</strong>, afin de produire des effets observables et interprétables sur leurs rapports au savoir, à l'élève et à l'institution scolaire.
                </p>
            </div>

            {{-- Objectifs spécifiques --}}
            <div>
                <h3 class="text-xl font-extrabold text-gray-900 mb-5 flex items-center gap-2">
                    <span class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center shrink-0">
                        <i class="bi bi-list-check text-primary"></i>
                    </span>
                    Objectifs spécifiques
                </h3>
                <ul class="space-y-3">
                    @php
                    $specific = [
                        'Développer la créativité et la résolution de problèmes comme compétences pédagogiques cultivables.',
                        'Renforcer l\'autonomie professionnelle et la confiance en soi dans les choix didactiques.',
                        'Développer la tolérance à l\'incertitude et la capacité à agir dans des situations imprévues.',
                        'Construire une culture de la collaboration authentique au sein de l\'équipe pédagogique.',
                        'Former au leadership pédagogique distribué : exercer une influence sans autorité hiérarchique.',
                        'Développer la prise d\'initiative comme disposition professionnelle stable et assumée.',
                        'Produire une posture réflexive continue, ancrée dans le concept de praticien réflexif.',
                    ];
                    @endphp
                    @foreach($specific as $obj)
                    <li class="flex items-start gap-3 text-sm text-gray-600">
                        <i class="bi bi-check2-circle text-accent-green text-base mt-0.5 shrink-0"></i>
                        <span>{{ $obj }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     LES 5 MODULES
═══════════════════════════════════════════ --}}
<section id="modules" class="bg-gray-50 py-20 lg:py-28">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-primary font-semibold text-sm uppercase tracking-widest">IV. Architecture modulaire</span>
            <h2 class="text-4xl font-extrabold text-gray-900 mt-2 mb-4">Les 5 modules progressifs</h2>
            <p class="text-gray-500">Chaque module articule une journée de formation présentielle et une période de mise en pratique en classe, avec un dispositif de suivi réflexif systématique.</p>
        </div>

        <div class="space-y-3">
            @php
            $modules = [
                [
                    'num'       => '01',
                    'title'     => 'Se connaître en tant que professionnel',
                    'objective' => 'Identifier ses schèmes d\'action habituels, ses forces professionnelles et ses zones d\'inconfort ; point de départ indispensable de tout développement entrepreneurial authentique.',
                    'duration'  => '14h',
                    'period'    => 'Septembre',
                    'skills'    => ['Autonomie', 'Confiance en soi'],
                    'accent'    => ['header' => 'bg-primary', 'pill_bg' => 'bg-primary/10', 'pill_text' => 'text-primary', 'border' => 'border-primary/30', 'dot' => 'bg-primary', 'icon_bg' => 'bg-primary/10', 'icon_text' => 'text-primary'],
                    'icon'      => 'bi-person-bounding-box',
                ],
                [
                    'num'       => '02',
                    'title'     => 'Créer et innover dans la pratique pédagogique',
                    'objective' => 'Développer la créativité comme compétence professionnelle cultivable en apprenant à concevoir des situations d\'apprentissage originales, à détourner les ressources et à transformer les contraintes en opportunités.',
                    'duration'  => '14h + 4 semaines',
                    'period'    => 'Octobre',
                    'skills'    => ['Créativité', 'Résolution de problèmes'],
                    'accent'    => ['header' => 'bg-accent-green', 'pill_bg' => 'bg-accent-green/10', 'pill_text' => 'text-accent-green', 'border' => 'border-accent-green/30', 'dot' => 'bg-accent-green', 'icon_bg' => 'bg-accent-green/10', 'icon_text' => 'text-accent-green'],
                    'icon'      => 'bi-lightbulb-fill',
                ],
                [
                    'num'       => '03',
                    'title'     => 'Agir dans l\'incertitude et assumer le risque pédagogique',
                    'objective' => 'Développer la tolérance à l\'incertitude et la prise de risque calculée — au sens de Lumpkin et Dess (1996) — en entraînant progressivement l\'enseignant à conduire des séances non scriptées et à construire une relation apprenante à l\'échec.',
                    'duration'  => '7h + 6 semaines',
                    'period'    => 'Novembre',
                    'skills'    => ['Prise de risque', 'Tolérance à l\'incertitude', 'Confiance en soi'],
                    'accent'    => ['header' => 'bg-accent-orange', 'pill_bg' => 'bg-accent-orange/10', 'pill_text' => 'text-accent-orange', 'border' => 'border-accent-orange/30', 'dot' => 'bg-accent-orange', 'icon_bg' => 'bg-accent-orange/10', 'icon_text' => 'text-accent-orange'],
                    'icon'      => 'bi-shield-fill-exclamation',
                ],
                [
                    'num'       => '04',
                    'title'     => 'Collaborer et co-construire en équipe pédagogique',
                    'objective' => 'Passer de la coexistence professionnelle à la collaboration authentique — en développant une intelligence relationnelle élaborée au service d\'une culture pédagogique collective.',
                    'duration'  => '7h + 1 projet',
                    'period'    => 'Décembre',
                    'skills'    => ['Collaboration', 'Leadership'],
                    'accent'    => ['header' => 'bg-accent-blue', 'pill_bg' => 'bg-accent-blue/10', 'pill_text' => 'text-accent-blue', 'border' => 'border-accent-blue/30', 'dot' => 'bg-accent-blue', 'icon_bg' => 'bg-accent-blue/10', 'icon_text' => 'text-accent-blue'],
                    'icon'      => 'bi-diagram-3-fill',
                ],
                [
                    'num'       => '05',
                    'title'     => 'Prendre des initiatives et exercer un leadership pédagogique',
                    'objective' => 'Développer la capacité à initier des changements professionnels sans mandat hiérarchique formel — en concevant et pilotant un projet pédagogique innovant au sein de l\'établissement.',
                    'duration'  => '7h + 1 trimestre',
                    'period'    => 'Janv.–Mars',
                    'skills'    => ['Prise d\'initiative', 'Leadership'],
                    'accent'    => ['header' => 'bg-accent-purple', 'pill_bg' => 'bg-accent-purple/10', 'pill_text' => 'text-accent-purple', 'border' => 'border-accent-purple/30', 'dot' => 'bg-accent-purple', 'icon_bg' => 'bg-accent-purple/10', 'icon_text' => 'text-accent-purple'],
                    'icon'      => 'bi-rocket-takeoff-fill',
                ],
            ];
            @endphp

            @foreach($modules as $mod)
            <div class="group bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 overflow-hidden">
                <div class="flex items-stretch">

                    {{-- Colored sidebar with icon --}}
                    <div class="{{ $mod['accent']['header'] }} w-14 shrink-0 flex flex-col items-center justify-center gap-1 relative overflow-hidden py-4">
                        <span class="absolute text-white/10 font-black text-6xl leading-none select-none -bottom-1">{{ $mod['num'] }}</span>
                        <i class="bi {{ $mod['icon'] }} text-white text-xl relative z-10"></i>
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0 px-5 py-4">

                        {{-- Title row --}}
                        <div class="flex items-start justify-between gap-3 mb-2">
                            <div class="min-w-0">
                                <span class="text-[10px] font-bold uppercase tracking-[0.14em] text-gray-400">Module {{ $mod['num'] }}</span>
                                <h3 class="text-gray-900 font-extrabold text-[15px] leading-snug">{{ $mod['title'] }}</h3>
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0 mt-0.5">
                                <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-500 text-[11px] font-medium px-2.5 py-1 rounded-full">
                                    <i class="bi bi-calendar3 text-[9px]"></i> {{ $mod['period'] }}
                                </span>
                                <span class="inline-flex items-center gap-1 {{ $mod['accent']['pill_bg'] }} {{ $mod['accent']['pill_text'] }} {{ $mod['accent']['border'] }} border text-[11px] font-bold px-2.5 py-1 rounded-full">
                                    <i class="bi bi-clock text-[9px]"></i> {{ $mod['duration'] }}
                                </span>
                            </div>
                        </div>

                        {{-- Objective --}}
                        <p class="text-gray-500 text-sm leading-relaxed mb-3">{{ $mod['objective'] }}</p>

                        {{-- Footer: skills --}}
                        <div class="flex flex-wrap items-center gap-1.5">
                            <span class="text-[10px] font-bold uppercase tracking-[0.12em] text-gray-400 mr-1">Compétences :</span>
                            @foreach($mod['skills'] as $skill)
                            <span class="{{ $mod['accent']['pill_bg'] }} {{ $mod['accent']['pill_text'] }} text-[11px] font-semibold px-2.5 py-0.5 rounded-full">{{ $skill }}</span>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>




{{-- ═══════════════════════════════════════════
     DISPOSITIF D'ÉVALUATION
═══════════════════════════════════════════ --}}
<section class="bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-primary font-semibold text-sm uppercase tracking-widest">VI. Évaluation</span>
            <h2 class="text-4xl font-extrabold text-gray-900 mt-2">Dispositif d'évaluation</h2>
        </div>

        <div class="grid lg:grid-cols-2 gap-10 mb-12">
            {{-- Philosophie --}}
            <div class="bg-white rounded-2xl p-7 shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4">
                    <i class="bi bi-lightbulb-fill text-primary text-xl"></i>
                </div>
                <h3 class="text-xl font-extrabold text-gray-900 mb-3">Philosophie de l'évaluation</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    L'évaluation de ce programme s'inscrit résolument dans une logique <strong>formative et non normative</strong>. Elle ne vise pas à classer les enseignants selon un niveau de compétence, mais à rendre visibles les transformations en cours, à identifier les résistances et les leviers, et à ajuster le dispositif en conséquence. Elle s'appuie sur la distinction schönienne entre <em>réflexion sur l'action</em> et <em>réflexion dans l'action</em>.
                </p>
            </div>

            {{-- Outils --}}
            <div class="bg-white rounded-2xl p-7 shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-accent-green/10 rounded-xl flex items-center justify-center mb-4">
                    <i class="bi bi-tools text-accent-green text-xl"></i>
                </div>
                <h3 class="text-xl font-extrabold text-gray-900 mb-4">Outils d'évaluation</h3>
                <ul class="space-y-2.5">
                    @php
                    $tools = [
                        'Grille d\'auto-évaluation des 9 compétences (échelle 1 à 5) — début, mi-parcours et fin de formation.',
                        'Journal de bord réflexif analysé par l\'enseignant selon une grille d\'analyse fournie.',
                        'Observation de pratique par un pair — protocole structuré d\'observation et de feedback.',
                        'Entretien de bilan individuel en fin de programme (30 min) avec le formateur.',
                        'Évaluation collective du programme par le groupe à l\'issue de la dernière session.',
                    ];
                    @endphp
                    @foreach($tools as $tool)
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <i class="bi bi-check2-circle text-accent-green mt-0.5 shrink-0"></i>
                        <span>{{ $tool }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Grille de progression --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-800 px-6 py-4">
                <h3 class="text-white font-extrabold text-lg flex items-center gap-2">
                    <i class="bi bi-grid-3x3 text-secondary"></i>
                    Grille de progression des compétences
                </h3>
                <p class="text-gray-400 text-xs mt-1">
                    1 = non mobilisée &nbsp;·&nbsp; 2 = émergente &nbsp;·&nbsp; 3 = en développement &nbsp;·&nbsp; 4 = maîtrisée &nbsp;·&nbsp; 5 = modélisée pour les pairs
                </p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-5 py-3 text-left font-bold text-gray-700">Compétence évaluée</th>
                            <th class="px-5 py-3 text-center font-bold text-gray-700">Début de formation</th>
                            <th class="px-5 py-3 text-center font-bold text-gray-700">Mi-parcours</th>
                            <th class="px-5 py-3 text-center font-bold text-gray-700">Fin de formation</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php
                        $competences = [
                            ['name' => 'Créativité',               'color' => 'text-accent-green',  'dot' => 'bg-accent-green'],
                            ['name' => 'Autonomie',                'color' => 'text-primary',       'dot' => 'bg-primary'],
                            ['name' => 'Confiance en soi',         'color' => 'text-accent-blue',   'dot' => 'bg-accent-blue'],
                            ['name' => 'Prise de risque',          'color' => 'text-accent-orange', 'dot' => 'bg-accent-orange'],
                            ['name' => 'Tolérance à l\'incertitude','color' => 'text-accent-purple','dot' => 'bg-accent-purple'],
                            ['name' => 'Résolution de problèmes',  'color' => 'text-accent-green',  'dot' => 'bg-accent-green'],
                            ['name' => 'Collaboration',            'color' => 'text-accent-blue',   'dot' => 'bg-accent-blue'],
                            ['name' => 'Leadership',               'color' => 'text-secondary-dark','dot' => 'bg-secondary'],
                            ['name' => 'Prise d\'initiative',      'color' => 'text-primary',       'dot' => 'bg-primary'],
                        ];
                        @endphp
                        @foreach($competences as $c)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3.5">
                                <span class="flex items-center gap-2 font-semibold text-gray-800">
                                    <span class="w-2.5 h-2.5 {{ $c['dot'] }} rounded-full shrink-0"></span>
                                    {{ $c['name'] }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex items-center justify-center w-16 h-8 bg-gray-100 rounded-lg text-gray-500 font-bold text-sm">/5</span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex items-center justify-center w-16 h-8 bg-gray-100 rounded-lg text-gray-500 font-bold text-sm">/5</span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex items-center justify-center w-16 h-8 bg-gray-100 rounded-lg text-gray-500 font-bold text-sm">/5</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     CTA
═══════════════════════════════════════════ --}}
<section class="bg-primary py-20">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-4xl font-extrabold text-white mb-6">Prêt à transformer votre posture professionnelle ?</h2>
        <p class="text-xl text-white/80 mb-10 max-w-xl mx-auto">
            5 modules · 49 heures · 9 compétences entrepreneuriales
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('contact') }}"
               class="inline-flex items-center gap-2 bg-white text-primary px-10 py-4 rounded-2xl font-bold text-lg hover:bg-secondary hover:text-gray-900 transition-all duration-200 shadow-xl">
                <i class="bi bi-rocket-takeoff-fill"></i>
                S'inscrire à la formation
            </a>
            <a href="{{ route('about') }}"
               class="inline-flex items-center gap-2 border-2 border-white/40 text-white px-10 py-4 rounded-2xl font-bold text-lg hover:border-white hover:bg-white/10 transition-all duration-200">
                En savoir plus sur Frizzly
            </a>
        </div>
    </div>
</section>

@endsection
