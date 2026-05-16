@extends('layouts.enseignant')
@section('title', 'Ma Progression')
@section('page-title', 'Ma Progression')
@section('page-sub', 'Évolution de vos compétences entrepreneuriales')

@section('content')
@php
$competences = [
    ['name'=>'Adaptabilité',        'score'=>88,'prev'=>65,'color'=>'#2ECC71','icon'=>'bi-arrow-repeat',          'dim'=>'Action & Conatif'],
    ['name'=>'Créativité',           'score'=>75,'prev'=>50,'color'=>'#4DA3FF','icon'=>'bi-lightbulb-fill',        'dim'=>'Cognitif & Créatif'],
    ['name'=>'Prise d\'initiative',  'score'=>70,'prev'=>55,'color'=>'#8E6CFF','icon'=>'bi-lightning-charge-fill', 'dim'=>'Action & Conatif'],
    ['name'=>'Collaboration',        'score'=>62,'prev'=>48,'color'=>'#FFC857','icon'=>'bi-people-fill',           'dim'=>'Social'],
    ['name'=>'Communication',        'score'=>58,'prev'=>40,'color'=>'#F97316','icon'=>'bi-chat-fill',             'dim'=>'Social'],
    ['name'=>'Pensée critique',      'score'=>50,'prev'=>38,'color'=>'#E94E3C','icon'=>'bi-search',               'dim'=>'Cognitif & Créatif'],
    ['name'=>'Innovation',           'score'=>68,'prev'=>45,'color'=>'#EC4899','icon'=>'bi-stars',                'dim'=>'Cognitif & Créatif'],
    ['name'=>'Leadership',           'score'=>55,'prev'=>42,'color'=>'#06B6D4','icon'=>'bi-person-check-fill',    'dim'=>'Action & Conatif'],
    ['name'=>'Autonomie',            'score'=>74,'prev'=>60,'color'=>'#84CC16','icon'=>'bi-person-walking',       'dim'=>'Action & Conatif'],
];
$historique = [
    ['quiz'=>'Test diagnostique',    'date'=>'20/04','score'=>72,'color'=>'#8E6CFF'],
    ['quiz'=>'Module 1 — Se connaître','date'=>'25/04','score'=>80,'color'=>'#E94E3C'],
    ['quiz'=>'Module 2 — Créativité', 'date'=>'—',   'score'=>null,'color'=>'#4DA3FF'],
];
$badges = [
    ['icon'=>'bi-trophy-fill',      'label'=>'Premier quiz',      'desc'=>'Quiz complété pour la 1re fois',   'unlocked'=>true, 'color'=>'#FFC857'],
    ['icon'=>'bi-star-fill',        'label'=>'Score 80%+',         'desc'=>'Obtenu 80% ou plus à un quiz',    'unlocked'=>true, 'color'=>'#4DA3FF'],
    ['icon'=>'bi-fire',             'label'=>'Série de 3',         'desc'=>'3 quiz complétés d\'affilée',      'unlocked'=>false,'color'=>'#F97316'],
    ['icon'=>'bi-people-fill',      'label'=>'Collaboratrice',     'desc'=>'Score 70%+ en Social',            'unlocked'=>false,'color'=>'#2ECC71'],
    ['icon'=>'bi-lightning-fill',   'label'=>'Éclair créatif',     'desc'=>'Score 80%+ en Cognitif',          'unlocked'=>false,'color'=>'#8E6CFF'],
    ['icon'=>'bi-patch-check-fill', 'label'=>'Programme certifié', 'desc'=>'Tous les modules complétés',      'unlocked'=>false,'color'=>'#E94E3C'],
];
@endphp

