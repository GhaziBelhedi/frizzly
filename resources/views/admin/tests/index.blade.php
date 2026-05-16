@extends('layouts.admin')
@section('title', 'Tests Recus')
@section('page-title', 'Tests Recus')
@section('page-sub', 'Resultats des evaluations soumis par les utilisateurs')

@section('content')
@php
$dummy = [
    ['id'=>1,'user'=>'Amira Bensalem',  'title'=>'Competences entrepreneuriales — Module 1','score'=>72,'pct'=>72,'status'=>'completed','date'=>'03/05/2026','competences'=>[['label'=>'Leadership','pct'=>80],['label'=>'Creativite','pct'=>65],['label'=>'Communication','pct'=>72],['label'=>'Gestion','pct'=>58]]],
    ['id'=>2,'user'=>'Karim Trabelsi',  'title'=>'Auto-evaluation Creativite & Innovation', 'score'=>68,'pct'=>68,'status'=>'completed','date'=>'02/05/2026','competences'=>[['label'=>'Innovation','pct'=>75],['label'=>'Creativite','pct'=>68],['label'=>'Pensee critique','pct'=>60],['label'=>'Adaptation','pct'=>72]]],
    ['id'=>3,'user'=>'Hana Drissi',     'title'=>'Test diagnostique — Posture professionnelle','score'=>45,'pct'=>45,'status'=>'completed','date'=>'01/05/2026','competences'=>[['label'=>'Autonomie','pct'=>40],['label'=>'Organisation','pct'=>52],['label'=>'Communication','pct'=>45],['label'=>'Leadership','pct'=>38]]],
    ['id'=>4,'user'=>'Sami Gharbi',     'title'=>'Competences entrepreneuriales — Module 2','score'=>88,'pct'=>88,'status'=>'completed','date'=>'30/04/2026','competences'=>[['label'=>'Vision','pct'=>90],['label'=>'Persuasion','pct'=>85],['label'=>'Resilience','pct'=>88],['label'=>'Strategie','pct'=>82]]],
    ['id'=>5,'user'=>'Sonia Khelil',    'title'=>'Leadership et Management d equipe',       'score'=>56,'pct'=>56,'status'=>'pending','date'=>'29/04/2026','competences'=>[['label'=>'Leadership','pct'=>60],['label'=>'Management','pct'=>55],['label'=>'Collaboration','pct'=>52],['label'=>'Delegation','pct'=>58]]],
    ['id'=>6,'user'=>'Mohamed Ferjani', 'title'=>'Communication interpersonnelle',          'score'=>91,'pct'=>91,'status'=>'completed','date'=>'28/04/2026','competences'=>[['label'=>'Ecoute active','pct'=>95],['label'=>'Expression','pct'=>88],['label'=>'Negociation','pct'=>90],['label'=>'Empathie','pct'=>92]]],
    ['id'=>7,'user'=>'Ines Ben Salah',  'title'=>'Gestion du stress et resilience',         'score'=>63,'pct'=>63,'status'=>'completed','date'=>'27/04/2026','competences'=>[['label'=>'Resilience','pct'=>70],['label'=>'Gestion emotions','pct'=>60],['label'=>'Flexibilite','pct'=>65],['label'=>'Bien-etre','pct'=>55]]],
    ['id'=>8,'user'=>'Tarek Haddad',    'title'=>'Intelligence emotionnelle',               'score'=>77,'pct'=>77,'status'=>'completed','date'=>'26/04/2026','competences'=>[['label'=>'Conscience soi','pct'=>80],['label'=>'Regulation','pct'=>75],['label'=>'Empathie','pct'=>78],['label'=>'Motivation','pct'=>76]]],
];
$tests = $tests ?? collect($dummy);
@endphp

<div x-data="{ modal: false, sel: null, openModal(t) { this.sel = t; this.modal = true; } }">

{{-- FILTERS --}}
<div class="card" style="padding:16px;margin-bottom:20px;">
    <form method="GET" style="display:flex;flex-wrap:wrap;gap:10px;align-items:center;">
        <div style="flex:1;min-width:220px;position:relative;">
            <i class="bi bi-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:0.875rem;"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par nom ou titre..."
                   class="field field-purple field-search" style="padding-left:36px;">
        </div>
        <select name="status" class="field" style="width:auto;min-width:160px;">
            <option value="">Tous les statuts</option>
            <option value="completed" {{ request('status')=='completed'?'selected':'' }}>Termine</option>
            <option value="pending"   {{ request('status')=='pending'  ?'selected':'' }}>En cours</option>
            <option value="failed"    {{ request('status')=='failed'   ?'selected':'' }}>Echoue</option>
        </select>
        <button type="submit" class="btn btn-purple"><i class="bi bi-funnel-fill"></i> Filtrer</button>
        @if(request('search') || request('status'))
        <a href="{{ route('admin.tests.index') }}" class="btn btn-ghost"><i class="bi bi-x"></i> Effacer</a>
        @endif
    </form>
