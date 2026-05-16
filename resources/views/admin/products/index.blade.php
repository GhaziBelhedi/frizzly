@extends('layouts.admin')
@section('title', 'Produits et Commandes')
@section('page-title', 'Produits & Commandes')
@section('page-sub', 'Gestion du catalogue produits et suivi des commandes')

@section('content')
@php
$currentTab = request('tab','orders');

$dummyProducts = collect([
    (object)['id'=>1,'title'=>'Frizzly Kit Essentiel','description'=>'Le kit de base pour demarrer avec Frizzly en classe. Inclut cartes Socita, guide pedagogique et materiel de decouverte.','price'=>49.00,'stock'=>23,'category'=>'Kit pedagogique','active'=>true,'image'=>null],
    (object)['id'=>2,'title'=>'Frizzly Kit Premium',  'description'=>'Le kit complet avec tous les outils et la certification enseignant incluse dans le prix.','price'=>98.00,'stock'=>4,'category'=>'Kit pedagogique','active'=>true,'image'=>null],
    (object)['id'=>3,'title'=>'Cartes Socita - Pack 60','description'=>'60 cartes Socita supplementaires pour enrichir les activites en groupe classe.','price'=>29.00,'stock'=>0,'category'=>'Materiel','active'=>false,'image'=>null],
    (object)['id'=>4,'title'=>'Guide Pedagogique Premium','description'=>'Guide avance pour enseignants certifies avec 120 activites supplementaires et fiches.','price'=>35.00,'stock'=>15,'category'=>'Guide','active'=>true,'image'=>null],
]);

$orderStatuses = [
    'pending'   => ['#92400e','#fef3c7','En attente'],
    'confirmed' => ['#1e40af','#dbeafe','Confirmee'],
    'shipped'   => ['#5b21b6','#ede9fe','Expediee'],
    'delivered' => ['#166534','#dcfce7','Livree'],
    'cancelled' => ['#991b1b','#fee2e2','Annulee'],
];
$payStatuses = [
    'paid'     => ['#166534','#dcfce7','Paye'],
    'pending'  => ['#92400e','#fef3c7','En attente'],
    'failed'   => ['#991b1b','#fee2e2','Echoue'],
    'refunded' => ['#5b21b6','#ede9fe','Rembourse'],
];

$dummyOrders = collect([
    (object)['id'=>52,'customer_name'=>'Rym Chaabane',   'customer_email'=>'rym@gmail.com', 'quantity'=>2,'total'=>98, 'status'=>'pending',  'payment_status'=>'pending', 'created_at'=>\Carbon\Carbon::now()->subDays(1), 'product'=>(object)['title'=>'Frizzly Kit Essentiel']],
    (object)['id'=>51,'customer_name'=>'Mohamed Ferjani','customer_email'=>'m.f@edu.tn',    'quantity'=>1,'total'=>49, 'status'=>'confirmed','payment_status'=>'paid',    'created_at'=>\Carbon\Carbon::now()->subDays(2), 'product'=>(object)['title'=>'Frizzly Kit Essentiel']],
    (object)['id'=>50,'customer_name'=>'Hana Drissi',    'customer_email'=>'h.d@gmail.com', 'quantity'=>3,'total'=>147,'status'=>'shipped',  'payment_status'=>'paid',    'created_at'=>\Carbon\Carbon::now()->subDays(3), 'product'=>(object)['title'=>'Frizzly Kit Essentiel']],
    (object)['id'=>49,'customer_name'=>'Youssef Mrad',   'customer_email'=>'y.m@moe.tn',    'quantity'=>1,'total'=>98, 'status'=>'delivered','payment_status'=>'paid',    'created_at'=>\Carbon\Carbon::now()->subDays(5), 'product'=>(object)['title'=>'Frizzly Kit Premium']],
    (object)['id'=>48,'customer_name'=>'Sonia Khelil',   'customer_email'=>'s.k@gmail.com', 'quantity'=>2,'total'=>98, 'status'=>'delivered','payment_status'=>'paid',    'created_at'=>\Carbon\Carbon::now()->subDays(7), 'product'=>(object)['title'=>'Frizzly Kit Essentiel']],
    (object)['id'=>47,'customer_name'=>'Sami Gharbi',    'customer_email'=>'sami@gmail.com','quantity'=>1,'total'=>49, 'status'=>'pending',  'payment_status'=>'pending', 'created_at'=>\Carbon\Carbon::now()->subDays(8), 'product'=>(object)['title'=>'Frizzly Kit Essentiel']],
]);

$products = $products ?? $dummyProducts;
$orders   = $orders   ?? $dummyOrders;
$productStats = $productStats ?? ['total'=>4,'active'=>3,'lowStock'=>2];
$orderStats   = $orderStats   ?? ['total'=>52,'pending'=>5,'revenue'=>2548];
@endphp

