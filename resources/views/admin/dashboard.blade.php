@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-sub', "Vue d'ensemble de la plateforme educative Frizzly")

@section('content')
@php
$stats ??= ['users'=>147,'tests'=>312,'pdfs'=>24,'products'=>4,'messages'=>28,'orders'=>52];
$unreadMessages ??= 3;
$pendingOrders  ??= 5;
$latestUsers    ??= collect([]);
$latestTests    ??= collect([]);
$recentMessages ??= collect([]);
$chartMonths    ??= collect(['Nov','Dec','Jan','Fev','Mar','Avr','Mai']);
$usersChart     ??= collect([12,18,15,22,28,34,41]);
$testsChart     ??= collect([8,14,11,19,24,30,36]);

$cards = [
    ['label'=>'Utilisateurs','value'=>$stats['users'],   'icon'=>'bi-people-fill',          'color'=>'#4DA3FF','bg'=>'rgba(77,163,255,0.10)', 'top'=>'#4DA3FF','route'=>'admin.users.index'],
    ['label'=>'Tests Recus', 'value'=>$stats['tests'],   'icon'=>'bi-clipboard2-check-fill', 'color'=>'#8E6CFF','bg'=>'rgba(142,108,255,0.10)','top'=>'#8E6CFF','route'=>'admin.tests.index'],
    ['label'=>'PDFs',        'value'=>$stats['pdfs'],    'icon'=>'bi-file-earmark-pdf-fill', 'color'=>'#E94E3C','bg'=>'rgba(233,78,60,0.10)',  'top'=>'#E94E3C','route'=>'admin.library.index'],
    ['label'=>'Produits',    'value'=>$stats['products'],'icon'=>'bi-box-seam-fill',         'color'=>'#F97316','bg'=>'rgba(249,115,22,0.10)', 'top'=>'#F97316','route'=>'admin.products.index'],
    ['label'=>'Messages',    'value'=>$stats['messages'],'icon'=>'bi-envelope-fill',         'color'=>'#2ECC71','bg'=>'rgba(46,204,113,0.10)', 'top'=>'#2ECC71','route'=>'admin.messages.index'],
    ['label'=>'Commandes',   'value'=>$stats['orders'],  'icon'=>'bi-bag-fill',              'color'=>'#EC4899','bg'=>'rgba(236,72,153,0.10)', 'top'=>'#EC4899','route'=>'admin.products.index'],
];

$dummyUsers = [
    ['name'=>'Amira Bensalem', 'email'=>'amira@ecole.tn',   'role'=>'user',   'status'=>'active'],
    ['name'=>'Karim Trabelsi', 'email'=>'karim@gmail.com',  'role'=>'teacher','status'=>'active'],
    ['name'=>'Nadia Sfar',     'email'=>'nsfar@moe.tn',     'role'=>'user',   'status'=>'inactive'],
    ['name'=>'Sami Gharbi',    'email'=>'sami@gmail.com',   'role'=>'admin',  'status'=>'active'],
    ['name'=>'Leila Jouini',   'email'=>'leila@gmail.com',  'role'=>'user',   'status'=>'active'],
];
$dummyTests = [
    ['user'=>'Amira Bensalem', 'title'=>'Competences entrepreneuriales - Module 1','score'=>72,'pct'=>72,'date'=>'03/05'],
    ['user'=>'Karim Trabelsi', 'title'=>'Auto-evaluation Creativite & Innovation',  'score'=>68,'pct'=>68,'date'=>'02/05'],
    ['user'=>'Hana Drissi',    'title'=>'Test diagnostique - Posture professionnelle','score'=>45,'pct'=>45,'date'=>'01/05'],
    ['user'=>'Sami Gharbi',    'title'=>'Competences entrepreneuriales - Module 2','score'=>88,'pct'=>88,'date'=>'30/04'],
    ['user'=>'Sonia Khelil',   'title'=>'Leadership & Management',               'score'=>56,'pct'=>56,'date'=>'29/04'],
];
$dummyMessages = [
    ['name'=>'Amira Bensalem','subject'=>'Demande de demonstration',  'time'=>'2h',     'unread'=>true],
    ['name'=>'Karim Trabelsi','subject'=>'Question sur le programme', 'time'=>'5h',     'unread'=>true],
    ['name'=>'Nadia Sfar',    'subject'=>'Partenariat etablissement', 'time'=>'hier',   'unread'=>true],
    ['name'=>'Sami Gharbi',   'subject'=>'Probleme de commande #047','time'=>'2 jours', 'unread'=>false],
    ['name'=>'Leila Jouini',  'subject'=>'Retour sur le Frizzly Kit','time'=>'3 jours', 'unread'=>false],
];

