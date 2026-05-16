@extends('layouts.admin')
@section('title', 'Commandes')
@section('page-title', 'Commandes')
@section('page-sub', 'Suivi des commandes du Frizzly Kit')

@section('content')
@php
$commandes = [
    ['id'=>'#052','name'=>'Rym Chaabane',     'email'=>'rym.c@gmail.com',    'phone'=>'+216 55 123 456','ville'=>'Tunis',  'qty'=>2,'total'=>'98TND', 'date'=>'03/05/2026','status'=>'En attente','sc'=>'#F97316','sb'=>'#FEF3EA'],
    ['id'=>'#051','name'=>'Mohamed Ferjani',  'email'=>'m.ferjani@edu.tn',   'phone'=>'+216 71 234 567','ville'=>'Sfax',   'qty'=>1,'total'=>'49TND', 'date'=>'02/05/2026','status'=>'Confirmée', 'sc'=>'#2ECC71','sb'=>'#E8FAF0'],
    ['id'=>'#050','name'=>'Hana Drissi',      'email'=>'h.drissi@gmail.com', 'phone'=>'+216 22 345 678','ville'=>'Sousse', 'qty'=>3,'total'=>'147TND','date'=>'01/05/2026','status'=>'Expédiée',  'sc'=>'#4DA3FF','sb'=>'#EBF4FF'],
    ['id'=>'#049','name'=>'Youssef Mrad',     'email'=>'y.mrad@moe.tn',      'phone'=>'+216 20 456 789','ville'=>'Tunis',  'qty'=>1,'total'=>'49TND', 'date'=>'30/04/2026','status'=>'Livrée',   'sc'=>'#8E6CFF','sb'=>'#F0ECFF'],
    ['id'=>'#048','name'=>'Sonia Khelil',     'email'=>'sonia.k@gmail.com',  'phone'=>'+216 55 567 890','ville'=>'Bizerte','qty'=>2,'total'=>'98TND', 'date'=>'29/04/2026','status'=>'Livrée',   'sc'=>'#8E6CFF','sb'=>'#F0ECFF'],
    ['id'=>'#047','name'=>'Sami Gharbi',      'email'=>'sami.g@gmail.com',   'phone'=>'+216 55 456 789','ville'=>'Tunis',  'qty'=>1,'total'=>'49TND', 'date'=>'28/04/2026','status'=>'En attente','sc'=>'#F97316','sb'=>'#FEF3EA'],
    ['id'=>'#046','name'=>'Ines Ben Salah',   'email'=>'ines.bs@edu.tn',     'phone'=>'+216 71 678 901','ville'=>'Nabeul', 'qty'=>4,'total'=>'196TND','date'=>'27/04/2026','status'=>'Expédiée',  'sc'=>'#4DA3FF','sb'=>'#EBF4FF'],
    ['id'=>'#045','name'=>'Tarek Haddad',     'email'=>'tarek.h@gmail.com',  'phone'=>'+216 22 789 012','ville'=>'Tunis',  'qty'=>1,'total'=>'49TND', 'date'=>'26/04/2026','status'=>'Livrée',   'sc'=>'#8E6CFF','sb'=>'#F0ECFF'],
];
$stats = [
    ['label'=>'Total commandes','value'=>'52',   'color'=>'#4DA3FF','bg'=>'#EBF4FF','icon'=>'bi-bag-fill'],
    ['label'=>'En attente',     'value'=>'5',    'color'=>'#F97316','bg'=>'#FEF3EA','icon'=>'bi-hourglass-split'],
    ['label'=>'En cours',       'value'=>'8',    'color'=>'#2ECC71','bg'=>'#E8FAF0','icon'=>'bi-truck'],
    ['label'=>'Chiffre d\'affaires','value'=>'2 548TND','color'=>'#8E6CFF','bg'=>'#F0ECFF','icon'=>'bi-cash-stack'],
];
@endphp

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @foreach($stats as $s)
    <div class="stat-card flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0" style="background:{{ $s['bg'] }};">
            <i class="bi {{ $s['icon'] }} text-xl" style="color:{{ $s['color'] }};"></i>
        </div>
        <div>
            <p class="text-2xl font-extrabold text-gray-900">{{ $s['value'] }}</p>
            <p class="text-xs text-gray-500 font-medium">{{ $s['label'] }}</p>
        </div>
    </div>
    @endforeach
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden" x-data="{ selected: null }">

    {{-- Toolbar --}}
    <div class="flex items-center justify-between gap-4 px-6 py-4 border-b border-gray-50">
        <h2 class="font-bold text-gray-900">Toutes les commandes</h2>
        <div class="flex items-center gap-3">
            <div class="relative">
                <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" placeholder="Rechercher…"
                       class="pl-9 pr-4 py-2 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue focus:ring-2 focus:ring-blue/20 transition-all w-48">
            </div>
            <select class="px-4 py-2 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-blue text-gray-600">
                <option>Tous les statuts</option>
                <option>En attente</option>
                <option>Confirmée</option>
                <option>Expédiée</option>
                <option>Livrée</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-50 bg-gray-50/50">
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">N°</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Client</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Contact</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Ville</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Qté</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Total</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Date</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Statut</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($commandes as $c)
                <tr class="hover:bg-gray-50/80 transition-colors">
                    <td class="px-6 py-4 font-bold text-gray-400 text-xs">{{ $c['id'] }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-xs text-white shrink-0"
                                 style="background:{{ $c['sc'] }};">{{ strtoupper(substr($c['name'],0,1)) }}</div>
                            <span class="font-semibold text-gray-900">{{ $c['name'] }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-gray-600 text-xs">{{ $c['email'] }}</p>
                        <p class="text-gray-400 text-xs">{{ $c['phone'] }}</p>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $c['ville'] }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $c['qty'] }}</td>
                    <td class="px-6 py-4 font-bold text-gray-900">{{ $c['total'] }}</td>
                    <td class="px-6 py-4 text-gray-400 text-xs">{{ $c['date'] }}</td>
                    <td class="px-6 py-4">
                        <span class="badge" style="color:{{ $c['sc'] }};background:{{ $c['sb'] }};">{{ $c['status'] }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <button @click="selected = selected === '{{ $c['id'] }}' ? null : '{{ $c['id'] }}'"
                                    class="text-xs font-semibold px-3 py-1.5 rounded-lg text-blue bg-blue/10 hover:bg-blue/20 transition-colors">
                                Détails
                            </button>
                            <select class="text-xs px-2 py-1.5 rounded-lg border border-gray-200 focus:outline-none focus:border-green cursor-pointer text-gray-600">
                                <option>Statut</option>
                                <option>En attente</option>
                                <option>Confirmée</option>
                                <option>Expédiée</option>
                                <option>Livrée</option>
                            </select>
                        </div>
                    </td>
                </tr>
                {{-- Detail row --}}
                @foreach($commandes as $cd)
                <tr x-show="selected === '{{ $cd['id'] }}'" x-cloak
                    class="bg-gray-50/50 border-b-2" style="border-color:{{ $cd['sc'] }}30;">
                    <td colspan="9" class="px-6 py-4">
                        <div class="flex items-center gap-8 text-sm">
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Produit commandé</p>
                                <p class="font-semibold text-gray-900">Frizzly Kit × {{ $cd['qty'] }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Adresse</p>
                                <p class="font-semibold text-gray-900">{{ $cd['ville'] }}, Tunisie</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Email</p>
                                <p class="font-semibold text-blue">{{ $cd['email'] }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Téléphone</p>
                                <p class="font-semibold text-gray-900">{{ $cd['phone'] }}</p>
                            </div>
                            <div class="ml-auto flex gap-2">
                                <button class="px-4 py-2 rounded-xl text-xs font-bold text-white"
                                        style="background:#2ECC71;">
                                    <i class="bi bi-check-circle-fill mr-1"></i> Confirmer
                                </button>
                                <button class="px-4 py-2 rounded-xl text-xs font-bold text-white"
                                        style="background:#4DA3FF;">
                                    <i class="bi bi-truck mr-1"></i> Marquer expédiée
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex items-center justify-between px-6 py-4 border-t border-gray-50">
        <p class="text-xs text-gray-400">Affichage de 8 sur 52 commandes</p>
        <div class="flex items-center gap-1">
            @foreach(range(1,4) as $p)
            <button class="w-8 h-8 rounded-lg text-xs font-bold {{ $p===1 ? 'bg-primary text-white' : 'text-gray-500 hover:bg-gray-100' }} transition-colors">
                {{ $p }}
            </button>
            @endforeach
            <button class="w-8 h-8 rounded-lg text-xs text-gray-400 hover:bg-gray-100">…</button>
        </div>
    </div>
</div>
@endsection