<div x-data="{ tab: '{{ $currentTab }}', editM:false, delM:false, sel:null,
    editP(p){ this.sel=p; this.editM=true; },
    delP(p) { this.sel=p; this.delM=true; } }"
     x-init="tab = '{{ $currentTab }}'">

{{-- TABS --}}
<div style="display:flex;gap:4px;background:#fff;border:1px solid #f1f5f9;border-radius:14px;padding:5px;width:fit-content;margin-bottom:24px;">

    <button @click="tab='orders'" class="btn btn-sm" :style="tab==='orders' ? 'background:linear-gradient(135deg,#8E6CFF,#4DA3FF);color:#fff;box-shadow:0 4px 12px rgba(142,108,255,0.3);' : 'background:transparent;color:#64748b;'">
        <i class="bi bi-bag-fill"></i> Commandes
    </button>
</div>


{{-- ════ ORDERS ════ --}}
<div x-show="tab==='orders'">

    {{-- Stats --}}
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px;">
        @foreach([['Total commandes',$orderStats['total'],'#8E6CFF','rgba(142,108,255,0.1)','bi-bag-fill'],['En attente',$orderStats['pending'],'#F97316','rgba(249,115,22,0.1)','bi-hourglass-split'],['Chiffre d affaires',number_format($orderStats['revenue'],0,'.',',').' TND','#2ECC71','rgba(46,204,113,0.1)','bi-cash-stack']] as $s)
        <div class="stat-card" style="display:flex;align-items:center;gap:12px;border-top:3px solid {{ $s[2] }};">
            <div style="width:38px;height:38px;border-radius:10px;background:{{ $s[3] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi {{ $s[4] }}" style="color:{{ $s[2] }};"></i>
            </div>
            <div><p style="font-size:1.25rem;font-weight:800;color:#0f172a;line-height:1;">{{ $s[1] }}</p><p style="font-size:0.75rem;color:#64748b;margin-top:2px;">{{ $s[0] }}</p></div>
        </div>
        @endforeach
    </div>

    {{-- Orders filter --}}
    <div class="card" style="padding:14px;margin-bottom:16px;">
        <form method="GET" style="display:flex;flex-wrap:wrap;gap:10px;align-items:center;">
            <input type="hidden" name="tab" value="orders">
            <div style="flex:1;min-width:200px;position:relative;">
                <i class="bi bi-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:0.875rem;"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un client..." class="field field-purple field-search">
            </div>
            <select name="status" class="field" style="width:auto;min-width:150px;">
                <option value="">Tous les statuts</option>
                @foreach($orderStatuses as $k=>$os)<option value="{{ $k }}" {{ request('status')==$k?'selected':'' }}>{{ $os[2] }}</option>@endforeach
            </select>
            <button type="submit" class="btn btn-purple"><i class="bi bi-funnel-fill"></i> Filtrer</button>
        </form>
    </div>

    {{-- Orders table --}}
    <div class="card" style="overflow:hidden;">
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Client</th>
                        <th>Produit</th>
                        <th style="text-align:center;">Qte</th>
                        <th>Total</th>
                        <th>Statut</th>
                        <th>Paiement</th>
                        <th>Date</th>
                        <th style="text-align:center;">Modifier</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $o)
                    @php
                    $os = $orderStatuses[$o->status] ?? ['#374151','#f1f5f9',$o->status];
                    $ps = $payStatuses[$o->payment_status] ?? ['#374151','#f1f5f9',$o->payment_status];
                    @endphp
                    <tr>
                        <td style="font-weight:700;color:#94a3b8;">#{{ str_pad($o->id,3,'0',STR_PAD_LEFT) }}</td>
                        <td>
                            <p style="font-weight:600;color:#0f172a;font-size:0.875rem;">{{ $o->customer_name }}</p>
                            <p style="font-size:0.75rem;color:#94a3b8;">{{ $o->customer_email }}</p>
                        </td>
                        <td style="max-width:200px;">
                            <p style="color:#374151;font-size:0.875rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $o->product?->title ?? '—' }}</p>
                        </td>
                        <td style="text-align:center;font-weight:600;color:#374151;">{{ $o->quantity }}</td>
                        <td style="font-weight:700;color:#0f172a;white-space:nowrap;">{{ number_format($o->total,0,'.',',') }} TND</td>
                        <td><span class="badge" style="color:{{ $os[0] }};background:{{ $os[1] }};">{{ $os[2] }}</span></td>
                        <td><span class="badge" style="color:{{ $ps[0] }};background:{{ $ps[1] }};">{{ $ps[2] }}</span></td>
                        <td style="color:#64748b;font-size:0.8125rem;white-space:nowrap;">{{ $o->created_at->format('d/m/Y') }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.orders.update', $o->id) }}" style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;">
                                @csrf @method('PATCH')
                                <select name="status" class="field" style="width:auto;min-width:110px;font-size:0.8rem;padding:6px 10px;">
                                    @foreach($orderStatuses as $k=>$os2)
                                    <option value="{{ $k }}" {{ $o->status==$k?'selected':'' }}>{{ $os2[2] }}</option>
                                    @endforeach
                                </select>
                                <select name="payment_status" class="field" style="width:auto;min-width:110px;font-size:0.8rem;padding:6px 10px;">
                                    @foreach($payStatuses as $k=>$ps2)
                                    <option value="{{ $k }}" {{ $o->payment_status==$k?'selected':'' }}>{{ $ps2[2] }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-icon btn-purple" title="Enregistrer">
                                    <i class="bi bi-check2-all"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- EDIT PRODUCT MODAL --}}
