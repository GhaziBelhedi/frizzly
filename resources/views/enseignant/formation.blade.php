@extends('layouts.enseignant')
@section('title', 'Mini-formations')
@section('page-title', 'Mini-formations')
@section('page-sub', '9 capsules pour développer vos compétences entrepreneuriales')

@section('content')
@php
$capsules = [
    [
        'num'=>1,'color'=>'#E94E3C','light'=>'#FDECEA',
        'title'=>'Autonomie & Confiance en soi',
        'desc'  =>'Comprendre les fondements de l\'autonomie professionnelle et développer votre confiance dans la prise de décision pédagogique.',
        'module'=>'Module 1 — Se connaître','duration'=>'8 min','status'=>'complété',
        'contenu'=>[
            'Définition de l\'autonomie dans le contexte éducatif',
            'Les 3 niveaux de confiance en soi de l\'enseignant',
            'Exercice : Cartographie de vos zones de confort et d\'inconfort',
            'Pratique en classe : Carte conatif — "Prise de décision autonome"',
        ],
    ],
    [
        'num'=>2,'color'=>'#4DA3FF','light'=>'#EBF4FF',
        'title'=>'Créativité pédagogique',
        'desc'  =>'Explorer les méthodes pour stimuler votre créativité et celle de vos élèves à travers des situations pédagogiques innovantes.',
        'module'=>'Module 2 — Créer & Innover','duration'=>'10 min','status'=>'complété',
        'contenu'=>[
            'La créativité : mythe ou compétence développable ?',
            'Design thinking appliqué à la pédagogie',
            'Les 5 types de cartes cognitives du Frizzly Kit',
            'Pratique : Défi créatif en classe',
        ],
    ],
    [
        'num'=>3,'color'=>'#2ECC71','light'=>'#E8FAF0',
        'title'=>'Pensée critique',
        'desc'  =>'Développer votre capacité à questionner, analyser et évaluer vos pratiques pédagogiques avec rigueur et ouverture.',
        'module'=>'Module 2 — Créer & Innover','duration'=>'8 min','status'=>'en_cours',
        'progress'=>45,
        'contenu'=>[
            'Qu\'est-ce que la pensée critique ? (définition et importance)',
            'Les biais cognitifs courants chez l\'enseignant',
            'Outils pour développer la pensée critique en classe',
            'Situation-problème : Analyse d\'une séance filmée',
        ],
    ],
    [
        'num'=>4,'color'=>'#FFC857','light'=>'#FFF8E7',
        'title'=>'Innovation pédagogique',
        'desc'  =>'Comprendre comment créer et tester de nouvelles approches pédagogiques dans votre classe, sans risque.',
        'module'=>'Module 2 — Créer & Innover','duration'=>'9 min','status'=>'disponible',
        'contenu'=>[
            'Innovation incrémentale vs rupture en éducation',
            'Le cycle "essai-erreur-apprentissage" en pédagogie',
            'Exemples d\'innovations réussies en classe primaire',
            'Plan d\'action : Votre première innovation de la semaine',
        ],
    ],
    [
        'num'=>5,'color'=>'#F97316','light'=>'#FEF3EA',
        'title'=>'Gestion de l\'imprévu',
        'desc'  =>'Développer votre agilité face aux situations inattendues et transformer l\'imprévu en opportunité d\'apprentissage.',
        'module'=>'Module 3 — Agir dans l\'incertitude','duration'=>'7 min','status'=>'verrouillé',
        'contenu'=>[
            'L\'imprévu comme donnée pédagogique',
            'Stratégies d\'adaptation en temps réel',
            'Le rôle de l\'émotion dans la gestion de l\'inattendu',
            'Pratique : Cartes "Gestion de l\'imprévu"',
        ],
    ],
    [
        'num'=>6,'color'=>'#8E6CFF','light'=>'#F0ECFF',
        'title'=>'Pensée critique (suite)',
        'desc'  =>'Approfondir votre pratique réflexive et développer des outils concrets d\'auto-évaluation de vos séances.',
        'module'=>'Module 3 — Agir dans l\'incertitude','duration'=>'8 min','status'=>'verrouillé',
        'contenu'=>[
            'L\'auto-évaluation : entre objectivité et bienveillance',
            'Outils du Frizzly Kit pour la réflexion post-séance',
            'Le carnet d\'évolution comme outil de pensée critique',
            'Exercice : Analyse d\'une de vos séances passées',
        ],
    ],
    [
        'num'=>7,'color'=>'#EC4899','light'=>'#FDF2F8',
        'title'=>'Collaboration & Travail d\'équipe',
        'desc'  =>'Renforcer vos compétences collaboratives pour travailler efficacement en équipe pédagogique et avec les élèves.',
        'module'=>'Module 4 — Collaborer','duration'=>'9 min','status'=>'verrouillé',
        'contenu'=>[
            'La collaboration comme compétence professionnelle',
            'Les dynamiques de groupe en classe',
            'Les 7 rôles Socita : guide d\'utilisation avancé',
            'Co-construction d\'activités avec les collègues',
        ],
    ],
    [
        'num'=>8,'color'=>'#06B6D4','light'=>'#ECFEFF',
        'title'=>'Communication professionnelle',
        'desc'  =>'Développer votre assertivité et vos capacités de communication avec les élèves, les parents et l\'équipe.',
        'module'=>'Module 4 — Collaborer','duration'=>'8 min','status'=>'verrouillé',
        'contenu'=>[
            'Les 4 piliers de la communication assertive',
            'Communiquer différemment avec différents publics',
            'Retour d\'expérience et feedback constructif',
            'Pratique : Cartes Social du Frizzly Kit',
        ],
    ],
    [
        'num'=>9,'color'=>'#84CC16','light'=>'#F7FEE7',
        'title'=>'Leadership pédagogique',
        'desc'  =>'Incarner un leadership bienveillant et inspirant qui encourage l\'autonomie et la créativité des élèves.',
        'module'=>'Module 5 — Leadership','duration'=>'10 min','status'=>'verrouillé',
        'contenu'=>[
            'Leadership vs autorité en contexte éducatif',
            'Styles de leadership et leur impact sur la classe',
            'L\'enseignant comme entrepreneur social',
            'Vision : Quel enseignant voulez-vous être ?',
        ],
    ],
];
@endphp