$avatarColors = ['#4DA3FF','#8E6CFF','#E94E3C','#2ECC71','#F97316','#EC4899','#0EA5E9'];
@endphp

{{-- ── STAT CARDS ── --}}
<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:14px;margin-bottom:24px;">
    {{-- Use JS for 6-col layout on wide screens --}}
    @foreach($cards as $i => $c)
    <a href="{{ route($c['route']) }}" class="stat-card" style="text-decoration:none;border-top:3px solid {{ $c['top'] }};">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;">
            <div>
                <p style="font-size:1.75rem;font-weight:800;color:#0f172a;line-height:1;">{{ $c['value'] }}</p>
                <p style="font-size:0.8rem;color:#64748b;font-weight:500;margin-top:4px;">{{ $c['label'] }}</p>
            </div>
            <div style="width:42px;height:42px;border-radius:12px;background:{{ $c['bg'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi {{ $c['icon'] }}" style="font-size:1.125rem;color:{{ $c['color'] }};"></i>
            </div>
        </div>
        <div style="margin-top:14px;height:2px;border-radius:99px;background:{{ $c['bg'] }};position:relative;overflow:hidden;">
            <div style="position:absolute;left:0;top:0;height:100%;width:60%;background:{{ $c['top'] }};border-radius:99px;opacity:0.5;"></div>
        </div>
    </a>
    @endforeach
</div>

