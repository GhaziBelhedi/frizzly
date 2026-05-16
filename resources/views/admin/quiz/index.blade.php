@extends('layouts.admin')
@section('title', 'QCM')
@section('page-title', 'QCM')
@section('page-sub', 'Gestion des questionnaires a choix multiples pour les enseignants')

@section('content')
@php
use App\Models\Quiz;
$competences = Quiz::COMPETENCES;

// Dummy data when DB empty
$dummyQuizzes = collect([
    (object)['id'=>1,'title'=>'Test diagnostique — Posture professionnelle','description'=>'Evaluation initiale des 9 competences entrepreneuriales.','status'=>'active','questions_count'=>15,'results_count'=>67,'passing_percentage'=>60,'created_at'=>\Carbon\Carbon::now()->subDays(18),'avg'=>61],
    (object)['id'=>2,'title'=>'Module 1 — Autonomie & Confiance','description'=>'QCM de validation du premier module du programme certifiant.','status'=>'active','questions_count'=>10,'results_count'=>54,'passing_percentage'=>65,'created_at'=>\Carbon\Carbon::now()->subDays(12),'avg'=>74],
    (object)['id'=>3,'title'=>'Module 2 — Creativite & Innovation','description'=>'Questionnaire sur les competences cognitives et creatives.','status'=>'active','questions_count'=>8,'results_count'=>21,'passing_percentage'=>60,'created_at'=>\Carbon\Carbon::now()->subDays(9),'avg'=>68],
    (object)['id'=>4,'title'=>'Evaluation finale — 9 Competences','description'=>'QCM complet couvrant l ensemble des 9 competences de la plateforme.','status'=>'draft','questions_count'=>20,'results_count'=>0,'passing_percentage'=>70,'created_at'=>\Carbon\Carbon::now()->subDays(5),'avg'=>0],
    (object)['id'=>5,'title'=>'Auto-evaluation : Collaboration & Leadership','description'=>'Questionnaire sur le module 4 du programme.','status'=>'draft','questions_count'=>12,'results_count'=>0,'passing_percentage'=>60,'created_at'=>\Carbon\Carbon::now()->subDays(3),'avg'=>0],
]);

$quizzes = isset($quizzes) && $quizzes->isNotEmpty() ? $quizzes : $dummyQuizzes;
$stats = $stats ?? ['total'=>5,'active'=>3,'draft'=>2,'responses'=>142];

$statusMap = [
    'active'   => ['#166534','#dcfce7','Actif'],
    'draft'    => ['#92400e','#fef3c7','Brouillon'],
    'archived' => ['#374151','#f1f5f9','Archive'],
];

$compColors = array_map(fn($c) => $c['color'], $competences);
$compKeys   = array_keys($competences);
@endphp

{{-- STAT CARDS --}}
<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:14px;margin-bottom:24px;" id="qcm-stats">
    @foreach([
        ['Total QCM',   $stats['total'],    'bi-patch-question-fill','#8E6CFF','rgba(142,108,255,0.1)'],
        ['Actifs',      $stats['active'],   'bi-play-circle-fill',  '#2ECC71','rgba(46,204,113,0.1)'],
        ['Brouillons',  $stats['draft'],    'bi-pencil-fill',       '#F97316','rgba(249,115,22,0.1)'],
        ['Reponses',    $stats['responses'],'bi-people-fill',       '#4DA3FF','rgba(77,163,255,0.1)'],
    ] as $s)
    <div class="stat-card" style="display:flex;align-items:center;gap:14px;border-top:3px solid {{ $s[3] }};">
        <div style="width:42px;height:42px;border-radius:12px;background:{{ $s[4] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="bi {{ $s[2] }}" style="color:{{ $s[3] }};font-size:1.125rem;"></i>
        </div>
        <div>
            <p style="font-size:1.75rem;font-weight:800;color:#0f172a;line-height:1;">{{ $s[1] }}</p>
            <p style="font-size:0.8rem;color:#64748b;font-weight:500;margin-top:3px;">{{ $s[0] }}</p>
        </div>
    </div>
    @endforeach
