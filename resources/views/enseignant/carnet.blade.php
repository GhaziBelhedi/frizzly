@extends('layouts.enseignant')
@section('title', 'Carnet d\'évolution')
@section('page-title', 'Carnet d\'évolution professionnelle')
@section('page-sub', 'Réfléchissez à vos expériences et suivez le développement de votre posture')

@section('content')
@php
$entries = [
    [
        'id'=>1,'date'=>'02/05/2026','day'=>'Vendredi',
        'activity'=>'Cartes Socita — travail collaboratif en groupe',
        'dimension'=>'Social','dim_color'=>'#2ECC71',
        'feeling'=>'😊','feeling_label'=>'Satisfaite',
        'competences'=>['Collaboration','Communication','Leadership'],
        'comp_colors'=>['#2ECC71','#F97316','#8E6CFF'],
        'auto_eval'=>82,
        'reflexion'=>'Les élèves ont vraiment bien intégré leurs rôles. Le Gardien du temps a permis de structurer la séance de façon remarquable. J\'ai observé une dynamique positive entre le Porte-parole et le Médiateur encourageur. La prochaine fois, je vais introduire une rotation des rôles plus tôt.',
        'what_learned'=>'L\'attribution de rôles clairs transforme la dynamique de classe. Les élèves plus discrets prennent confiance quand ils ont un rôle défini.',
        'next_step'=>'Essayer les cartes cognitives avec ce même groupe.',
    ],
    [
        'id'=>2,'date'=>'28/04/2026','day'=>'Lundi',
        'activity'=>'Défi créatif — cartes dimension cognitif & créatif',
        'dimension'=>'Cognitif','dim_color'=>'#4DA3FF',
        'feeling'=>'🤔','feeling_label'=>'Réflexive',
        'competences'=>['Créativité','Adaptabilité','Pensée critique'],
        'comp_colors'=>['#4DA3FF','#2ECC71','#E94E3C'],
        'auto_eval'=>65,
        'reflexion'=>'Situation imprévue : un groupe s\'est bloqué face à la situation-problème. J\'ai dû adapter l\'activité en proposant un indice visuel non prévu. Ça a fonctionné mais j\'ai senti que j\'aurais pu mieux anticiper ce type de blocage.',
        'what_learned'=>'L\'adaptabilité face à l\'imprévu est un muscle qui se développe. Chaque situation difficile est une opportunité d\'apprentissage.',
        'next_step'=>'Préparer des "indices de secours" pour les prochaines activités cognitives.',
    ],
    [
        'id'=>3,'date'=>'22/04/2026','day'=>'Mercredi',
        'activity'=>'Situation-problème — cartes dimension action & conatif',
        'dimension'=>'Action','dim_color'=>'#F97316',
        'feeling'=>'😤','feeling_label'=>'Défiée',
        'competences'=>['Prise d\'initiative','Autonomie','Gestion de l\'imprévu'],
        'comp_colors'=>['#F97316',''.'#8E6CFF','#E94E3C'],
        'auto_eval'=>70,
        'reflexion'=>'J\'ai osé une activité sans réponse prédéfinie pour la première fois. C\'était inconfortable mais les élèves ont été surprenamment créatifs. Il faut que je lâche davantage le contrôle.',
        'what_learned'=>'La prise de risque pédagogique produit des résultats inattendus et souvent positifs.',
        'next_step'=>'Augmenter la fréquence des activités ouvertes.',
    ],
];
$competences_options = ['Créativité','Pensée critique','Innovation','Prise d\'initiative','Autonomie','Adaptabilité','Leadership','Communication','Collaboration','Gestion de l\'imprévu'];
$feelings = ['😊 Satisfaite','😤 Défiée','🤔 Réflexive','😅 Soulagée','💪 Confiante','😟 Incertaine'];
@endphp

