@extends('layouts.admin')
@section('title', 'Utilisateurs')
@section('page-title', 'Utilisateurs')
@section('page-sub', 'Gestion des comptes utilisateurs')

@section('content')
@php
$dummyUsers = collect([
    (object)['id'=>1,'name'=>'Amira Bensalem', 'email'=>'amira@ecole.tn',   'phone'=>'+216 71 234 567','role'=>'user',   'status'=>'active',  'created_at'=>\Carbon\Carbon::now()->subDays(3)],
    (object)['id'=>2,'name'=>'Karim Trabelsi', 'email'=>'karim.t@gmail.com','phone'=>'+216 20 345 678','role'=>'teacher','status'=>'active',  'created_at'=>\Carbon\Carbon::now()->subDays(5)],
    (object)['id'=>3,'name'=>'Nadia Sfar',     'email'=>'nsfar@moe.tn',     'phone'=>'+216 71 890 123','role'=>'user',   'status'=>'inactive','created_at'=>\Carbon\Carbon::now()->subDays(8)],
    (object)['id'=>4,'name'=>'Sami Gharbi',    'email'=>'sami.g@gmail.com', 'phone'=>'+216 55 456 789','role'=>'admin',  'status'=>'active',  'created_at'=>\Carbon\Carbon::now()->subDays(12)],
    (object)['id'=>5,'name'=>'Leila Jouini',   'email'=>'leila.j@gmail.com','phone'=>'+216 22 567 890','role'=>'user',   'status'=>'active',  'created_at'=>\Carbon\Carbon::now()->subDays(14)],
    (object)['id'=>6,'name'=>'Hassan Boubaker','email'=>'h.boubaker@edu.tn','phone'=>'+216 71 678 901','role'=>'teacher','status'=>'active',  'created_at'=>\Carbon\Carbon::now()->subDays(20)],
    (object)['id'=>7,'name'=>'Rym Chaabane',   'email'=>'rym.c@gmail.com',  'phone'=>'+216 55 123 456','role'=>'user',   'status'=>'inactive','created_at'=>\Carbon\Carbon::now()->subDays(25)],
]);
$users = $users ?? $dummyUsers;
$stats = $stats ?? ['total'=>7,'active'=>5,'inactive'=>2,'admins'=>1];

$roleMap = [
    'admin'   => ['color'=>'#991b1b','bg'=>'#fee2e2','label'=>'Admin'],
    'teacher' => ['color'=>'#5b21b6','bg'=>'#ede9fe','label'=>'Enseignant'],
    'user'    => ['color'=>'#1e40af','bg'=>'#dbeafe','label'=>'Utilisateur'],
];
$avatarGrads = ['135deg,#4DA3FF,#8E6CFF','135deg,#2ECC71,#4DA3FF','135deg,#F97316,#FFC857','135deg,#E94E3C,#F97316','135deg,#8E6CFF,#EC4899','135deg,#0EA5E9,#4DA3FF'];
@endphp

<div x-data="{
    addM: false, editM: false, delM: false,
    sel: null,
    edit(u) { this.sel = u; this.editM = true; },
    del(u)  { this.sel = u; this.delM  = true; }
}">

{{-- STAT CARDS --}}
<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:14px;margin-bottom:20px;" id="users-stat-grid">
    @foreach([
        ['Total','total','bi-people-fill','#4DA3FF','rgba(77,163,255,0.1)','#4DA3FF'],
        ['Actifs','active','bi-person-check-fill','#166534','rgba(46,204,113,0.1)','#2ECC71'],
        ['Inactifs','inactive','bi-person-x-fill','#92400e','rgba(249,115,22,0.1)','#F97316'],
        ['Admins','admins','bi-shield-fill','#5b21b6','rgba(142,108,255,0.1)','#8E6CFF'],
    ] as $s)
    <div class="stat-card" style="display:flex;align-items:center;gap:14px;border-top:3px solid {{ $s[5] }};">
        <div style="width:40px;height:40px;border-radius:12px;background:{{ $s[4] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="bi {{ $s[2] }}" style="color:{{ $s[3] }};font-size:1rem;"></i>
        </div>
        <div>
            <p style="font-size:1.5rem;font-weight:800;color:#0f172a;line-height:1;">{{ $stats[$s[1]] }}</p>
            <p style="font-size:0.75rem;color:#64748b;font-weight:500;margin-top:2px;">{{ $s[0] }}</p>
        </div>
    </div>
    @endforeach
