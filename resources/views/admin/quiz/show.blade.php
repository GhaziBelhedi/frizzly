@extends('layouts.admin')
@section('title', $quiz->title)
@section('page-title', 'Detail QCM')
@section('page-sub', 'Questions, reponses et resultats des enseignants')

@section('content')
@php
$competences        = $competences        ?? \App\Models\Quiz::COMPETENCES;
$covered            = $covered            ?? [];
$averageScore       = $averageScore       ?? 0;
$competenceAverages = $competenceAverages ?? [];
// Pre-compute for JS
$jsAvgLabels = array_map(fn($k) => \App\Models\Quiz::COMPETENCES[$k]['label'] ?? $k, array_keys($competenceAverages));
$jsAvgColors = array_map(fn($k) => \App\Models\Quiz::COMPETENCES[$k]['color'] ?? '#8E6CFF', array_keys($competenceAverages));

// Dummy results for preview
$dummyResults = collect([
    (object)['id'=>1,'teacher_name'=>'Amira Bensalem', 'teacher_email'=>'amira@ecole.tn', 'score'=>14,'total_points'=>20,'percentage'=>70,'passed'=>true, 'completed_at'=>\Carbon\Carbon::now()->subDays(2), 'competence_scores'=>['leadership'=>75,'creativite'=>68,'autonomie'=>72,'pensee_critique'=>65,'adaptabilite'=>80]],
    (object)['id'=>2,'teacher_name'=>'Karim Trabelsi', 'teacher_email'=>'karim@gmail.com','score'=>16,'total_points'=>20,'percentage'=>80,'passed'=>true, 'completed_at'=>\Carbon\Carbon::now()->subDays(3), 'competence_scores'=>['leadership'=>85,'creativite'=>78,'autonomie'=>80,'pensee_critique'=>75,'adaptabilite'=>82]],
    (object)['id'=>3,'teacher_name'=>'Hana Drissi',    'teacher_email'=>'hana@moe.tn',   'score'=>9, 'total_points'=>20,'percentage'=>45,'passed'=>false,'completed_at'=>\Carbon\Carbon::now()->subDays(5), 'competence_scores'=>['leadership'=>40,'creativite'=>50,'autonomie'=>45,'pensee_critique'=>38,'adaptabilite'=>55]],
]);
$results = (isset($quiz->results) && $quiz->results->isNotEmpty()) ? $quiz->results : $dummyResults;

$statusMap = ['active'=>['#166534','#dcfce7','Actif'],'draft'=>['#92400e','#fef3c7','Brouillon'],'archived'=>['#374151','#f1f5f9','Archive']];
$sm = $statusMap[$quiz->status] ?? $statusMap['draft'];
@endphp