<div x-data="{ showForm: false, autoEval: 70 }">

    <div class="flex items-center justify-between mb-7">
        {{-- Stats rapides --}}
        <div class="flex items-center gap-4">
            @foreach([['3','Réflexions','#4DA3FF'],['68%','Auto-éval. moy.','#2ECC71'],['3','Compétences','#8E6CFF']] as $s)
            <div class="e-card flex items-center gap-3 py-3 px-5">
                <span class="text-xl font-extrabold" style="color:{{ $s[2] }};">{{ $s[0] }}</span>
                <span class="text-xs text-gray-500">{{ $s[1] }}</span>
            </div>
            @endforeach
        </div>
        <button @click="showForm = !showForm"
                class="flex items-center gap-2 px-6 py-3 rounded-2xl text-sm font-bold text-white hover:-translate-y-0.5 transition-all shadow-lg"
                style="background:linear-gradient(135deg,#E94E3C,#FFC857);box-shadow:0 6px 20px #E94E3C33;">
            <i class="bi" :class="showForm ? 'bi-x-lg' : 'bi-plus-circle-fill'"></i>
            <span x-text="showForm ? 'Annuler' : 'Nouvelle réflexion'"></span>
        </button>
    </div>

    {{-- ── ADD ENTRY FORM ──────────────────────── --}}
    <div x-show="showForm" x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-cloak class="mb-7">
        <div class="bg-white rounded-3xl border-2 overflow-hidden shadow-xl"
             style="border-color:#E94E3C30;">
            <div class="h-1.5" style="background:linear-gradient(90deg,#E94E3C,#FFC857,#4DA3FF);"></div>
            <div class="p-8">
                <h2 class="font-extrabold text-gray-900 text-lg mb-6 flex items-center gap-2">
                    <i class="bi bi-pencil-square text-primary"></i> Nouvelle entrée dans le carnet
                </h2>

                <div class="grid md:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-2">Date de la séance</label>
                        <input type="date" value="2026-05-03"
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-sm focus:outline-none focus:border-primary transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-2">Activité / Carte utilisée</label>
                        <input type="text" placeholder="Ex : Cartes Socita — travail de groupe"
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-sm focus:outline-none focus:border-primary transition-all">
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-2">Dimension de la carte</label>
                        <select class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-sm focus:outline-none focus:border-primary text-gray-700">
                            <option>Cognitif & Créatif</option>
                            <option>Action & Conatif</option>
                            <option>Social</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-2">Mon ressenti</label>
                        <select class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-sm focus:outline-none focus:border-primary text-gray-700">
                            @foreach($feelings as $f)
                            <option>{{ $f }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-bold text-gray-600 mb-2">Compétences mobilisées</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($competences_options as $comp)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" class="rounded accent-primary">
                            <span class="text-xs font-medium text-gray-600 bg-gray-100 px-3 py-1 rounded-xl hover:bg-primary/10 transition-colors">{{ $comp }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-bold text-gray-600 mb-2">Ma réflexion sur cette séance</label>
                    <textarea rows="4" placeholder="Décrivez ce qui s'est passé, vos réactions, ce que vous avez observé chez les élèves…"
                              class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-sm focus:outline-none focus:border-primary resize-none transition-all leading-relaxed"
                              style="font-family:'Poppins',sans-serif;"></textarea>
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-bold text-gray-600 mb-2">Ce que j'ai appris ou retenu</label>
                    <textarea rows="2" placeholder="Quelle insight principale retenez-vous de cette expérience ?"
                              class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-sm focus:outline-none focus:border-primary resize-none transition-all"
                              style="font-family:'Poppins',sans-serif;"></textarea>
                </div>

                {{-- Auto-évaluation slider --}}
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <label class="text-xs font-bold text-gray-600">Auto-évaluation de ma pratique</label>
                        <span class="text-2xl font-extrabold" style="color:#E94E3C;" x-text="autoEval + '%'"></span>
                    </div>
                    <div class="relative">
                        <input type="range" min="0" max="100" x-model="autoEval"
                               class="w-full h-3 rounded-full appearance-none cursor-pointer"
                               style="background:linear-gradient(90deg,#E94E3C,#FFC857);">
                    </div>
                    <div class="flex justify-between text-xs text-gray-400 mt-2">
                        <span>À améliorer</span>
                        <span>En progression</span>
                        <span>Maîtrisé</span>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-600 mb-2">Prochaine étape / intention</label>
                    <input type="text" placeholder="Ce que je vais essayer lors de la prochaine séance…"
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 text-sm focus:outline-none focus:border-primary transition-all">
                </div>

                <div class="flex items-center justify-end gap-3">
                    <button @click="showForm = false"
                            class="px-6 py-2.5 rounded-xl border-2 border-gray-200 text-sm font-semibold text-gray-600 hover:border-gray-300 transition-colors">
                        Annuler
                    </button>
                    <button class="px-8 py-2.5 rounded-xl text-sm font-bold text-white hover:-translate-y-0.5 transition-all"
                            style="background:linear-gradient(135deg,#E94E3C,#FFC857);">
                        <i class="bi bi-floppy-fill mr-1"></i> Enregistrer la réflexion
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ── TIMELINE ──────────────────────────────── --}}
    <div class="relative pl-8">
        <div class="absolute left-3.5 top-4 bottom-4 w-0.5 bg-gray-100 rounded-full"></div>

        @foreach($entries as $i => $e)
        <div class="relative mb-8 last:mb-0">

            {{-- Timeline dot --}}
            <div class="absolute -left-8 top-5 w-5 h-5 rounded-full border-4 border-white shadow-md"
                 style="background:{{ $e['dim_color'] }};"></div>

            {{-- Entry card --}}
            <div class="bg-white rounded-3xl border-2 overflow-hidden hover:shadow-lg transition-all"
                 style="border-color:{{ $e['dim_color'] }}25;"
                 x-data="{ expanded: {{ $i===0 ? 'true':'false' }} }">

                {{-- Card header --}}
                <div class="p-6 cursor-pointer" @click="expanded = !expanded">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="text-3xl shrink-0">{{ $e['feeling'] }}</div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-bold px-2.5 py-0.5 rounded-full"
                                          style="color:{{ $e['dim_color'] }};background:{{ $e['dim_color'] }}18;">
                                        {{ $e['dimension'] }}
                                    </span>
                                    <span class="text-xs text-gray-400">{{ $e['day'] }} {{ $e['date'] }}</span>
                                </div>
                                <h3 class="font-bold text-gray-900">{{ $e['activity'] }}</h3>
                                <div class="flex flex-wrap gap-1.5 mt-2">
                                    @foreach($e['competences'] as $ci => $comp)
                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-lg"
                                          style="color:{{ $e['comp_colors'][$ci] }};background:{{ $e['comp_colors'][$ci] }}15;">
                                        {{ $comp }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 shrink-0">
                            {{-- Auto-eval badge --}}
                            <div class="text-center">
                                <div class="relative w-14 h-14">
                                    <svg class="w-full h-full -rotate-90" viewBox="0 0 40 40">
                                        <circle cx="20" cy="20" r="16" fill="none" stroke="#f1f5f9" stroke-width="4"/>
                                        <circle cx="20" cy="20" r="16" fill="none"
                                                stroke="{{ $e['dim_color'] }}" stroke-width="4"
                                                stroke-dasharray="100.5"
                                                stroke-dashoffset="{{ 100.5 - (100.5 * $e['auto_eval'] / 100) }}"
                                                stroke-linecap="round"/>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-xs font-extrabold text-gray-900">{{ $e['auto_eval'] }}%</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-400 mt-0.5">Auto-éval.</p>
                            </div>
                            <i class="bi transition-transform duration-300 text-gray-400"
                               :class="expanded ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                        </div>
                    </div>
                </div>

                {{-- Card body --}}
                <div x-show="expanded" x-collapse class="border-t border-gray-50">
                    <div class="p-6 grid md:grid-cols-3 gap-5">
                        <div class="md:col-span-2">
                            <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Ma réflexion</p>
                            <p class="text-sm text-gray-700 leading-relaxed mb-5">{{ $e['reflexion'] }}</p>

                            <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Ce que j'ai appris</p>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $e['what_learned'] }}</p>
                        </div>
                        <div>
                            <div class="p-4 rounded-2xl mb-4" style="background:{{ $e['dim_color'] }}10;border:1px solid {{ $e['dim_color'] }}20;">
                                <p class="text-xs font-bold mb-2" style="color:{{ $e['dim_color'] }};">
                                    <i class="bi bi-arrow-right-circle-fill mr-1"></i> Prochaine étape
                                </p>
                                <p class="text-sm text-gray-700 leading-relaxed">{{ $e['next_step'] }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button class="flex-1 py-2 rounded-xl text-xs font-semibold border-2 border-gray-200 text-gray-500 hover:border-primary hover:text-primary transition-all">
                                    <i class="bi bi-pencil-fill mr-1"></i> Modifier
                                </button>
                                <button class="w-9 h-9 rounded-xl bg-red-50 text-red-400 hover:bg-red-100 transition-colors flex items-center justify-center">
                                    <i class="bi bi-trash text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