<style>
@media (min-width:640px) { #stat-grid { grid-template-columns: repeat(3,1fr); } }
@media (min-width:1280px) { #stat-grid { grid-template-columns: repeat(6,1fr); } }
</style>
<script>document.querySelector('[style*="repeat(2,1fr)"]').id='stat-grid';</script>

{{-- ── CHARTS ── --}}
<div style="display:grid;grid-template-columns:1fr;gap:20px;margin-bottom:20px;">
    <div style="display:grid;gap:20px;" id="charts-grid">
        {{-- Line chart --}}
        <div class="card" style="padding:24px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                <div>
                    <h2 style="font-weight:700;color:#0f172a;font-size:0.9375rem;">Activite mensuelle</h2>
                    <p style="font-size:0.75rem;color:#94a3b8;margin-top:3px;">Nouveaux utilisateurs & tests sur 7 mois</p>
                </div>
                <div style="display:flex;align-items:center;gap:16px;font-size:0.75rem;color:#64748b;">
                    <span style="display:flex;align-items:center;gap:6px;"><span style="display:inline-block;width:20px;height:3px;background:#4DA3FF;border-radius:2px;"></span>Utilisateurs</span>
                    <span style="display:flex;align-items:center;gap:6px;"><span style="display:inline-block;width:20px;height:3px;background:#8E6CFF;border-radius:2px;"></span>Tests</span>
                </div>
            </div>
            <canvas id="activityChart" style="max-height:200px;"></canvas>
        </div>

        {{-- Doughnut --}}
        <div class="card" style="padding:24px;display:flex;flex-direction:column;">
            <h2 style="font-weight:700;color:#0f172a;font-size:0.9375rem;margin-bottom:4px;">Messages</h2>
            <p style="font-size:0.75rem;color:#94a3b8;margin-bottom:20px;">Repartition lus / non lus</p>
            <div style="display:flex;align-items:center;gap:24px;flex:1;">
                <div style="position:relative;width:120px;height:120px;flex-shrink:0;">
                    <canvas id="messagesChart"></canvas>
                    <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;pointer-events:none;">
                        <p style="font-size:1.5rem;font-weight:800;color:#0f172a;line-height:1;">{{ $stats['messages'] }}</p>
                        <p style="font-size:0.6875rem;color:#94a3b8;">total</p>
                    </div>
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:10px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <div style="display:flex;align-items:center;gap:8px;font-size:0.8125rem;color:#374151;">
                            <span style="width:10px;height:10px;border-radius:50%;background:#E94E3C;display:inline-block;"></span> Non lus
                        </div>
                        <span style="font-weight:700;font-size:0.875rem;color:#0f172a;">{{ $unreadMessages }}</span>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <div style="display:flex;align-items:center;gap:8px;font-size:0.8125rem;color:#374151;">
                            <span style="width:10px;height:10px;border-radius:50%;background:#2ECC71;display:inline-block;"></span> Lus
                        </div>
                        <span style="font-weight:700;font-size:0.875rem;color:#0f172a;">{{ max(0,$stats['messages']-$unreadMessages) }}</span>
                    </div>
                    <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-red" style="margin-top:4px;">
                        Voir les messages
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
@media (min-width:1024px) { #charts-grid { grid-template-columns: 2fr 1fr; } }
</style>

{{-- ── LATEST DATA ── --}}
<div style="display:grid;gap:20px;margin-bottom:20px;" id="data-grid">

    {{-- Latest users --}}
    <div class="card" style="overflow:hidden;">
        <div class="section-header">
            <span class="section-title">
                <span style="width:3px;height:16px;background:#4DA3FF;border-radius:2px;display:inline-block;"></span>
                Derniers utilisateurs
            </span>
            <a href="{{ route('admin.users.index') }}" style="font-size:0.75rem;font-weight:600;color:#4DA3FF;text-decoration:none;">Voir tout →</a>
        </div>
        <div>
            @forelse($latestUsers as $u)
            <div style="display:flex;align-items:center;gap:12px;padding:12px 20px;border-bottom:1px solid #f8fafc;transition:background 0.15s;" onmouseover="this.style.background='#fafbfc'" onmouseout="this.style.background=''">
                <div style="width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,#4DA3FF,#8E6CFF);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.8125rem;flex-shrink:0;">{{ strtoupper(substr($u->name,0,1)) }}</div>
                <div style="flex:1;min-width:0;">
                    <p style="font-weight:600;font-size:0.875rem;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $u->name }}</p>
                    <p style="font-size:0.75rem;color:#94a3b8;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $u->email }}</p>
                </div>
                <span class="badge" style="color:{{ $u->status==='active'?'#166534':'#6b7280' }};background:{{ $u->status==='active'?'#dcfce7':'#f1f5f9' }};">{{ $u->status==='active'?'Actif':'Inactif' }}</span>
            </div>
            @empty
            @foreach($dummyUsers as $idx => $u)
            @php $ac = $avatarColors[$idx % count($avatarColors)]; @endphp
            <div style="display:flex;align-items:center;gap:12px;padding:12px 20px;border-bottom:1px solid #f8fafc;transition:background 0.15s;" onmouseover="this.style.background='#fafbfc'" onmouseout="this.style.background=''">
                <div style="width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,{{ $ac }},#8E6CFF);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.8125rem;flex-shrink:0;">{{ strtoupper(substr($u['name'],0,1)) }}</div>
                <div style="flex:1;min-width:0;">
                    <p style="font-weight:600;font-size:0.875rem;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $u['name'] }}</p>
                    <p style="font-size:0.75rem;color:#94a3b8;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $u['email'] }}</p>
                </div>
                <span class="badge" style="color:{{ $u['status']==='active'?'#166534':'#6b7280' }};background:{{ $u['status']==='active'?'#dcfce7':'#f1f5f9' }};">{{ $u['status']==='active'?'Actif':'Inactif' }}</span>
            </div>
            @endforeach
            @endforelse
        </div>
    </div>

    {{-- Latest tests --}}
    <div class="card" style="overflow:hidden;">
        <div class="section-header">
            <span class="section-title">
                <span style="width:3px;height:16px;background:#8E6CFF;border-radius:2px;display:inline-block;"></span>
                Derniers tests
            </span>
            <a href="{{ route('admin.tests.index') }}" style="font-size:0.75rem;font-weight:600;color:#8E6CFF;text-decoration:none;">Voir tout →</a>
        </div>
        <div>
            @forelse($latestTests as $t)
            <div style="padding:12px 20px;border-bottom:1px solid #f8fafc;transition:background 0.15s;" onmouseover="this.style.background='#fafbfc'" onmouseout="this.style.background=''">
                <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:4px;">
                    <p style="font-size:0.8125rem;font-weight:600;color:#0f172a;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;flex:1;">{{ $t->test_title }}</p>
                    <span style="font-weight:800;font-size:0.9375rem;color:#8E6CFF;flex-shrink:0;">{{ $t->score }}%</span>
                </div>
                <p style="font-size:0.75rem;color:#94a3b8;margin-bottom:6px;">{{ $t->user?->name ?? '-' }} &middot; {{ $t->created_at->format('d/m') }}</p>
                <div class="progress-track"><div class="progress-fill" style="width:{{ $t->percentage }}%;background:linear-gradient(90deg,#8E6CFF,#4DA3FF);"></div></div>
            </div>
            @empty
            @foreach($dummyTests as $t)
            <div style="padding:12px 20px;border-bottom:1px solid #f8fafc;transition:background 0.15s;" onmouseover="this.style.background='#fafbfc'" onmouseout="this.style.background=''">
                <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:4px;">
                    <p style="font-size:0.8125rem;font-weight:600;color:#0f172a;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;flex:1;">{{ $t['title'] }}</p>
                    <span style="font-weight:800;font-size:0.9375rem;color:#8E6CFF;flex-shrink:0;">{{ $t['score'] }}%</span>
                </div>
                <p style="font-size:0.75rem;color:#94a3b8;margin-bottom:6px;">{{ $t['user'] }} &middot; {{ $t['date'] }}</p>
                <div class="progress-track"><div class="progress-fill" style="width:{{ $t['pct'] }}%;background:{{ $t['pct']>=75?'linear-gradient(90deg,#2ECC71,#4DA3FF)':($t['pct']>=50?'linear-gradient(90deg,#F97316,#FFC857)':'#EF4444') }};"></div></div>
            </div>
            @endforeach
            @endforelse
        </div>
    </div>
</div>
<style>@media (min-width:768px) { #data-grid { grid-template-columns: 1fr 1fr; } }</style>

{{-- ── RECENT MESSAGES ── --}}
<div class="card" style="overflow:hidden;">
    <div class="section-header">
        <span class="section-title">
            <span style="width:3px;height:16px;background:#2ECC71;border-radius:2px;display:inline-block;"></span>
            Messages recents
            @if($unreadMessages > 0)
            <span class="badge" style="color:#E94E3C;background:rgba(233,78,60,0.1);">{{ $unreadMessages }} non lus</span>
            @endif
        </span>
        <a href="{{ route('admin.messages.index') }}" style="font-size:0.75rem;font-weight:600;color:#2ECC71;text-decoration:none;">Voir tout →</a>
    </div>
    <div>
        @forelse($recentMessages as $m)
        <div style="display:flex;align-items:center;gap:12px;padding:13px 20px;border-bottom:1px solid #f8fafc;transition:background 0.15s;" onmouseover="this.style.background='#fafbfc'" onmouseout="this.style.background=''">
            <div style="width:36px;height:36px;border-radius:12px;background:linear-gradient(135deg,#4DA3FF,#8E6CFF);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.875rem;flex-shrink:0;">{{ strtoupper(substr($m->sender_name,0,1)) }}</div>
            <div style="flex:1;min-width:0;">
                <div style="display:flex;align-items:center;gap:6px;">
                    <p style="font-weight:600;font-size:0.875rem;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $m->sender_name }}</p>
                    @if($m->status==='unread')<span style="width:6px;height:6px;border-radius:50%;background:#E94E3C;flex-shrink:0;display:inline-block;"></span>@endif
                </div>
                <p style="font-size:0.75rem;color:#64748b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $m->subject }}</p>
            </div>
            <span style="font-size:0.75rem;color:#94a3b8;white-space:nowrap;flex-shrink:0;">{{ $m->created_at->diffForHumans(null,true) }}</span>
        </div>
        @empty
        @foreach($dummyMessages as $m)
        <div style="display:flex;align-items:center;gap:12px;padding:13px 20px;border-bottom:1px solid #f8fafc;transition:background 0.15s;" onmouseover="this.style.background='#fafbfc'" onmouseout="this.style.background=''">
            <div style="width:36px;height:36px;border-radius:12px;background:linear-gradient(135deg,#4DA3FF,#8E6CFF);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.875rem;flex-shrink:0;">{{ strtoupper(substr($m['name'],0,1)) }}</div>
            <div style="flex:1;min-width:0;">
                <div style="display:flex;align-items:center;gap:6px;">
                    <p style="font-weight:600;font-size:0.875rem;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $m['name'] }}</p>
                    @if($m['unread'])<span style="width:6px;height:6px;border-radius:50%;background:#E94E3C;flex-shrink:0;display:inline-block;"></span>@endif
                </div>
                <p style="font-size:0.75rem;color:#64748b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $m['subject'] }}</p>
            </div>
            <span style="font-size:0.75rem;color:#94a3b8;white-space:nowrap;flex-shrink:0;">{{ $m['time'] }}</span>
        </div>
        @endforeach
        @endforelse
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const months = @json($chartMonths);
    const uData  = @json($usersChart);
    const tData  = @json($testsChart);

    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.font.size   = 11;

    new Chart(document.getElementById('activityChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [
                { label:'Utilisateurs', data:uData, borderColor:'#4DA3FF', backgroundColor:'rgba(77,163,255,0.07)', borderWidth:2.5, pointBackgroundColor:'#4DA3FF', pointRadius:3, pointHoverRadius:5, tension:0.4, fill:true },
                { label:'Tests', data:tData, borderColor:'#8E6CFF', backgroundColor:'rgba(142,108,255,0.05)', borderWidth:2.5, pointBackgroundColor:'#8E6CFF', pointRadius:3, pointHoverRadius:5, tension:0.4, fill:true },
            ],
        },
        options: {
            responsive:true, maintainAspectRatio:true,
            plugins:{ legend:{ display:false }, tooltip:{ mode:'index', intersect:false, padding:10, backgroundColor:'#0f172a', titleColor:'#f8fafc', bodyColor:'#cbd5e1' } },
            scales:{
                x:{ grid:{ display:false }, ticks:{ color:'#94a3b8' } },
                y:{ grid:{ color:'#f1f5f9' }, ticks:{ color:'#94a3b8' }, beginAtZero:true },
            },
        },
    });

    const unread = {{ $unreadMessages ?? 3 }};
    const total  = {{ $stats['messages'] ?? 5 }};
    new Chart(document.getElementById('messagesChart'), {
        type:'doughnut',
        data:{ labels:['Non lus','Lus'], datasets:[{ data:[unread||1,Math.max(0,total-unread)], backgroundColor:['#E94E3C','#2ECC71'], borderWidth:0, hoverOffset:4 }] },
        options:{ responsive:true, cutout:'70%', plugins:{ legend:{ display:false }, tooltip:{ backgroundColor:'#0f172a', titleColor:'#f8fafc', bodyColor:'#cbd5e1', callbacks:{ label:ctx=>` ${ctx.label}: ${ctx.parsed}` } } } },
    });
});
</script>
@endpush