</div>
<style>@media(min-width:640px){#users-stat-grid{grid-template-columns:repeat(4,1fr);}}</style>

{{-- FILTER BAR --}}
<div class="card" style="padding:16px;margin-bottom:20px;">
    <form method="GET" style="display:flex;flex-wrap:wrap;align-items:center;gap:10px;">
        <div style="flex:1;min-width:220px;position:relative;">
            <i class="bi bi-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:0.875rem;"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un utilisateur..." class="field field-search">
        </div>
        <select name="role" class="field" style="width:auto;min-width:150px;">
            <option value="">Tous les roles</option>
            <option value="admin"   {{ request('role')=='admin'  ?'selected':'' }}>Admin</option>
            <option value="teacher" {{ request('role')=='teacher'?'selected':'' }}>Enseignant</option>
            <option value="user"    {{ request('role')=='user'   ?'selected':'' }}>Utilisateur</option>
        </select>
        <select name="status" class="field" style="width:auto;min-width:140px;">
            <option value="">Tous les statuts</option>
            <option value="active"   {{ request('status')=='active'  ?'selected':'' }}>Actif</option>
            <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Inactif</option>
        </select>
        <button type="submit" class="btn btn-primary"><i class="bi bi-funnel-fill"></i> Filtrer</button>
        <button type="button" @click="addM = true" class="btn btn-red" style="margin-left:auto;">
            <i class="bi bi-plus-lg"></i> Ajouter
        </button>
    </form>
</div>

{{-- TABLE --}}
<div class="card" style="overflow:hidden;">
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Statut</th>
                    <th>Inscrit le</th>
                    <th style="text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $idx => $u)
                @php $rc = $roleMap[$u->role] ?? ['color'=>'#374151','bg'=>'#f1f5f9','label'=>$u->role]; $grad = $avatarGrads[$idx % 6]; @endphp
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient({{ $grad }});display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.875rem;flex-shrink:0;">{{ strtoupper(substr($u->name,0,1)) }}</div>
                            <div>
                                <p style="font-weight:600;color:#0f172a;font-size:0.875rem;">{{ $u->name }}</p>
                                <p style="font-size:0.75rem;color:#94a3b8;">{{ $u->phone ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td style="color:#64748b;">{{ $u->email }}</td>
                    <td><span class="badge" style="color:{{ $rc['color'] }};background:{{ $rc['bg'] }};">{{ $rc['label'] }}</span></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:6px;">
                            <span style="width:7px;height:7px;border-radius:50%;background:{{ $u->status==='active'?'#2ECC71':'#94a3b8' }};display:inline-block;"></span>
                            <span style="font-size:0.875rem;color:{{ $u->status==='active'?'#166534':'#64748b' }};font-weight:500;">{{ $u->status==='active'?'Actif':'Inactif' }}</span>
                        </div>
                    </td>
                    <td style="color:#64748b;font-size:0.875rem;white-space:nowrap;">{{ $u->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div style="display:flex;align-items:center;justify-content:center;gap:6px;">
                            <form method="POST" action="{{ route('admin.users.toggle-status', $u->id) }}" style="display:inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-icon" title="{{ $u->status==='active'?'Desactiver':'Activer' }}"
                                        style="background:{{ $u->status==='active'?'rgba(249,115,22,0.1)':'rgba(46,204,113,0.1)' }};color:{{ $u->status==='active'?'#F97316':'#2ECC71' }};">
                                    <i class="bi {{ $u->status==='active'?'bi-toggle-on':'bi-toggle-off' }}" style="font-size:1rem;"></i>
                                </button>
                            </form>
                            <button @click="edit({{ json_encode(['id'=>$u->id,'name'=>$u->name,'email'=>$u->email,'role'=>$u->role,'status'=>$u->status,'phone'=>$u->phone??'']) }})"
                                    class="btn btn-icon" style="background:rgba(142,108,255,0.1);color:#8E6CFF;">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button @click="del({{ json_encode(['id'=>$u->id,'name'=>$u->name]) }})"
                                    class="btn btn-icon" style="background:rgba(239,68,68,0.1);color:#EF4444;">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if(isset($users) && $users instanceof \Illuminate\Pagination\LengthAwarePaginator && $users->hasPages())
    <div style="padding:14px 20px;border-top:1px solid #f1f5f9;">{{ $users->links() }}</div>
    @endif
</div>

{{-- ADD MODAL --}}
<div x-show="addM" x-cloak style="position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;padding:16px;" @keydown.escape.window="addM=false">
    <div class="modal-backdrop" @click="addM=false"></div>
    <div class="modal-box" style="width:100%;max-width:460px;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <div class="modal-header">
            <h3 style="font-weight:700;color:#0f172a;font-size:1rem;">Ajouter un utilisateur</h3>
            <button @click="addM=false" class="btn btn-icon btn-ghost"><i class="bi bi-x-lg" style="font-size:0.875rem;"></i></button>
        </div>
        <form method="POST" action="{{ route('admin.users.store') }}" style="display:flex;flex-direction:column;overflow:hidden;">
            @csrf
            <div class="modal-body" style="display:flex;flex-direction:column;gap:14px;">
                <div><label class="field-label">Nom complet</label><input type="text" name="name" required class="field" placeholder="Nom et prenom"></div>
                <div><label class="field-label">Email</label><input type="email" name="email" required class="field" placeholder="email@exemple.com"></div>
                <div><label class="field-label">Mot de passe</label><input type="password" name="password" required minlength="8" class="field" placeholder="Minimum 8 caracteres"></div>
                <div><label class="field-label">Telephone</label><input type="text" name="phone" class="field" placeholder="+216 XX XXX XXX"></div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div><label class="field-label">Role</label>
                        <select name="role" class="field"><option value="user">Utilisateur</option><option value="teacher">Enseignant</option><option value="admin">Admin</option></select></div>
                    <div><label class="field-label">Statut</label>
                        <select name="status" class="field"><option value="active">Actif</option><option value="inactive">Inactif</option></select></div>
                </div>
            </div>
            <div class="modal-footer" style="display:flex;gap:10px;">
                <button type="button" @click="addM=false" class="btn btn-ghost" style="flex:1;">Annuler</button>
                <button type="submit" class="btn btn-primary" style="flex:1;">Creer l utilisateur</button>
            </div>
        </form>
    </div>
</div>

{{-- EDIT MODAL --}}
<div x-show="editM" x-cloak style="position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;padding:16px;" @keydown.escape.window="editM=false">
    <div class="modal-backdrop" @click="editM=false"></div>
    <div class="modal-box" style="width:100%;max-width:460px;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <div class="modal-header">
            <h3 style="font-weight:700;color:#0f172a;font-size:1rem;">Modifier l utilisateur</h3>
            <button @click="editM=false" class="btn btn-icon btn-ghost"><i class="bi bi-x-lg" style="font-size:0.875rem;"></i></button>
        </div>
        <template x-if="sel">
            <form method="POST" :action="'/admin/users/' + sel.id" style="display:flex;flex-direction:column;overflow:hidden;">
                @csrf @method('PUT')
                <div class="modal-body" style="display:flex;flex-direction:column;gap:14px;">
                    <div><label class="field-label">Nom complet</label><input type="text" name="name" :value="sel.name" required class="field"></div>
                    <div><label class="field-label">Email</label><input type="email" name="email" :value="sel.email" required class="field"></div>
                    <div><label class="field-label">Nouveau mot de passe <span style="color:#94a3b8;font-weight:400;">(laisser vide)</span></label><input type="password" name="password" minlength="8" class="field" placeholder="Nouveau mot de passe"></div>
                    <div><label class="field-label">Telephone</label><input type="text" name="phone" :value="sel.phone" class="field"></div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div><label class="field-label">Role</label>
                            <select name="role" class="field">
                                <option value="user"    :selected="sel.role==='user'">Utilisateur</option>
                                <option value="teacher" :selected="sel.role==='teacher'">Enseignant</option>
                                <option value="admin"   :selected="sel.role==='admin'">Admin</option>
                            </select></div>
                        <div><label class="field-label">Statut</label>
                            <select name="status" class="field">
                                <option value="active"   :selected="sel.status==='active'">Actif</option>
                                <option value="inactive" :selected="sel.status==='inactive'">Inactif</option>
                            </select></div>
                    </div>
                </div>
                <div class="modal-footer" style="display:flex;gap:10px;">
                    <button type="button" @click="editM=false" class="btn btn-ghost" style="flex:1;">Annuler</button>
                    <button type="submit" class="btn btn-purple" style="flex:1;">Enregistrer</button>
                </div>
            </form>
        </template>
    </div>
</div>

{{-- DELETE MODAL --}}
<div x-show="delM" x-cloak style="position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;padding:16px;" @keydown.escape.window="delM=false">
    <div class="modal-backdrop" @click="delM=false"></div>
    <div class="modal-box" style="width:100%;max-width:380px;text-align:center;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <div class="modal-body" style="display:flex;flex-direction:column;align-items:center;gap:12px;padding:28px 24px;">
            <div style="width:60px;height:60px;border-radius:16px;background:#fee2e2;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-trash-fill" style="font-size:1.5rem;color:#EF4444;"></i>
            </div>
            <h3 style="font-weight:700;color:#0f172a;font-size:1rem;">Supprimer l utilisateur</h3>
            <p style="font-size:0.875rem;color:#64748b;line-height:1.5;">Vous etes sur le point de supprimer <strong x-text="sel ? sel.name : ''"></strong>. Cette action est irreversible.</p>
        </div>
        <template x-if="sel">
            <form method="POST" :action="'/admin/users/' + sel.id">
                @csrf @method('DELETE')
                <div class="modal-footer" style="display:flex;gap:10px;">
                    <button type="button" @click="delM=false" class="btn btn-ghost" style="flex:1;">Annuler</button>
                    <button type="submit" style="flex:1;padding:9px 18px;border-radius:10px;font-size:0.8125rem;font-weight:600;cursor:pointer;border:none;background:#EF4444;color:#fff;transition:background 0.15s;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#EF4444'">Supprimer</button>
                </div>
            </form>
        </template>
    </div>
</div>

</div>
@endsection