{{-- HEADER --}}
<div class="card" style="padding:24px;margin-bottom:20px;">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap;">
        <div style="flex:1;min-width:200px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                <span class="badge" style="color:{{ $sm[0] }};background:{{ $sm[1] }};">{{ $sm[2] }}</span>
                <span style="font-size:0.75rem;color:#94a3b8;">{{ $quiz->created_at->format('d/m/Y') }}</span>
            </div>
            <h1 style="font-weight:800;color:#0f172a;font-size:1.25rem;margin-bottom:6px;">{{ $quiz->title }}</h1>
            <p style="font-size:0.875rem;color:#64748b;line-height:1.6;margin-bottom:14px;">{{ $quiz->description ?: 'Aucune description.' }}</p>
            {{-- Covered competences --}}
            <div style="display:flex;flex-wrap:wrap;gap:6px;">
                @foreach(($covered ?: array_keys(array_slice($competences,0,5))) as $ck)
                @php $cc = $competences[$ck] ?? ['label'=>$ck,'color'=>'#64748b','bg'=>'#f1f5f9']; @endphp
                <span class="badge" style="color:{{ $cc['color'] }};background:{{ $cc['bg'] }};">{{ $cc['label'] }}</span>
                @endforeach
            </div>
        </div>
        {{-- Stats --}}
        <div style="display:flex;gap:20px;flex-wrap:wrap;flex-shrink:0;">
            @foreach([
                [$quiz->questions->count(),'Questions','bi-patch-question-fill','#8E6CFF','rgba(142,108,255,0.1)'],
                [$results->count(),'Reponses','bi-people-fill','#4DA3FF','rgba(77,163,255,0.1)'],
                [($averageScore ?: round($results->avg('percentage'),1)).'%','Score moy.','bi-bar-chart-fill','#2ECC71','rgba(46,204,113,0.1)'],
                [$quiz->passing_percentage.'%','Seuil','bi-trophy-fill','#F97316','rgba(249,115,22,0.1)'],
            ] as $s)
            <div style="text-align:center;">
                <div style="width:44px;height:44px;border-radius:12px;background:{{ $s[4] }};display:flex;align-items:center;justify-content:center;margin:0 auto 6px;">
                    <i class="bi {{ $s[2] }}" style="color:{{ $s[3] }};font-size:1.125rem;"></i>
                </div>
                <p style="font-size:1.25rem;font-weight:800;color:#0f172a;line-height:1;">{{ $s[0] }}</p>
                <p style="font-size:0.7rem;color:#94a3b8;">{{ $s[1] }}</p>
            </div>
            @endforeach
        </div>
        {{-- Actions --}}
        <div style="display:flex;gap:8px;flex-shrink:0;">
            <a href="{{ route('admin.quiz.edit', $quiz->id) }}" class="btn btn-purple">
                <i class="bi bi-pencil-fill"></i> Modifier
            </a>
            @if($quiz->status === 'active')
            <button onclick="copyLink('{{ route('quiz.repondre', $quiz->id) }}')" class="btn btn-ghost">
                <i class="bi bi-link-45deg"></i> Lien
            </button>
            @endif
        </div>
    </div>
</div>