{{-- Top stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-7">
    @foreach([
        ['Progression globale','68%','→ +18% depuis le début','#E94E3C','#FDECEA','bi-graph-up-arrow'],
        ['Quiz complétés',     '2/5', '3 restants','#4DA3FF','#EBF4FF','bi-patch-check-fill'],
        ['Meilleur score',     '80%', 'Module 1','#2ECC71','#E8FAF0','bi-trophy-fill'],
        ['Compétences ciblées','9',   '3 maîtrisées (>70%)','#8E6CFF','#F0ECFF','bi-lightning-charge-fill'],
    ] as $s)
    <div class="e-card flex items-start gap-4">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background:{{ $s[4] }};">
            <i class="bi {{ $s[5] }} text-xl" style="color:{{ $s[3] }};"></i>
        </div>
        <div>
            <p class="text-xl font-extrabold text-gray-900">{{ $s[1] }}</p>
            <p class="text-xs text-gray-500">{{ $s[0] }}</p>
            <p class="text-xs font-semibold mt-0.5" style="color:{{ $s[3] }};">{{ $s[2] }}</p>
        </div>
    </div>
    @endforeach
</div>

<div class="grid lg:grid-cols-3 gap-6 mb-6">

    {{-- 9 competencies detail --}}
    <div class="lg:col-span-2 e-card">
        <h2 class="font-bold text-gray-900 mb-6 flex items-center gap-2">
            <i class="bi bi-bar-chart-fill text-purple"></i> Les 9 compétences entrepreneuriales
        </h2>

        {{-- Dimension filter --}}
        <div x-data="{ dim: 'Toutes' }" class="space-y-4">
            <div class="flex gap-2 flex-wrap mb-5">
                @foreach(['Toutes','Cognitif & Créatif','Action & Conatif','Social'] as $d)
                <button @click="dim = '{{ $d }}'"
                        :class="dim === '{{ $d }}' ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-500 hover:bg-gray-200'"
                        class="px-4 py-1.5 rounded-xl text-xs font-semibold transition-all">
                    {{ $d }}
                </button>
                @endforeach
            </div>

            @foreach($competences as $c)
            <div x-show="dim === 'Toutes' || dim === '{{ $c['dim'] }}'" class="pop-in">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0"
                         style="background:{{ $c['color'] }}18;">
                        <i class="bi {{ $c['icon'] }} text-sm" style="color:{{ $c['color'] }};"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-0.5">
                            <span class="text-sm font-semibold text-gray-800">{{ $c['name'] }}</span>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-400 line-through">{{ $c['prev'] }}%</span>
                                <span class="text-sm font-extrabold" style="color:{{ $c['color'] }};">{{ $c['score'] }}%</span>
                                <span class="text-xs font-bold text-green">+{{ $c['score'] - $c['prev'] }}%</span>
                            </div>
                        </div>
                        <div class="flex gap-1 items-center">
                            {{-- Previous bar (faded) --}}
                            <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden relative">
                                <div class="absolute h-full rounded-full opacity-25" style="width:{{ $c['prev'] }}%;background:{{ $c['color'] }};"></div>
                                <div class="h-full rounded-full transition-all duration-700" style="width:0;background:{{ $c['color'] }};"
                                     x-data x-init="setTimeout(()=>$el.style.width='{{ $c['score'] }}%',300)"></div>
                            </div>
                        </div>
                    </div>
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full shrink-0"
                          style="background:{{ $c['color'] }}15;color:{{ $c['color'] }};">{{ $c['dim'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Right column --}}
    <div class="space-y-6">

        {{-- Historique quiz --}}
        <div class="e-card">
            <h2 class="font-bold text-gray-900 mb-4 flex items-center gap-2 text-sm">
                <i class="bi bi-clock-history text-blue"></i> Historique des quiz
            </h2>
            <div class="relative pl-6">
                <div class="absolute left-2 top-0 bottom-0 w-px bg-gray-100"></div>
                @foreach($historique as $i => $h)
                <div class="relative mb-5 last:mb-0">
                    <div class="absolute -left-6 top-1 w-4 h-4 rounded-full border-2 border-white shadow-sm flex items-center justify-center"
                         style="background:{{ $h['color'] }};"></div>
                    <p class="text-xs text-gray-400 mb-0.5">{{ $h['date'] }}</p>
                    <p class="text-sm font-semibold text-gray-900 leading-snug mb-1">{{ $h['quiz'] }}</p>
                    @if($h['score'])
                    <div class="flex items-center gap-2">
                        <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full" style="width:{{ $h['score'] }}%;background:{{ $h['color'] }};"></div>
                        </div>
                        <span class="text-xs font-bold shrink-0" style="color:{{ $h['color'] }};">{{ $h['score'] }}%</span>
                    </div>
                    @else
                    <span class="text-xs text-orange font-semibold">À compléter</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        {{-- Score evolution visual --}}
        <div class="e-card">
            <h2 class="font-bold text-gray-900 mb-4 text-sm flex items-center gap-2">
                <i class="bi bi-graph-up text-primary"></i> Évolution du score
            </h2>
            <div class="flex items-end gap-2 h-28">
                @foreach([45,58,72,80,0,0] as $i => $v)
                <div class="flex-1 flex flex-col items-center gap-1">
                    @if($v > 0)
                    <span class="text-xs font-bold" style="color:{{ ['#8E6CFF','#F97316','#4DA3FF','#2ECC71','#E94E3C','#FFC857'][$i] }};">{{ $v }}%</span>
                    <div class="w-full rounded-t-xl transition-all"
                         style="height:{{ $v * 0.9 }}px;background:{{ ['#8E6CFF','#F97316','#4DA3FF','#2ECC71','#E94E3C','#FFC857'][$i] }};opacity:{{ 0.5 + $i*0.15 }};"
                         x-data x-init="$el.style.cssText='height:0;background:{{ ['#8E6CFF','#F97316','#4DA3FF','#2ECC71','#E94E3C','#FFC857'][$i] }};border-radius:8px 8px 0 0;width:100%;transition:height 1s ease';setTimeout(()=>$el.style.height='{{ $v * 0.9 }}px',200+{{ $i }}*150)"></div>
                    @else
                    <span class="text-xs text-gray-300">—</span>
                    <div class="w-full rounded-t-xl bg-gray-100" style="height:8px;"></div>
                    @endif
                    <span class="text-xs text-gray-400 text-center leading-tight">M{{ $i+1 }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Badges --}}
<div class="e-card">
    <h2 class="font-bold text-gray-900 mb-5 flex items-center gap-2">
        <i class="bi bi-patch-check-fill text-secondary"></i> Mes badges et accomplissements
    </h2>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($badges as $b)
        <div class="text-center p-4 rounded-2xl border-2 transition-all {{ $b['unlocked'] ? 'hover:-translate-y-1 hover:shadow-md' : 'opacity-40 grayscale' }}"
             style="border-color:{{ $b['unlocked'] ? $b['color'].'30' : '#e2e8f0' }};background:{{ $b['unlocked'] ? $b['color'].'08' : '#f8fafc' }};">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3"
                 style="background:{{ $b['color'] }}{{ $b['unlocked'] ? '20' : '10' }};">
                <i class="bi {{ $b['icon'] }} text-xl" style="color:{{ $b['color'] }};"></i>
            </div>
            <p class="text-xs font-bold text-gray-900 mb-1">{{ $b['label'] }}</p>
            <p class="text-xs text-gray-400 leading-tight">{{ $b['desc'] }}</p>
            @if(!$b['unlocked'])
            <p class="text-xs font-bold text-gray-400 mt-2"><i class="bi bi-lock-fill mr-1"></i>Verrouillé</p>
            @else
            <p class="text-xs font-bold mt-2" style="color:{{ $b['color'] }};"><i class="bi bi-check-circle-fill mr-1"></i>Obtenu</p>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection
