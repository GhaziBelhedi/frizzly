@extends('layouts.admin')
@section('title', 'Modifier le QCM')
@section('page-title', 'Modifier le QCM')
@section('page-sub', 'Modifier les questions et les reponses')

@push('head')
<style>
.qcard{background:#fff;border-radius:14px;border:2px solid #f1f5f9;padding:20px;transition:border-color .2s,box-shadow .2s;}
.qcard:focus-within{border-color:#8E6CFF;box-shadow:0 0 0 4px rgba(142,108,255,.08);}
.qnum{width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#8E6CFF,#4DA3FF);color:#fff;font-weight:700;font-size:.75rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.arow{display:flex;align-items:center;gap:10px;padding:8px 10px;border-radius:10px;background:#f8fafc;margin-bottom:6px;transition:background .15s;}
.arow:focus-within{background:#f0ecff;}
.atxt{flex:1;border:none;background:transparent;font-size:.875rem;font-family:'Inter',sans-serif;color:#0f172a;outline:none;padding:2px 4px;}
.atxt::placeholder{color:#94a3b8;}
.correct-radio{width:18px;height:18px;accent-color:#2ECC71;cursor:pointer;flex-shrink:0;}
.comp-pill{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:.7rem;font-weight:600;}
.step-dot{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.8125rem;flex-shrink:0;}
</style>
@endpush

@section('content')
@php
use App\Models\Quiz;
$competences = $competences ?? Quiz::COMPETENCES;

// Serialize existing questions for Alpine
$existingQuestions = $quiz->questions->map(function($q, $qi) {
    return [
        'uid'        => 1000 + $qi,
        'text'       => $q->text,
        'competence' => $q->competence,
        'points'     => (string)$q->points,
        'correct'    => $q->answers->search(fn($a) => $a->is_correct) ?? 0,
        'answers'    => $q->answers->values()->map(fn($a, $ai) => ['uid' => 2000 + $qi * 10 + $ai, 'text' => $a->text])->toArray(),
    ];
})->toArray();
@endphp

<form method="POST" action="{{ route('admin.quiz.update', $quiz->id) }}" id="quiz-form">
@csrf @method('PUT')

<div style="max-width:900px;margin:0 auto;" x-data="quizEditor({{ json_encode($existingQuestions) }})">

    {{-- HEADER --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;gap:12px;flex-wrap:wrap;">
        <a href="{{ route('admin.quiz.show', $quiz->id) }}" style="display:flex;align-items:center;gap:6px;font-size:.875rem;color:#64748b;text-decoration:none;">
            <i class="bi bi-arrow-left"></i> Retour au QCM
        </a>
        <div style="display:flex;gap:10px;">
            <button type="submit" name="status_submit" value="draft" class="btn btn-ghost">Sauvegarder brouillon</button>
            <button type="submit" name="status_submit" value="active" class="btn btn-purple"><i class="bi bi-send-fill"></i> Publier</button>
        </div>
    </div>

    {{-- INFOS --}}
    <div class="card" style="padding:24px;margin-bottom:20px;">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
            <div class="step-dot" style="background:linear-gradient(135deg,#8E6CFF,#4DA3FF);color:#fff;">1</div>
            <h2 style="font-weight:700;color:#0f172a;font-size:.9375rem;">Informations du QCM</h2>
        </div>
        <div style="display:flex;flex-direction:column;gap:14px;">
            <div><label class="field-label">Titre <span style="color:#E94E3C;">*</span></label>
                <input type="text" name="title" required value="{{ old('title', $quiz->title) }}" class="field field-purple"></div>
            <div><label class="field-label">Description</label>
                <textarea name="description" rows="2" class="field field-purple" style="resize:none;">{{ old('description', $quiz->description) }}</textarea></div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                <div>
                    <label class="field-label">Seuil de reussite (%)</label>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <input type="range" name="passing_percentage" min="10" max="100" step="5" value="{{ old('passing_percentage', $quiz->passing_percentage) }}"
                               style="flex:1;" oninput="document.getElementById('pass-val').textContent=this.value+'%'">
                        <span id="pass-val" style="width:44px;font-weight:700;color:#8E6CFF;font-size:.9375rem;text-align:right;">{{ $quiz->passing_percentage }}%</span>
                    </div>
                </div>
                <div><label class="field-label">Statut</label>
                    <select name="status" class="field" id="status-field">
                        <option value="draft"   {{ $quiz->status === 'draft'   ? 'selected' : '' }}>Brouillon</option>
                        <option value="active"  {{ $quiz->status === 'active'  ? 'selected' : '' }}>Actif</option>
                        <option value="archived"{{ $quiz->status === 'archived'? 'selected' : '' }}>Archive</option>
                    </select></div>
            </div>
        </div>
    </div>

    {{-- COMPETENCES --}}
    <div class="card" style="padding:20px;margin-bottom:20px;">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
            <div class="step-dot" style="background:linear-gradient(135deg,#2ECC71,#4DA3FF);color:#fff;">2</div>
            <h2 style="font-weight:700;color:#0f172a;font-size:.9375rem;">Competences couvertes</h2>
        </div>
        <div style="display:flex;flex-wrap:wrap;gap:8px;">
            @foreach($competences as $key => $comp)
            <div class="comp-pill" :style="coveredComps.includes('{{ $key }}') ? 'color:{{ $comp['color'] }};background:{{ $comp['bg'] }};' : 'color:#94a3b8;background:#f1f5f9;opacity:.7;'">
                <span style="width:7px;height:7px;border-radius:50%;background:{{ $comp['color'] }};display:inline-block;" x-show="coveredComps.includes('{{ $key }}')"></span>
                {{ $comp['label'] }}
            </div>
            @endforeach
        </div>
    </div>

    {{-- QUESTIONS --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div class="step-dot" style="background:linear-gradient(135deg,#E94E3C,#F97316);color:#fff;">3</div>
            <h2 style="font-weight:700;color:#0f172a;font-size:.9375rem;">Questions & Reponses</h2>
        </div>
        <span class="badge" style="color:#8E6CFF;background:rgba(142,108,255,.1);" x-text="questions.length + ' question(s)'"></span>
    </div>

    <div style="display:flex;flex-direction:column;gap:14px;margin-bottom:20px;">
        <template x-for="(q, qi) in questions" :key="q.uid">
            <div class="qcard">
                <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:14px;">
                    <div class="qnum" x-text="qi + 1"></div>
                    <div style="flex:1;display:flex;flex-direction:column;gap:10px;">
                        <div style="display:flex;gap:10px;flex-wrap:wrap;">
                            <input type="text" :name="'questions['+qi+'][text]'" x-model="q.text" required class="field field-purple" style="flex:1;min-width:200px;" placeholder="Texte de la question...">
                            <select :name="'questions['+qi+'][competence]'" x-model="q.competence" @change="updateCovered()" required class="field" style="width:auto;min-width:200px;">
                                <option value="">-- Competence --</option>
                                @foreach($competences as $key => $comp)
                                <option value="{{ $key }}">{{ $comp['label'] }}</option>
                                @endforeach
                            </select>
                            <select :name="'questions['+qi+'][points]'" x-model="q.points" class="field" style="width:auto;min-width:100px;">
                                <option value="1">1 point</option><option value="2">2 points</option><option value="3">3 points</option>
                            </select>
                        </div>
                        <div x-show="q.competence" style="display:flex;align-items:center;gap:6px;font-size:.75rem;">
                            <span style="color:#64748b;">Lie a :</span>
                            <template x-for="(comp, key) in competenceList" :key="key">
                                <span x-show="key === q.competence" class="comp-pill" :style="'color:'+comp.color+';background:'+comp.bg+';'" x-text="comp.label"></span>
                            </template>
                        </div>
                    </div>
                    <button type="button" @click="removeQuestion(qi)" x-show="questions.length > 1" class="btn btn-icon" style="background:rgba(239,68,68,.1);color:#EF4444;flex-shrink:0;">
                        <i class="bi bi-x-lg" style="font-size:.875rem;"></i>
                    </button>
                </div>
                <div style="padding-left:40px;">
                    <p style="font-size:.75rem;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px;">Reponses — <span style="color:#2ECC71;">marquer la correcte</span></p>
                    <template x-for="(a, ai) in q.answers" :key="a.uid">
                        <div class="arow">
                            <input type="radio" :name="'questions['+qi+'][correct]'" :value="ai" :checked="q.correct == ai" @change="q.correct = ai" class="correct-radio">
                            <input type="text" :name="'questions['+qi+'][answers]['+ai+'][text]'" x-model="a.text" required class="atxt" :placeholder="'Reponse '+(ai+1)">
                            <button type="button" @click="removeAnswer(qi,ai)" x-show="q.answers.length > 2" style="background:none;border:none;cursor:pointer;color:#cbd5e1;font-size:.875rem;" onmouseover="this.style.color='#EF4444'" onmouseout="this.style.color='#cbd5e1'">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </template>
                    <button type="button" @click="addAnswer(qi)" x-show="q.answers.length < 6" style="background:none;border:none;cursor:pointer;display:flex;align-items:center;gap:6px;font-size:.8125rem;font-weight:600;color:#8E6CFF;padding:6px 0;font-family:'Inter',sans-serif;">
                        <i class="bi bi-plus-circle-fill"></i> Ajouter une reponse
                    </button>
                    <input type="hidden" :name="'questions['+qi+'][correct]'" :value="q.correct">
                </div>
            </div>
        </template>
    </div>

    <button type="button" @click="addQuestion()" style="width:100%;padding:14px;border:2px dashed #e2e8f0;border-radius:14px;background:transparent;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;font-size:.875rem;font-weight:600;color:#64748b;font-family:'Inter',sans-serif;transition:all .15s;margin-bottom:24px;" onmouseover="this.style.borderColor='#8E6CFF';this.style.color='#8E6CFF';this.style.background='rgba(142,108,255,.04)'" onmouseout="this.style.borderColor='#e2e8f0';this.style.color='#64748b';this.style.background='transparent'">
        <i class="bi bi-plus-circle-fill" style="font-size:1rem;"></i> Ajouter une question
    </button>

    <div style="display:flex;align-items:center;justify-content:space-between;padding:18px 24px;background:#fff;border-radius:14px;border:1px solid #f1f5f9;">
        <span style="font-size:.8125rem;color:#64748b;" x-text="questions.length + ' question(s) — ' + coveredComps.length + ' competence(s)'"></span>
        <div style="display:flex;gap:10px;">
            <button type="submit" name="status_submit" value="draft" class="btn btn-ghost">Brouillon</button>
            <button type="submit" name="status_submit" value="active" class="btn btn-purple"><i class="bi bi-send-fill"></i> Publier</button>
        </div>
    </div>

</div>
</form>

<script>
document.getElementById('quiz-form').addEventListener('submit', function(e) {
    const btn = document.activeElement;
    if (btn && btn.name === 'status_submit') document.getElementById('status-field').value = btn.value;
});

function quizEditor(initialQuestions) {
    let uid = 9000;
    const competenceList = @json($competences);
    const makeAnswer = (text = '') => ({ uid: uid++, text });
    const makeQuestion = () => ({ uid: uid++, text:'', competence:'', points:'1', correct:0, answers:[makeAnswer(),makeAnswer(),makeAnswer(),makeAnswer()] });

    return {
        questions: initialQuestions.length ? initialQuestions : [makeQuestion()],
        coveredComps: [...new Set(initialQuestions.map(q => q.competence).filter(Boolean))],
        competenceList,
        addQuestion() { this.questions.push(makeQuestion()); },
        removeQuestion(qi) { if(this.questions.length > 1){ this.questions.splice(qi,1); this.updateCovered(); } },
        addAnswer(qi) { if(this.questions[qi].answers.length < 6) this.questions[qi].answers.push(makeAnswer()); },
        removeAnswer(qi,ai) { if(this.questions[qi].answers.length > 2){ this.questions[qi].answers.splice(ai,1); if(this.questions[qi].correct >= this.questions[qi].answers.length) this.questions[qi].correct = 0; } },
        updateCovered() { this.coveredComps = [...new Set(this.questions.map(q => q.competence).filter(Boolean))]; },
    };
}
</script>
@endsection
