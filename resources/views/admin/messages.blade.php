@extends('layouts.admin')
@section('title', 'Messages')
@section('page-title', 'Messages')
@section('page-sub', 'Toutes les demandes reçues via le formulaire de contact')

@section('content')
@php
$messages = [
    ['id'=>1,'name'=>'Amira Bensalem',   'email'=>'amira@ecole.tn',     'phone'=>'+216 71 234 567','subject'=>'demo',        'subject_label'=>'Demande de démo',       'date'=>'03/05/2026 10:15','unread'=>true,
     'body'=>'Bonjour, je suis directrice dans une école primaire à Tunis. Je souhaiterais organiser une démonstration du Frizzly Kit pour mon équipe pédagogique d\'une quinzaine d\'enseignants. Pouvez-vous me contacter pour convenir d\'un rendez-vous ? Merci beaucoup.'],
    ['id'=>2,'name'=>'Karim Trabelsi',   'email'=>'karim.t@gmail.com',  'phone'=>'+216 20 345 678','subject'=>'programme',   'subject_label'=>'Question programme',    'date'=>'03/05/2026 07:40','unread'=>true,
     'body'=>'Bonjour, j\'ai découvert Frizzly sur les réseaux sociaux. J\'aimerais savoir si le programme certifiant est reconnu par le ministère de l\'éducation. Merci de m\'éclairer.'],
    ['id'=>3,'name'=>'Nadia Sfar',       'email'=>'nsfar@moe.tn',       'phone'=>'+216 71 890 123','subject'=>'partenariat', 'subject_label'=>'Partenariat',           'date'=>'02/05/2026 14:30','unread'=>true,
     'body'=>'Bonjour, je représente un établissement scolaire régional. Nous souhaitons intégrer le Frizzly Kit dans notre formation continue d\'enseignants. Seriez-vous intéressés par un partenariat institutionnel ? Cordialement.'],
    ['id'=>4,'name'=>'Sami Gharbi',      'email'=>'sami.g@gmail.com',   'phone'=>'+216 55 456 789','subject'=>'commande',    'subject_label'=>'Question commande',     'date'=>'02/05/2026 09:15','unread'=>false,
     'body'=>'Bonjour, j\'ai passé commande il y a 5 jours (référence #047) mais je n\'ai pas encore reçu de confirmation. Pourriez-vous vérifier ? Merci.'],
    ['id'=>5,'name'=>'Leila Jouini',     'email'=>'leila.j@gmail.com',  'phone'=>'+216 22 567 890','subject'=>'autre',       'subject_label'=>'Retour utilisateur',    'date'=>'01/05/2026 16:00','unread'=>false,
     'body'=>'Bonjour, j\'utilise le Frizzly Kit depuis deux mois maintenant. Je voulais vous faire part de mon retour très positif. Mes élèves sont beaucoup plus engagés depuis que j\'utilise les cartes Socita. Je recommanderai votre produit à mes collègues.'],
    ['id'=>6,'name'=>'Hassan Boubaker',  'email'=>'h.boubaker@edu.tn',  'phone'=>'+216 71 678 901','subject'=>'formation',   'subject_label'=>'Formation',             'date'=>'30/04/2026 11:45','unread'=>false,
     'body'=>'Bonjour Maram, j\'ai suivi l\'un de vos webinaires et je suis très intéressé par le programme de formation. Est-ce que les sessions sont disponibles à distance ou uniquement en présentiel ?'],
];
@endphp

<div class="flex gap-6 h-full" x-data="{ selected: 1, filter: 'tous' }">

    {{-- Left: list --}}
    <div class="w-96 shrink-0 bg-white rounded-2xl border border-gray-100 flex flex-col overflow-hidden">

        {{-- Filter tabs --}}
        <div class="flex items-center gap-1 p-3 border-b border-gray-50">
            @foreach(['tous'=>'Tous (6)', 'non_lus'=>'Non lus (3)', 'lus'=>'Lus'] as $key => $label)
            <button @click="filter = '{{ $key }}'"
                    :class="filter === '{{ $key }}' ? 'bg-primary text-white' : 'text-gray-500 hover:bg-gray-100'"
                    class="flex-1 py-1.5 rounded-lg text-xs font-bold transition-all">
                {{ $label }}
            </button>
            @endforeach
        </div>

        {{-- Messages list --}}
        <div class="overflow-y-auto flex-1 divide-y divide-gray-50">
            @foreach($messages as $m)
            <button @click="selected = {{ $m['id'] }}"
                    :class="selected === {{ $m['id'] }} ? 'bg-primary/5 border-l-4 border-primary' : 'border-l-4 border-transparent hover:bg-gray-50'"
                    class="w-full text-left px-4 py-3.5 transition-all">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-sm text-white shrink-0"
                         style="background:linear-gradient(135deg,#4DA3FF,#8E6CFF);">
                        {{ strtoupper(substr($m['name'],0,1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2">
                            <p class="font-semibold text-sm text-gray-900 truncate {{ $m['unread'] ? 'font-bold':'' }}">{{ $m['name'] }}</p>
                            @if($m['unread'])<span class="w-2 h-2 rounded-full bg-primary shrink-0"></span>@endif
                        </div>
                        <p class="text-xs text-gray-500 truncate">{{ $m['subject_label'] }}</p>
                        <p class="text-xs text-gray-400">{{ $m['date'] }}</p>
                    </div>
                </div>
            </button>
            @endforeach
        </div>
    </div>

    {{-- Right: detail --}}
    <div class="flex-1 min-w-0">
        @foreach($messages as $m)
        <div x-show="selected === {{ $m['id'] }}" x-cloak
             class="bg-white rounded-2xl border border-gray-100 h-full flex flex-col overflow-hidden">

            {{-- Header --}}
            <div class="px-8 py-6 border-b border-gray-50">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <span class="inline-block text-xs font-bold px-3 py-1 rounded-full mb-3"
                              style="background:#EBF4FF;color:#4DA3FF;">{{ $m['subject_label'] }}</span>
                        <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $m['name'] }}</h2>
                        <p class="text-sm text-gray-500">{{ $m['email'] }} · {{ $m['phone'] }}</p>
                    </div>
                    <span class="text-xs text-gray-400 shrink-0">{{ $m['date'] }}</span>
                </div>
            </div>

            {{-- Body --}}
            <div class="flex-1 px-8 py-6 overflow-y-auto">
                <div class="bg-gray-50 rounded-2xl p-6">
                    <p class="text-gray-700 leading-relaxed text-sm">{{ $m['body'] }}</p>
                </div>
            </div>

            {{-- Reply bar --}}
            <div class="px-8 py-5 border-t border-gray-50">
                <div class="flex items-end gap-3">
                    <textarea rows="2" placeholder="Répondre à {{ $m['name'] }}…"
                              class="flex-1 resize-none rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:border-blue focus:ring-2 focus:ring-blue/20 transition-all"></textarea>
                    <div class="flex flex-col gap-2">
                        <button class="px-5 py-2.5 rounded-xl text-sm font-bold text-white transition-all hover:-translate-y-0.5"
                                style="background:linear-gradient(135deg,#4DA3FF,#8E6CFF);">
                            <i class="bi bi-send-fill mr-1"></i> Envoyer
                        </button>
                        <button class="px-5 py-2 rounded-xl text-xs font-semibold text-gray-500 bg-gray-100 hover:bg-gray-200 transition-colors">
                            <i class="bi bi-trash mr-1"></i> Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