</div>
<style>@media(min-width:640px){#qcm-stats{grid-template-columns:repeat(4,1fr);}}</style>

{{-- TOP BAR --}}
<div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px;flex-wrap:wrap;">
    <div style="display:flex;align-items:center;gap:10px;">
        <h2 style="font-weight:700;color:#0f172a;font-size:0.9375rem;">Tous les QCM</h2>
        <span class="badge" style="color:#8E6CFF;background:rgba(142,108,255,0.1);">{{ $quizzes->count() }}</span>
    </div>
    <a href="{{ route('admin.quiz.create') }}" class="btn btn-purple">
        <i class="bi bi-plus-lg"></i> Créer un QCM
    </a>
</div>

{{-- QUIZ CARDS --}}
@if($quizzes->isEmpty())
<div class="card" style="padding:60px 24px;text-align:center;">
    <i class="bi bi-patch-question" style="font-size:3rem;color:#e2e8f0;display:block;margin-bottom:12px;"></i>
    <p style="font-weight:600;color:#94a3b8;font-size:0.9375rem;">Aucun QCM pour le moment</p>
    <a href="{{ route('admin.quiz.create') }}" class="btn btn-purple" style="margin-top:16px;display:inline-flex;">
        <i class="bi bi-plus-lg"></i> Créer le premier QCM
    </a>
</div>
@else
<div style="display:flex;flex-direction:column;gap:14px;">
    @foreach($quizzes as $quiz)
    @php
    $sm = $statusMap[$quiz->status] ?? ['#374151','#f1f5f9',$quiz->status];
    $avg = isset($quiz->avg) ? $quiz->avg : (method_exists($quiz,'averageScore') ? $quiz->averageScore() : 0);
    $avgColor = $avg >= 75 ? '#2ECC71' : ($avg >= 55 ? '#F97316' : ($avg > 0 ? '#EF4444' : '#94a3b8'));

    // Random competences for demo (real data would come from questions)
    $demoComps = array_slice($compKeys, ($quiz->id * 2) % 9, 3);
    @endphp
    <div class="card" style="padding:0;overflow:hidden;transition:box-shadow 0.2s,transform 0.2s;" onmouseover="this.style.boxShadow='0 8px 24px rgba(0,0,0,0.07)';this.style.transform='translateY(-1px)'" onmouseout="this.style.boxShadow='';this.style.transform=''">
        <div style="display:flex;align-items:stretch;gap:0;">

            {{-- Accent bar --}}
            <div style="width:4px;background:linear-gradient(180deg,#8E6CFF,#4DA3FF);flex-shrink:0;"></div>

            {{-- Content --}}
            <div style="flex:1;padding:20px 22px;display:flex;align-items:center;gap:20px;flex-wrap:wrap;">

                {{-- Icon --}}
                <div style="width:48px;height:48px;border-radius:14px;background:rgba(142,108,255,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi bi-patch-question-fill" style="font-size:1.375rem;color:#8E6CFF;"></i>
                </div>

                {{-- Main info --}}
                <div style="flex:1;min-width:200px;">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:5px;flex-wrap:wrap;">
                        <h3 style="font-weight:700;color:#0f172a;font-size:0.9375rem;">{{ $quiz->title }}</h3>
                        <span class="badge" style="color:{{ $sm[0] }};background:{{ $sm[1] }};">{{ $sm[2] }}</span>
                    </div>
                    <p style="font-size:0.8125rem;color:#64748b;margin-bottom:10px;overflow:hidden;display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;">{{ $quiz->description }}</p>
                    {{-- Competence badges --}}
                    <div style="display:flex;flex-wrap:wrap;gap:5px;">
                        @foreach($demoComps as $ck)
                        @php $cc = $competences[$ck]; @endphp
                        <span class="badge" style="color:{{ $cc['color'] }};background:{{ $cc['bg'] }};font-size:0.65rem;">{{ $cc['label'] }}</span>
                        @endforeach
                        @if(count($demoComps) < count($compKeys))
                        <span class="badge" style="color:#64748b;background:#f1f5f9;font-size:0.65rem;">+{{ 9 - count($demoComps) }} autres</span>
                        @endif
                    </div>
                </div>

                {{-- Stats --}}
                <div style="display:flex;align-items:center;gap:24px;flex-shrink:0;flex-wrap:wrap;">
                    <div style="text-align:center;">
                        <p style="font-size:1.25rem;font-weight:800;color:#0f172a;">{{ $quiz->questions_count }}</p>
                        <p style="font-size:0.7rem;color:#94a3b8;font-weight:500;">Questions</p>
                    </div>
                    <div style="text-align:center;">
                        <p style="font-size:1.25rem;font-weight:800;color:#0f172a;">{{ $quiz->results_count }}</p>
                        <p style="font-size:0.7rem;color:#94a3b8;font-weight:500;">Réponses</p>
                    </div>
                    <div style="text-align:center;">
                        <p style="font-size:1.25rem;font-weight:800;color:{{ $avgColor }};">{{ $avg > 0 ? $avg.'%' : '—' }}</p>
                        <p style="font-size:0.7rem;color:#94a3b8;font-weight:500;">Moy. score</p>
                    </div>
                    <div style="text-align:center;">
                        <p style="font-size:1rem;font-weight:700;color:#64748b;">{{ $quiz->passing_percentage }}%</p>
                        <p style="font-size:0.7rem;color:#94a3b8;font-weight:500;">Seuil réussite</p>
                    </div>
                </div>

                {{-- Actions --}}
                <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
                    <a href="{{ route('admin.quiz.show', $quiz->id) }}" class="btn btn-icon" style="background:rgba(77,163,255,0.1);color:#4DA3FF;" title="Voir">
                        <i class="bi bi-eye-fill"></i>
                    </a>
                    <a href="{{ route('admin.quiz.edit', $quiz->id) }}" class="btn btn-icon" style="background:rgba(142,108,255,0.1);color:#8E6CFF;" title="Modifier">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                    {{-- Toggle status --}}
                    <form method="POST" action="{{ route('admin.quiz.toggle', $quiz->id) }}" style="display:inline;">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-icon" title="{{ $quiz->status === 'active' ? 'Mettre en brouillon' : 'Activer' }}"
                                style="background:{{ $quiz->status === 'active' ? 'rgba(249,115,22,0.1)' : 'rgba(46,204,113,0.1)' }};color:{{ $quiz->status === 'active' ? '#F97316' : '#2ECC71' }};">
                            <i class="bi {{ $quiz->status === 'active' ? 'bi-pause-circle-fill' : 'bi-play-circle-fill' }}"></i>
                        </button>
                    </form>
                    {{-- Copy link --}}
                    @if($quiz->status === 'active')
                    <button onclick="copyLink('{{ route('quiz.repondre', $quiz->id) }}')" class="btn btn-icon" style="background:rgba(99,102,241,0.1);color:#6366F1;" title="Copier le lien">
                        <i class="bi bi-link-45deg"></i>
                    </button>
                    @endif
                    {{-- Delete --}}
                    <form method="POST" action="{{ route('admin.quiz.destroy', $quiz->id) }}" onsubmit="return confirm('Supprimer ce QCM et tous ses resultats ?')" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-icon" style="background:rgba(239,68,68,0.1);color:#EF4444;" title="Supprimer">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- Toast for copy link --}}
<div id="copy-toast" style="position:fixed;bottom:24px;right:24px;background:#0f172a;color:#fff;padding:12px 20px;border-radius:12px;font-size:0.875rem;font-weight:600;display:none;align-items:center;gap:8px;box-shadow:0 8px 24px rgba(0,0,0,0.2);z-index:100;">
    <i class="bi bi-check-circle-fill" style="color:#2ECC71;"></i> Lien copie dans le presse-papier
</div>

<script>
function copyLink(url) {
    navigator.clipboard.writeText(url).then(() => {
        const t = document.getElementById('copy-toast');
        t.style.display = 'flex';
        setTimeout(() => { t.style.display = 'none'; }, 2500);
    });
}
</script>
@endsection