{{-- TABS --}}
<div x-data="{ tab: 'questions' }">

    <div style="display:flex;gap:4px;background:#fff;border:1px solid #f1f5f9;border-radius:14px;padding:5px;width:fit-content;margin-bottom:20px;">
        <button @click="tab='questions'" class="btn btn-sm" :style="tab==='questions' ? 'background:linear-gradient(135deg,#8E6CFF,#4DA3FF);color:#fff;' : 'background:transparent;color:#64748b;'">
            <i class="bi bi-list-task"></i> Questions ({{ $quiz->questions->count() }})
        </button>
        <button @click="tab='results'" class="btn btn-sm" :style="tab==='results' ? 'background:linear-gradient(135deg,#2ECC71,#4DA3FF);color:#fff;' : 'background:transparent;color:#64748b;'">
            <i class="bi bi-bar-chart-fill"></i> Resultats ({{ $results->count() }})
        </button>
        <button @click="tab='competences'" class="btn btn-sm" :style="tab==='competences' ? 'background:linear-gradient(135deg,#E94E3C,#F97316);color:#fff;' : 'background:transparent;color:#64748b;'">
            <i class="bi bi-radar"></i> Analyse competences
        </button>
    </div>

    {{-- ══ QUESTIONS TAB ══ --}}
    <div x-show="tab==='questions'">
        <div style="display:flex;flex-direction:column;gap:12px;">
            @forelse($quiz->questions as $qi => $question)
            @php
            $qc = $competences[$question->competence] ?? ['label'=>$question->competence,'color'=>'#64748b','bg'=>'#f1f5f9'];
            @endphp
            <div class="card" style="padding:20px;">
                <div style="display:flex;align-items:flex-start;gap:14px;">
                    {{-- Number --}}
                    <div style="width:32px;height:32px;border-radius:10px;background:linear-gradient(135deg,#8E6CFF,#4DA3FF);color:#fff;font-weight:700;font-size:0.8125rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">{{ $qi + 1 }}</div>
                    <div style="flex:1;min-width:0;">
                        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:10px;margin-bottom:10px;flex-wrap:wrap;">
                            <p style="font-weight:600;color:#0f172a;font-size:0.9375rem;flex:1;">{{ $question->text }}</p>
                            <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
                                <span class="badge" style="color:{{ $qc['color'] }};background:{{ $qc['bg'] }};">{{ $qc['label'] }}</span>
                                <span class="badge" style="color:#64748b;background:#f1f5f9;">{{ $question->points }} pt{{ $question->points > 1 ? 's' : '' }}</span>
                            </div>
                        </div>
                        {{-- Answers --}}
                        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:8px;">
                            @foreach($question->answers as $answer)
                            <div style="display:flex;align-items:center;gap:8px;padding:9px 14px;border-radius:10px;background:{{ $answer->is_correct ? 'rgba(46,204,113,0.08)' : '#f8fafc' }};border:1.5px solid {{ $answer->is_correct ? '#2ECC71' : '#f1f5f9' }};">
                                <span style="width:18px;height:18px;border-radius:50%;background:{{ $answer->is_correct ? '#2ECC71' : '#e5e7eb' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    @if($answer->is_correct)
                                    <i class="bi bi-check-lg" style="color:#fff;font-size:0.7rem;"></i>
                                    @endif
                                </span>
                                <span style="font-size:0.8125rem;color:{{ $answer->is_correct ? '#166534' : '#374151' }};font-weight:{{ $answer->is_correct ? '600' : '400' }};">{{ $answer->text }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:40px;color:#94a3b8;">
                <i class="bi bi-patch-question" style="font-size:2.5rem;display:block;margin-bottom:8px;"></i>
                <p>Aucune question ajoutee.</p>
                <a href="{{ route('admin.quiz.edit', $quiz->id) }}" class="btn btn-purple" style="margin-top:12px;display:inline-flex;">Ajouter des questions</a>
            </div>
            @endforelse
        </div>
    </div>

    {{-- ══ RESULTS TAB ══ --}}
    <div x-show="tab==='results'">
        @if($results->isEmpty())
        <div class="card" style="padding:48px 24px;text-align:center;">
            <i class="bi bi-inbox" style="font-size:2.5rem;color:#e2e8f0;display:block;margin-bottom:10px;"></i>
            <p style="font-weight:600;color:#94a3b8;">Aucun resultat pour ce QCM</p>
            <p style="font-size:0.875rem;color:#cbd5e1;margin-top:4px;">Activez le QCM et partagez le lien aux enseignants</p>
        </div>
        @else
        <div class="card" style="overflow:hidden;">
            <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Enseignant</th>
                            <th style="text-align:center;">Score</th>
                            <th>Progression</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th style="text-align:center;">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                        @php
                        $name = is_object($result) ? ($result->teacher_name ?? ($result->user?->name ?? 'Inconnu')) : 'Inconnu';
                        $pct  = is_object($result) ? $result->percentage : 0;
                        $passed = is_object($result) ? $result->passed : false;
                        $scoreColor = $pct >= 80 ? '#2ECC71' : ($pct >= 65 ? '#4DA3FF' : ($pct >= ($quiz->passing_percentage) ? '#F97316' : '#EF4444'));
                        $dateStr = is_object($result) && $result->completed_at ? $result->completed_at->format('d/m/Y H:i') : '--';
                        @endphp
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <div style="width:32px;height:32px;border-radius:9px;background:linear-gradient(135deg,#8E6CFF,#4DA3FF);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.75rem;flex-shrink:0;">{{ strtoupper(substr($name,0,1)) }}</div>
                                    <div>
                                        <p style="font-weight:600;font-size:0.875rem;color:#0f172a;">{{ $name }}</p>
                                        <p style="font-size:0.75rem;color:#94a3b8;">{{ is_object($result) ? ($result->teacher_email ?? '') : '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align:center;">
                                <span style="font-weight:800;font-size:1.125rem;color:{{ $scoreColor }};">{{ $pct }}%</span>
                            </td>
                            <td style="width:160px;">
                                <div class="progress-track" style="width:130px;">
                                    <div class="progress-fill" style="width:{{ $pct }}%;background:{{ $scoreColor }};"></div>
                                </div>
                            </td>
                            <td>
                                <span class="badge" style="color:{{ $passed ? '#166534' : '#991b1b' }};background:{{ $passed ? '#dcfce7' : '#fee2e2' }};">
                                    {{ $passed ? 'Reussi' : 'Non reussi' }}
                                </span>
                            </td>
                            <td style="font-size:0.8125rem;color:#64748b;white-space:nowrap;">{{ $dateStr }}</td>
                            <td style="text-align:center;">
                                @if(is_object($result) && isset($result->competence_scores) && $result->competence_scores)
                                <button x-data @click="$dispatch('show-result-detail', {{ json_encode(['name'=>$name,'pct'=>$pct,'scores'=>$result->competence_scores,'passed'=>$passed]) }})"
                                        class="btn btn-icon" style="background:rgba(77,163,255,0.1);color:#4DA3FF;">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Result detail modal --}}
        <div x-data="{ open: false, data: null }"
             x-on:show-result-detail.window="data = $event.detail; open = true"
             x-show="open" x-cloak
             style="position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;padding:16px;"
             @keydown.escape.window="open=false">
            <div class="modal-backdrop" @click="open=false"></div>
            <div class="modal-box" style="width:100%;max-width:500px;"
                 x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                <div class="modal-header">
                    <h3 style="font-weight:700;color:#0f172a;font-size:1rem;" x-text="data ? 'Resultat de ' + data.name : ''"></h3>
                    <button @click="open=false" class="btn btn-icon btn-ghost"><i class="bi bi-x-lg" style="font-size:0.875rem;"></i></button>
                </div>
                <div class="modal-body" x-show="data">
                    <div style="display:flex;align-items:center;gap:20px;margin-bottom:20px;padding:16px;border-radius:12px;background:linear-gradient(135deg,rgba(142,108,255,0.06),rgba(77,163,255,0.04));">
                        <div style="width:72px;height:72px;border-radius:14px;background:linear-gradient(135deg,#8E6CFF,#4DA3FF);display:flex;flex-direction:column;align-items:center;justify-content:center;flex-shrink:0;">
                            <p style="font-size:1.5rem;font-weight:800;color:#fff;line-height:1;" x-text="data ? data.pct + '%' : ''"></p>
                            <p style="font-size:0.6875rem;color:rgba(255,255,255,0.7);">Score</p>
                        </div>
                        <div style="flex:1;">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;font-size:0.875rem;">
                                <span style="color:#64748b;">Statut</span>
                                <span class="badge" :style="data && data.passed ? 'color:#166534;background:#dcfce7;' : 'color:#991b1b;background:#fee2e2;'" x-text="data && data.passed ? 'Reussi' : 'Non reussi'"></span>
                            </div>
                            <div class="progress-track"><div class="progress-fill" :style="'width:' + (data ? data.pct : 0) + '%;background:linear-gradient(90deg,#8E6CFF,#4DA3FF);'"></div></div>
                        </div>
                    </div>
                    <h4 style="font-weight:700;color:#0f172a;font-size:0.8125rem;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:12px;">Par competence</h4>
                    <template x-if="data && data.scores">
                        <div style="display:flex;flex-direction:column;gap:10px;">
                            <template x-for="[comp, pct] in Object.entries(data.scores)" :key="comp">
                                <div>
                                    <div style="display:flex;justify-content:space-between;margin-bottom:5px;">
                                        <span style="font-size:0.875rem;font-weight:500;color:#374151;" x-text="comp.replace(/_/g,' ')"></span>
                                        <span style="font-size:0.875rem;font-weight:700;color:#8E6CFF;" x-text="pct + '%'"></span>
                                    </div>
                                    <div class="progress-track">
                                        <div class="progress-fill" :style="'width:'+pct+'%;background:'+(pct>=75?'linear-gradient(90deg,#2ECC71,#4DA3FF)':(pct>=50?'linear-gradient(90deg,#F97316,#FFC857)':'#EF4444'))"></div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- ══ COMPETENCE ANALYSIS TAB ══ --}}
    <div x-show="tab==='competences'">
        <div class="card" style="padding:24px;margin-bottom:16px;">
            <h3 style="font-weight:700;color:#0f172a;font-size:0.9375rem;margin-bottom:6px;">Moyennes par competence</h3>
            <p style="font-size:0.8125rem;color:#64748b;margin-bottom:20px;">Basees sur {{ $results->count() }} reponse(s)</p>
            @if(empty($competenceAverages))
            <p style="color:#94a3b8;font-size:0.875rem;font-style:italic;">Aucune donnee disponible. Publiez le QCM et attendez des reponses.</p>
            @else
            <div style="display:flex;flex-direction:column;gap:14px;">
                @foreach($competenceAverages as $comp => $avg)
                @php $cc = $competences[$comp] ?? ['label'=>$comp,'color'=>'#8E6CFF','bg'=>'#F0ECFF']; @endphp
                <div>
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <span style="width:10px;height:10px;border-radius:50%;background:{{ $cc['color'] }};display:inline-block;"></span>
                            <span style="font-size:0.875rem;font-weight:600;color:#374151;">{{ $cc['label'] }}</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <span style="font-size:0.875rem;font-weight:800;color:{{ $cc['color'] }};">{{ $avg }}%</span>
                            @if($avg < 40)
                            <span class="badge" style="color:#991b1b;background:#fee2e2;font-size:0.65rem;">A ameliorer</span>
                            @elseif($avg < 65)
                            <span class="badge" style="color:#92400e;background:#fef3c7;font-size:0.65rem;">En progres</span>
                            @else
                            <span class="badge" style="color:#166534;background:#dcfce7;font-size:0.65rem;">Acquis</span>
                            @endif
                        </div>
                    </div>
                    <div class="progress-track" style="height:8px;">
                        <div class="progress-fill" style="width:{{ $avg }}%;background:{{ $cc['color'] }};"></div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        {{-- Radar chart placeholder --}}
        <div class="card" style="padding:24px;">
            <h3 style="font-weight:700;color:#0f172a;font-size:0.9375rem;margin-bottom:16px;">Graphique radar</h3>
            <canvas id="radarChart" style="max-height:340px;"></canvas>
        </div>
    </div>

</div>

<script>
function copyLink(url) {
    navigator.clipboard.writeText(url).then(() => {
        alert('Lien copie : ' + url);
    });
}

@if(!empty($competenceAverages))
document.addEventListener('DOMContentLoaded', function() {
    const labels = @json(array_values($jsAvgLabels));
    const data   = @json(array_values($competenceAverages));
    const colors = @json(array_values($jsAvgColors));

    new Chart(document.getElementById('radarChart'), {
        type: 'radar',
        data: {
            labels,
            datasets: [{
                label: 'Score moyen (%)',
                data,
                backgroundColor: 'rgba(142,108,255,0.15)',
                borderColor: '#8E6CFF',
                borderWidth: 2.5,
                pointBackgroundColor: colors,
                pointRadius: 5,
            }]
        },
        options: {
            responsive: true,
            scales: {
                r: {
                    beginAtZero: true,
                    max: 100,
                    ticks: { stepSize: 20, font: { size: 10 } },
                    grid: { color: '#f1f5f9' },
                    pointLabels: { font: { size: 11, weight: '600' } },
                }
            },
            plugins: { legend: { display: false } },
        }
    });
});
@endif
</script>
@endsection