</div>

{{-- TABLE --}}
<div class="card" style="overflow:hidden;">
    <div class="section-header">
        <span class="section-title">
            <span style="width:3px;height:16px;background:#8E6CFF;border-radius:2px;display:inline-block;"></span>
            {{ ($tests instanceof \Illuminate\Pagination\LengthAwarePaginator ? $tests->total() : count($tests)) }} resultats
        </span>
    </div>
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Titre du test</th>
                    <th style="text-align:center;">Score</th>
                    <th>Progression</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th style="text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tests as $t)
                @php
                $isArr = is_array($t);
                $name   = $isArr ? $t['user'] : (is_object($t->user ?? null) ? $t->user->name : ($t->user ?? 'Inconnu'));
                $title  = $isArr ? $t['title'] : ($t->test_title ?? $t->title ?? '');
                $score  = $isArr ? $t['score'] : $t->score;
                $pct    = $isArr ? $t['pct']   : ($t->percentage ?? $t->pct ?? 0);
                $date   = $isArr ? $t['date']   : (isset($t->created_at) && is_object($t->created_at) ? $t->created_at->format('d/m/Y') : ($t->created_at ?? ''));
                $status = $isArr ? $t['status'] : $t->status;
                $id     = $isArr ? $t['id']     : $t->id;
                
                $comps = [];
                if ($isArr) {
                    $comps = $t['competences'] ?? [];
                } else {
                    // Pour les modèles Eloquent, on transforme result_data ou competence_scores
                    $raw = $t->result_data ?? $t->competence_scores ?? [];
                    foreach($raw as $lbl => $val) {
                        $comps[] = ['label' => ucfirst(str_replace(['_', '-'], ' ', $lbl)), 'pct' => $val];
                    }
                }

                $sc = match($status) { 'completed'=>['#166534','#dcfce7','Termine'], 'pending'=>['#92400e','#fef3c7','En cours'], default=>['#991b1b','#fee2e2','Echoue'] };
                $scoreColor = $score>=75 ? '#166534' : ($score>=50 ? '#92400e' : '#991b1b');
                $scoreBg    = $score>=75 ? '#dcfce7' : ($score>=50 ? '#fef3c7' : '#fee2e2');
                $barColor   = $pct>=75 ? 'linear-gradient(90deg,#2ECC71,#4DA3FF)' : ($pct>=50 ? 'linear-gradient(90deg,#F97316,#FFC857)' : '#EF4444');

                $payload = json_encode(['title'=>$title,'user'=>$name,'score'=>$score,'pct'=>$pct,'date'=>$date,'status'=>$status,'competences'=>$comps]);
                @endphp
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:32px;height:32px;border-radius:9px;background:linear-gradient(135deg,#8E6CFF,#4DA3FF);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.75rem;flex-shrink:0;">{{ strtoupper(substr($name,0,1)) }}</div>
                            <span style="font-weight:600;color:#0f172a;font-size:0.875rem;">{{ $name }}</span>
                        </div>
                    </td>
                    <td style="max-width:260px;">
                        <p style="font-weight:500;color:#374151;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $title }}</p>
                    </td>
                    <td style="text-align:center;">
                        <span style="display:inline-flex;align-items:baseline;gap:1px;font-weight:800;font-size:1.125rem;color:{{ $scoreColor }};">
                            {{ $score }}<span style="font-size:0.75rem;font-weight:600;">%</span>
                        </span>
                    </td>
                    <td style="width:160px;">
                        <div class="progress-track" style="width:130px;">
                            <div class="progress-fill" style="width:{{ $pct }}%;background:{{ $barColor }};"></div>
                        </div>
                        <p style="font-size:0.7rem;color:#94a3b8;margin-top:4px;">{{ $pct }}% complete</p>
                    </td>
                    <td style="color:#64748b;font-size:0.875rem;white-space:nowrap;">{{ $date }}</td>
                    <td><span class="badge" style="color:{{ $sc[0] }};background:{{ $sc[1] }};">{{ $sc[2] }}</span></td>
                    <td style="text-align:center;">
                        <div style="display:flex;align-items:center;justify-content:center;gap:6px;">
                            <button @click="openModal({{ $payload }})" class="btn btn-icon" style="background:rgba(142,108,255,0.1);color:#8E6CFF;" title="Voir details">
                                <i class="bi bi-eye-fill"></i>
                            </button>
                            <form method="POST" action="{{ route('admin.tests.destroy', $id) }}" onsubmit="return confirm('Supprimer ce resultat ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-icon" style="background:rgba(239,68,68,0.1);color:#EF4444;" title="Supprimer">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($tests instanceof \Illuminate\Pagination\LengthAwarePaginator && $tests->hasPages())
    <div style="padding:14px 20px;border-top:1px solid #f1f5f9;">{{ $tests->links() }}</div>
    @endif
</div>

{{-- DETAIL MODAL --}}
<div x-show="modal" x-cloak style="position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;padding:16px;" @keydown.escape.window="modal=false">
    <div class="modal-backdrop" @click="modal=false"></div>
    <div class="modal-box" style="width:100%;max-width:520px;"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">

        <div class="modal-header">
            <div style="flex:1;min-width:0;">
                <h3 style="font-weight:700;color:#0f172a;font-size:1rem;" class="clamp-1" x-text="sel ? sel.title : ''"></h3>
                <p style="font-size:0.8125rem;color:#64748b;margin-top:3px;" x-text="sel ? 'Par ' + sel.user : ''"></p>
            </div>
            <button @click="modal=false" class="btn btn-icon btn-ghost" style="flex-shrink:0;">
                <i class="bi bi-x-lg" style="font-size:0.875rem;"></i>
            </button>
        </div>

        <div class="modal-body" style="padding:24px;">
            {{-- Score block --}}
            <div style="display:flex;align-items:center;gap:20px;margin-bottom:24px;padding:20px;border-radius:14px;background:linear-gradient(135deg,rgba(142,108,255,0.08),rgba(77,163,255,0.06));">
                <div style="width:80px;height:80px;border-radius:16px;background:linear-gradient(135deg,#8E6CFF,#4DA3FF);display:flex;flex-direction:column;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 8px 20px rgba(142,108,255,0.3);">
                    <p style="font-size:1.75rem;font-weight:800;color:#fff;line-height:1;" x-text="sel ? sel.score + '%' : ''"></p>
                    <p style="font-size:0.6875rem;color:rgba(255,255,255,0.7);">Score</p>
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:8px;">
                    <div style="display:flex;justify-content:space-between;font-size:0.875rem;">
                        <span style="color:#64748b;">Date</span>
                        <span style="font-weight:600;color:#0f172a;" x-text="sel ? sel.date : ''"></span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:0.875rem;align-items:center;">
                        <span style="color:#64748b;">Statut</span>
                        <span class="badge" style="color:#166534;background:#dcfce7;" x-text="sel ? (sel.status==='completed'?'Termine':(sel.status==='pending'?'En cours':'Echoue')) : ''"></span>
                    </div>
                    <div style="font-size:0.875rem;">
                        <div style="display:flex;justify-content:space-between;margin-bottom:5px;"><span style="color:#64748b;">Progression</span><span style="font-weight:700;color:#8E6CFF;" x-text="sel ? sel.pct + '%' : ''"></span></div>
                        <div class="progress-track"><div class="progress-fill" :style="'width:' + (sel ? sel.pct : 0) + '%;background:linear-gradient(90deg,#8E6CFF,#4DA3FF);'"></div></div>
                    </div>
                </div>
            </div>

            {{-- Competences --}}
            <h4 style="font-weight:700;color:#0f172a;font-size:0.8125rem;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:14px;">Competences evaluees</h4>
            <template x-if="sel && sel.competences && sel.competences.length">
                <div style="display:flex;flex-direction:column;gap:12px;">
                    <template x-for="c in sel.competences" :key="c.label">
                        <div>
                            <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                                <span style="font-size:0.875rem;font-weight:500;color:#374151;" x-text="c.label"></span>
                                <span style="font-size:0.875rem;font-weight:700;color:#8E6CFF;" x-text="c.pct + '%'"></span>
                            </div>
                            <div class="progress-track">
                                <div class="progress-fill" :style="'width:'+c.pct+'%;background:'+(c.pct>=75?'linear-gradient(90deg,#2ECC71,#4DA3FF)':(c.pct>=50?'linear-gradient(90deg,#F97316,#FFC857)':'#EF4444'))"></div>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
            <template x-if="!sel || !sel.competences || !sel.competences.length">
                <p style="font-size:0.875rem;color:#94a3b8;font-style:italic;">Aucun detail de competences disponible.</p>
            </template>
        </div>
    </div>
</div>

</div>
@endsection
