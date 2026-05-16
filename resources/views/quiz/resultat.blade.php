@extends('layouts.app')
@section('title', 'Resultats — ' . $quiz->title)

@push('head')
<style>
body { background: #f8fafc; }
.rec-card { padding:16px 18px; border-radius:12px; border-left:4px solid; }
.rec-low  { border-color:#EF4444; background:rgba(239,68,68,0.05); }
.rec-mid  { border-color:#F59E0B; background:rgba(245,158,11,0.05); }
.rec-high { border-color:#2ECC71; background:rgba(46,204,113,0.05); }
</style>
@endpush

@section('content')
@php
$competences = $competences ?? \App\Models\Quiz::COMPETENCES;
$scores      = $result->competence_scores ?? [];
$recs        = $result->recommendations   ?? [];
$passed      = $result->passed;
// Pre-compute for JS (avoids Quiz:: reference inside @json)
$jsLabels = array_map(fn($k) => \App\Models\Quiz::COMPETENCES[$k]['label'] ?? $k, array_keys($scores));
$jsColors = array_map(fn($k) => \App\Models\Quiz::COMPETENCES[$k]['color'] ?? '#8E6CFF', array_keys($scores));
$pct    = $result->percentage;

$mainColor = $pct >= 80 ? '#2ECC71' : ($pct >= 65 ? '#4DA3FF' : ($pct >= $quiz->passing_percentage ? '#F97316' : '#EF4444'));
$mainBg    = $pct >= 80 ? 'linear-gradient(135deg,#2ECC71,#4DA3FF)' : ($pct >= 65 ? 'linear-gradient(135deg,#4DA3FF,#6366F1)' : ($pct >= $quiz->passing_percentage ? 'linear-gradient(135deg,#F97316,#FFC857)' : 'linear-gradient(135deg,#EF4444,#F97316)'));
$levelLabel = $pct >= 80 ? 'Excellent' : ($pct >= 65 ? 'Bien' : ($pct >= $quiz->passing_percentage ? 'Acquis' : 'En progression'));
@endphp

<div style="max-width:760px;margin:0 auto;padding:24px 16px;">

    {{-- RESULT HERO --}}
    <div style="background:{{ $mainBg }};border-radius:20px;padding:36px 32px;color:#fff;text-align:center;margin-bottom:28px;position:relative;overflow:hidden;">
        <div style="position:absolute;inset:0;background:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><circle cx=%2280%22 cy=%2220%22 r=%2240%22 fill=%22rgba(255,255,255,0.06)%22/><circle cx=%2220%22 cy=%2270%22 r=%2260%22 fill=%22rgba(255,255,255,0.04)%22/></svg>');opacity:0.8;pointer-events:none;"></div>
        <div style="position:relative;">
            <p style="font-size:0.8rem;font-weight:600;opacity:0.85;text-transform:uppercase;letter-spacing:0.1em;margin-bottom:16px;">Resultats du QCM</p>
            <div style="font-size:5rem;font-weight:800;line-height:1;margin-bottom:8px;">{{ $pct }}%</div>
            <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.2);padding:6px 16px;border-radius:20px;font-weight:700;font-size:0.9375rem;margin-bottom:16px;">
                @if($passed)
                <i class="bi bi-check-circle-fill"></i> {{ $levelLabel }} — Test reussi
                @else
                <i class="bi bi-arrow-up-circle-fill"></i> {{ $levelLabel }} — Continuez vos efforts
                @endif
            </div>
            <p style="opacity:0.85;font-size:0.9rem;">{{ $result->score }} / {{ $result->total_points }} points &middot; Seuil : {{ $quiz->passing_percentage }}%</p>
            <p style="opacity:0.7;font-size:0.8125rem;margin-top:6px;">{{ $result->teacher_name }} &middot; {{ $quiz->title }}</p>
        </div>
    </div>

    {{-- COMPETENCES BREAKDOWN --}}
    <div style="background:#fff;border-radius:16px;border:1px solid #f1f5f9;padding:24px;margin-bottom:20px;">
        <h2 style="font-weight:700;color:#0f172a;font-size:0.9375rem;margin-bottom:18px;display:flex;align-items:center;gap:8px;">
            <i class="bi bi-bar-chart-fill" style="color:#8E6CFF;"></i>
            Analyse par competence
        </h2>

        @if(empty($scores))
        <p style="color:#94a3b8;font-style:italic;font-size:0.875rem;">Aucun detail disponible.</p>
        @else
        <div style="display:flex;flex-direction:column;gap:14px;">
            @foreach($scores as $comp => $pctComp)
            @php $cc = $competences[$comp] ?? ['label'=>$comp,'color'=>'#8E6CFF','bg'=>'#F0ECFF']; @endphp
            <div>
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span style="width:10px;height:10px;border-radius:50%;background:{{ $cc['color'] }};display:inline-block;"></span>
                        <span style="font-size:0.875rem;font-weight:600;color:#374151;">{{ $cc['label'] }}</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span style="font-size:1rem;font-weight:800;color:{{ $pctComp >= 75 ? '#2ECC71' : ($pctComp >= 50 ? '#F97316' : '#EF4444') }};">{{ $pctComp }}%</span>
                        @if($pctComp >= 75)
                        <span style="background:#dcfce7;color:#166534;padding:2px 8px;border-radius:12px;font-size:0.65rem;font-weight:600;">Maitrise</span>
                        @elseif($pctComp >= 50)
                        <span style="background:#fef3c7;color:#92400e;padding:2px 8px;border-radius:12px;font-size:0.65rem;font-weight:600;">En progres</span>
                        @else
                        <span style="background:#fee2e2;color:#991b1b;padding:2px 8px;border-radius:12px;font-size:0.65rem;font-weight:600;">A renforcer</span>
                        @endif
                    </div>
                </div>
                <div style="height:10px;background:#f1f5f9;border-radius:99px;overflow:hidden;">
                    <div style="height:100%;border-radius:99px;width:{{ $pctComp }}%;background:{{ $pctComp >= 75 ? 'linear-gradient(90deg,#2ECC71,#4DA3FF)' : ($pctComp >= 50 ? 'linear-gradient(90deg,#F97316,#FFC857)' : '#EF4444') }};transition:width 1s ease;"></div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- RADAR CHART --}}
    @if(!empty($scores))
    <div style="background:#fff;border-radius:16px;border:1px solid #f1f5f9;padding:24px;margin-bottom:20px;">
        <h2 style="font-weight:700;color:#0f172a;font-size:0.9375rem;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
            <i class="bi bi-radar" style="color:#4DA3FF;"></i> Profil de competences
        </h2>
        <canvas id="radarChart" style="max-height:320px;"></canvas>
    </div>
    @endif

    {{-- RECOMMENDATIONS --}}
    @if(!empty($recs))
    <div style="background:#fff;border-radius:16px;border:1px solid #f1f5f9;padding:24px;margin-bottom:24px;">
        <h2 style="font-weight:700;color:#0f172a;font-size:0.9375rem;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
            <i class="bi bi-lightbulb-fill" style="color:#F59E0B;"></i> Recommandations personnalisees
        </h2>
        <div style="display:flex;flex-direction:column;gap:10px;">
            @foreach($recs as $comp => $rec)
            @php
            $cc = $competences[$comp] ?? ['label'=>$comp,'color'=>'#64748b'];
            $cls = $rec['level'] === 'low' ? 'rec-low' : ($rec['level'] === 'mid' ? 'rec-mid' : 'rec-high');
            $ico = $rec['level'] === 'low' ? 'bi-arrow-up-circle-fill' : ($rec['level'] === 'mid' ? 'bi-arrow-up-right-circle-fill' : 'bi-check-circle-fill');
            $col = $rec['level'] === 'low' ? '#EF4444' : ($rec['level'] === 'mid' ? '#F59E0B' : '#2ECC71');
            @endphp
            <div class="rec-card {{ $cls }}">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
                    <i class="bi {{ $ico }}" style="color:{{ $col }};"></i>
                    <span style="font-weight:700;font-size:0.875rem;color:#0f172a;">{{ $cc['label'] }}</span>
                    <span style="font-size:0.7rem;font-weight:600;color:{{ $col }};background:{{ $rec['level']==='low'?'rgba(239,68,68,0.1)':($rec['level']==='mid'?'rgba(245,158,11,0.1)':'rgba(46,204,113,0.1)') }};padding:2px 8px;border-radius:12px;">
                        {{ $rec['level']==='low' ? 'A renforcer' : ($rec['level']==='mid' ? 'En progres' : 'Excellent') }}
                    </span>
                </div>
                <p style="font-size:0.875rem;color:#374151;line-height:1.6;">{{ $rec['message'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ACTIONS --}}
    <div style="display:flex;align-items:center;justify-content:center;gap:12px;flex-wrap:wrap;">
        <a href="{{ route('home') }}" class="btn btn-ghost">
            <i class="bi bi-house-fill"></i> Retour a l accueil
        </a>
        <button onclick="window.print()" class="btn" style="background:linear-gradient(135deg,#8E6CFF,#4DA3FF);color:#fff;">
            <i class="bi bi-printer-fill"></i> Imprimer les resultats
        </button>
    </div>

</div>

@endsection

@if(!empty($scores))
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const labels = @json(array_values($jsLabels));
    const data   = @json(array_values($scores));
    const colors = @json(array_values($jsColors));

    new Chart(document.getElementById('radarChart'), {
        type: 'radar',
        data: {
            labels,
            datasets: [{
                label: 'Vos scores (%)',
                data,
                backgroundColor: 'rgba(142,108,255,0.15)',
                borderColor: '#8E6CFF',
                borderWidth: 2.5,
                pointBackgroundColor: colors,
                pointRadius: 5,
                pointHoverRadius: 7,
            }]
        },
        options: {
            responsive: true,
            scales: {
                r: {
                    beginAtZero: true, max: 100,
                    ticks: { stepSize: 25, font: { size: 10 } },
                    grid: { color: '#f1f5f9' },
                    pointLabels: { font: { size: 11, weight: '600' }, color: '#374151' },
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed.r}%` }
                }
            },
            animation: { duration: 1000, easing: 'easeOutQuart' },
        }
    });
});
</script>
@endpush
@endif