<div x-show="editM" x-cloak style="position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;padding:16px;" @keydown.escape.window="editM=false">
    <div class="modal-backdrop" @click="editM=false"></div>
    <div class="modal-box" style="width:100%;max-width:460px;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <div class="modal-header">
            <h3 style="font-weight:700;color:#0f172a;font-size:1rem;">Modifier le produit</h3>
            <button @click="editM=false" class="btn btn-icon btn-ghost"><i class="bi bi-x-lg" style="font-size:0.875rem;"></i></button>
        </div>
        <template x-if="sel">
            <form method="POST" :action="'/admin/products/' + sel.id" enctype="multipart/form-data" style="display:flex;flex-direction:column;overflow:hidden;">
                @csrf @method('PUT')
                <div class="modal-body" style="display:flex;flex-direction:column;gap:14px;">
                    <div><label class="field-label">Titre</label><input type="text" name="title" :value="sel.title" required class="field"></div>
                    <div><label class="field-label">Description</label><textarea name="description" rows="3" class="field" style="resize:none;" x-text="sel.description"></textarea></div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div><label class="field-label">Prix (TND)</label><input type="number" name="price" :value="sel.price" required min="0" step="0.01" class="field"></div>
                        <div><label class="field-label">Stock</label><input type="number" name="stock" :value="sel.stock" required min="0" class="field"></div>
                    </div>
                    <div><label class="field-label">Categorie</label><input type="text" name="category" :value="sel.category" required class="field"></div>
                    <label style="display:flex;align-items:center;gap:8px;font-size:0.875rem;color:#374151;cursor:pointer;">
                        <input type="checkbox" name="active" value="1" :checked="sel.active" style="width:16px;height:16px;"> Produit actif
                    </label>
                </div>
                <div class="modal-footer" style="display:flex;gap:10px;">
                    <button type="button" @click="editM=false" class="btn btn-ghost" style="flex:1;">Annuler</button>
                    <button type="submit" class="btn btn-purple" style="flex:1;">Enregistrer</button>
                </div>
            </form>
        </template>
    </div>
</div>

{{-- DELETE PRODUCT MODAL --}}
<div x-show="delM" x-cloak style="position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;padding:16px;" @keydown.escape.window="delM=false">
    <div class="modal-backdrop" @click="delM=false"></div>
    <div class="modal-box" style="width:100%;max-width:360px;text-align:center;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <div class="modal-body" style="display:flex;flex-direction:column;align-items:center;gap:12px;padding:28px 24px;">
            <div style="width:60px;height:60px;border-radius:16px;background:#fee2e2;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-trash-fill" style="font-size:1.5rem;color:#EF4444;"></i>
            </div>
            <h3 style="font-weight:700;color:#0f172a;font-size:1rem;">Supprimer le produit</h3>
            <p style="font-size:0.875rem;color:#64748b;line-height:1.5;" x-text="sel ? 'Supprimer &quot;' + sel.title + '&quot; ? Cette action est irreversible.' : ''"></p>
        </div>
        <template x-if="sel">
            <form method="POST" :action="'/admin/products/' + sel.id">
                @csrf @method('DELETE')
                <div class="modal-footer" style="display:flex;gap:10px;">
                    <button type="button" @click="delM=false" class="btn btn-ghost" style="flex:1;">Annuler</button>
                    <button type="submit" style="flex:1;padding:9px 18px;border-radius:10px;font-size:0.8125rem;font-weight:600;cursor:pointer;border:none;background:#EF4444;color:#fff;">Supprimer</button>
                </div>
            </form>
        </template>
    </div>
</div>

</div>
@endsection