{{-- Progress banner --}}
<div class="e-card mb-7 flex items-center gap-6 flex-wrap">
    <div class="flex-1 min-w-0">
        <div class="flex items-center justify-between mb-2">
            <p class="font-bold text-gray-900">Progression du programme</p>
            <p class="font-extrabold text-primary">2/9 capsules complétées</p>
        </div>
        <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full rounded-full" style="width:22%;background:linear-gradient(90deg,#E94E3C,#FFC857,#4DA3FF);"
                 x-data x-init="$el.style.cssText='width:0;transition:width 1.2s ease;background:linear-gradient(90deg,#E94E3C,#FFC857,#4DA3FF)';setTimeout(()=>$el.style.width='22%',200)"></div>
        </div>
        <div class="flex justify-between text-xs text-gray-400 mt-1.5">
            <span>Départ</span>
            <span>2 complétées · 1 en cours · 6 verrouillées</span>
            <span>9 capsules</span>
        </div>
    </div>
    <div class="flex items-center gap-3 shrink-0">
        @foreach([['#2ECC71','Complété'],['#F97316','En cours'],['#e2e8f0','À venir']] as $leg)
        <div class="flex items-center gap-1.5">
            <div class="w-3 h-3 rounded-full" style="background:{{ $leg[0] }};"></div>
            <span class="text-xs text-gray-500">{{ $leg[1] }}</span>
        </div>
        @endforeach
    </div>
</div>

{{-- Capsules grid --}}
<div class="grid md:grid-cols-2 xl:grid-cols-3 gap-5" x-data="{ open: null }">
    @foreach($capsules as $c)
    <div class="bg-white rounded-2xl border-2 overflow-hidden transition-all duration-300
                {{ $c['status']==='verrouillé' ? 'opacity-60' : 'hover:shadow-xl hover:-translate-y-1' }}"
         style="border-color:{{ $c['color'] }}25;">

        {{-- Top bar --}}
        <div class="h-1.5" style="background:{{ $c['status']==='verrouillé' ? '#e2e8f0' : $c['color'] }};"></div>

        <div class="p-6">

            {{-- Header --}}
            <div class="flex items-start gap-3 mb-3">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center font-extrabold text-lg text-white shrink-0"
                     style="background:{{ $c['status']==='verrouillé' ? '#e2e8f0' : $c['color'] }};">
                    {{ $c['num'] }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-gray-400 truncate">{{ $c['module'] }}</p>
                    <h3 class="font-bold text-gray-900 text-sm leading-snug">{{ $c['title'] }}</h3>
                </div>
                @if($c['status']==='complété')
                <div class="w-7 h-7 rounded-full bg-green flex items-center justify-center shrink-0">
                    <i class="bi bi-check-lg text-white text-xs"></i>
                </div>
                @elseif($c['status']==='verrouillé')
                <i class="bi bi-lock-fill text-gray-300 shrink-0"></i>
                @endif
            </div>

            <p class="text-xs text-gray-500 leading-relaxed mb-4">{{ $c['desc'] }}</p>

            {{-- Progress bar for en_cours --}}
            @if($c['status']==='en_cours')
            <div class="mb-4">
                <div class="flex justify-between text-xs mb-1">
                    <span class="text-gray-400">En cours</span>
                    <span class="font-bold" style="color:{{ $c['color'] }};">{{ $c['progress'] }}%</span>
                </div>
                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full" style="width:{{ $c['progress'] }}%;background:{{ $c['color'] }};"
                         x-data x-init="$el.style.cssText='width:0;transition:width 1s ease;background:{{ $c['color'] }}';setTimeout(()=>$el.style.width='{{ $c['progress'] }}%',300)"></div>
                </div>
            </div>
            @endif

            {{-- Meta --}}
            <div class="flex items-center gap-3 mb-4 text-xs text-gray-400">
                <span><i class="bi bi-clock mr-1" style="color:{{ $c['color'] }};"></i>{{ $c['duration'] }}</span>
                <span><i class="bi bi-list-ul mr-1" style="color:{{ $c['color'] }};"></i>4 sections</span>
            </div>

            {{-- Contenu dropdown --}}
            <div x-data="{ openContent: false }">
                <button @click="openContent = !openContent"
                        class="flex items-center gap-2 text-xs font-semibold mb-3 transition-colors"
                        style="color:{{ $c['color'] }};">
                    <i class="bi transition-transform duration-200" :class="openContent ? 'bi-chevron-up':'bi-chevron-down'"></i>
                    Voir le contenu
                </button>
                <div x-show="openContent" x-collapse class="mb-4">
                    <ul class="space-y-1.5">
                        @foreach($c['contenu'] as $ci => $section)
                        <li class="flex items-start gap-2 text-xs text-gray-600">
                            <span class="w-5 h-5 rounded-full flex items-center justify-center shrink-0 text-xs font-bold mt-0.5"
                                  style="background:{{ $c['color'] }}18;color:{{ $c['color'] }};">{{ $ci+1 }}</span>
                            {{ $section }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- CTA --}}
            @if($c['status']==='complété')
            <button class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-xs font-bold border-2 transition-all"
                    style="border-color:{{ $c['color'] }};color:{{ $c['color'] }};">
                <i class="bi bi-arrow-repeat"></i> Revoir la capsule
            </button>
            @elseif($c['status']==='en_cours')
            <a href="#"
               class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-xs font-bold text-white hover:-translate-y-0.5 transition-all"
               style="background:{{ $c['color'] }};">
                <i class="bi bi-play-fill"></i> Continuer ({{ $c['progress'] }}%)
            </a>
            @elseif($c['status']==='disponible')
            <a href="#"
               class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-xs font-bold text-white hover:-translate-y-0.5 transition-all"
               style="background:{{ $c['color'] }};">
                <i class="bi bi-play-circle-fill"></i> Commencer la capsule
            </a>
            @else
            <button disabled
                    class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-xs font-bold text-gray-400 bg-gray-100 cursor-not-allowed">
                <i class="bi bi-lock-fill"></i> Compléter les capsules précédentes
            </button>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection
