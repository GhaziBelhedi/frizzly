@extends('layouts.admin')
@section('title', 'Creer un QCM')
@section('page-title', 'Creer un QCM')
@section('page-sub', 'Construisez un questionnaire lie aux 9 competences de la plateforme')

@push('head')
<style>
.qcard { background:#fff; border-radius:14px; border:2px solid #f1f5f9; padding:20px; transition:border-color 0.2s,box-shadow 0.2s; }
.qcard:focus-within { border-color:#8E6CFF; box-shadow:0 0 0 4px rgba(142,108,255,0.08); }
.qnum { width:28px; height:28px; border-radius:8px; background:linear-gradient(135deg,#8E6CFF,#4DA3FF); color:#fff; font-weight:700; font-size:0.75rem; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.arow { display:flex; align-items:center; gap:10px; padding:8px 10px; border-radius:10px; background:#f8fafc; margin-bottom:6px; transition:background 0.15s; }
.arow:focus-within { background:#f0ecff; }
.atxt { flex:1; border:none; background:transparent; font-size:0.875rem; font-family:'Inter',sans-serif; color:#0f172a; outline:none; padding:2px 4px; }
.atxt::placeholder { color:#94a3b8; }
.correct-radio { width:18px; height:18px; accent-color:#2ECC71; cursor:pointer; flex-shrink:0; }
.comp-pill { display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:20px; font-size:0.7rem; font-weight:600; }
.drag-btn { cursor:grab; color:#cbd5e1; font-size:1rem; line-height:1; padding:2px; }
.step-dot { width:28px; height:28px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.8125rem; flex-shrink:0; }
</style>
@endpush

@section('content')
@php
use App\Models\Quiz;
$competences = $competences ?? Quiz::COMPETENCES;
@endphp

<form method="POST" action="{{ route('admin.quiz.store') }}" id="quiz-form">
@csrf

<div style="max-width:900px;margin:0 auto;" x-data="quizBuilder()">

    {{-- HEADER BAR --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;gap:12px;flex-wrap:wrap;">
        <a href="{{ route('admin.quiz.index') }}" style="display:flex;align-items:center;gap:6px;font-size:0.875rem;color:#64748b;text-decoration:none;">
            <i class="bi bi-arrow-left"></i> Retour aux QCM
        </a>
        <div style="display:flex;align-items:center;gap:10px;">
            <button type="submit" name="status_submit" value="draft" class="btn btn-ghost">
                <i class="bi bi-cloud-arrow-up"></i> Sauvegarder brouillon
            </button>
            <button type="submit" name="status_submit" value="active" class="btn btn-purple">
                <i class="bi bi-send-fill"></i> Publier le QCM
            </button>
        </div>
    </div>

    {{-- ═══ SECTION 1 : INFOS QCM ═══ --}}
    <div class="card" style="padding:24px;margin-bottom:20px;">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
            <div class="step-dot" style="background:linear-gradient(135deg,#8E6CFF,#4DA3FF);color:#fff;">1</div>
            <div>
                <h2 style="font-weight:700;color:#0f172a;font-size:0.9375rem;">Informations du QCM</h2>
                <p style="font-size:0.8rem;color:#64748b;margin-top:2px;">Titre, description et parametres</p>
            </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:14px;">
            <div>
                <label class="field-label">Titre du QCM <span style="color:#E94E3C;">*</span></label>
                <input type="text" name="title" required class="field field-purple" placeholder="Ex: Test diagnostique — Posture professionnelle">
            </div>
            <div>
                <label class="field-label">Description</label>
                <textarea name="description" rows="2" class="field field-purple" style="resize:none;" placeholder="Objectif de ce questionnaire..."></textarea>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                <div>
                    <label class="field-label">Seuil de reussite (%) <span style="color:#E94E3C;">*</span></label>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <input type="range" name="passing_percentage" id="pass-range" min="10" max="100" step="5" value="60"
                               style="flex:1;" oninput="document.getElementById('pass-val').textContent=this.value+'%'">
                        <span id="pass-val" style="width:44px;font-weight:700;color:#8E6CFF;font-size:0.9375rem;text-align:right;">60%</span>
                    </div>
                    <p style="font-size:0.75rem;color:#94a3b8;margin-top:4px;">Score minimum pour reussir le test</p>
                </div>
                <div>
                    <label class="field-label">Statut</label>
                    <select name="status" class="field" id="status-field">
                        <option value="draft">Brouillon (non visible)</option>
                        <option value="active">Actif (accessible aux enseignants)</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══ SECTION 2 : COMPETENCES COUVERTES ═══ --}}
    <div class="card" style="padding:20px;margin-bottom:20px;">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
            <div class="step-dot" style="background:linear-gradient(135deg,#2ECC71,#4DA3FF);color:#fff;">2</div>
            <div>
                <h2 style="font-weight:700;color:#0f172a;font-size:0.9375rem;">Competences couvertes</h2>
                <p style="font-size:0.8rem;color:#64748b;margin-top:2px;">Ajoutez des questions pour couvrir ces competences</p>
            </div>
        </div>
        <div style="display:flex;flex-wrap:wrap;gap:8px;">
            @foreach($competences as $key => $comp)
            <div class="comp-pill" :style="coveredComps.includes('{{ $key }}') ? 'color:{{ $comp['color'] }};background:{{ $comp['bg'] }};opacity:1;' : 'color:#94a3b8;background:#f1f5f9;opacity:0.7;'">
                <span style="width:7px;height:7px;border-radius:50%;background:{{ $comp['color'] }};display:inline-block;" x-show="coveredComps.includes('{{ $key }}')"></span>
                <span>{{ $comp['label'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ═══ SECTION 3 : QUESTIONS ═══ --}}
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
        <div class="step-dot" style="background:linear-gradient(135deg,#E94E3C,#F97316);color:#fff;">3</div>
        <div style="flex:1;">
            <h2 style="font-weight:700;color:#0f172a;font-size:0.9375rem;">Questions & Reponses</h2>
            <p style="font-size:0.8rem;color:#64748b;margin-top:2px;">Ajoutez les questions et marquez la bonne reponse</p>
        </div>
        <span class="badge" style="color:#8E6CFF;background:rgba(142,108,255,0.1);" x-text="questions.length + ' question' + (questions.length > 1 ? 's' : '')"></span>
    </div>

    {{-- Question list --}}
    <div style="display:flex;flex-direction:column;gap:14px;margin-bottom:20px;">
        <template x-for="(q, qi) in questions" :key="q.uid">
            <div class="qcard">

                {{-- Question header --}}
                <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:14px;">
                    <div class="qnum" x-text="qi + 1"></div>
                    <div style="flex:1;display:flex;flex-direction:column;gap:10px;">
                        <div style="display:flex;gap:10px;flex-wrap:wrap;">
                            <input type="text"
                                   :name="'questions[' + qi + '][text]'"
                                   x-model="q.text"
                                   required
                                   class="field field-purple"
                                   style="flex:1;min-width:200px;"
                                   placeholder="Ecrivez votre question ici...">
                            <select :name="'questions[' + qi + '][competence]'"
                                    x-model="q.competence"
                                    @change="updateCovered()"
                                    required
                                    class="field"
                                    style="width:auto;min-width:200px;">
                                <option value="">-- Competence --</option>
                                @foreach($competences as $key => $comp)
                                <option value="{{ $key }}">{{ $comp['label'] }}</option>
                                @endforeach
                            </select>
                            <select :name="'questions[' + qi + '][points]'"
                                    x-model="q.points"
                                    class="field"
                                    style="width:auto;min-width:100px;">
                                <option value="1">1 point</option>
                                <option value="2">2 points</option>
                                <option value="3">3 points</option>
                            </select>
                        </div>

                        {{-- Competence tag --}}
                        <div x-show="q.competence" style="display:flex;align-items:center;gap:6px;font-size:0.75rem;">
                            <span style="color:#64748b;">Lie a :</span>
                            <template x-for="(comp, key) in competenceList" :key="key">
                                <span x-show="key === q.competence"
                                      class="comp-pill"
                                      :style="'color:' + comp.color + ';background:' + comp.bg + ';'"
                                      x-text="comp.label"></span>
                            </template>
                        </div>
                    </div>

                    {{-- Remove question --}}
                    <button type="button" @click="removeQuestion(qi)"
                            x-show="questions.length > 1"
                            class="btn btn-icon"
                            style="background:rgba(239,68,68,0.1);color:#EF4444;flex-shrink:0;"
                            title="Supprimer cette question">
                        <i class="bi bi-x-lg" style="font-size:0.875rem;"></i>
                    </button>
                </div>

                {{-- Answers --}}
                <div style="padding-left:40px;">
                    <p style="font-size:0.75rem;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:10px;">
                        Reponses — <span style="color:#2ECC71;font-weight:700;">marquer la bonne reponse</span>
                    </p>

                    <template x-for="(a, ai) in q.answers" :key="a.uid">
                        <div class="arow">
                            <input type="radio"
                                   :name="'questions[' + qi + '][correct]'"
                                   :value="ai"
                                   :checked="q.correct == ai"
                                   @change="q.correct = ai"
                                   class="correct-radio"
                                   title="Marquer comme correcte">
                            <input type="text"
                                   :name="'questions[' + qi + '][answers][' + ai + '][text]'"
                                   x-model="a.text"
                                   required
                                   class="atxt"
                                   :placeholder="'Reponse ' + (ai + 1)">
                            <button type="button" @click="removeAnswer(qi, ai)"
                                    x-show="q.answers.length > 2"
                                    style="background:none;border:none;cursor:pointer;color:#cbd5e1;padding:2px;font-size:0.875rem;line-height:1;"
                                    onmouseover="this.style.color='#EF4444'" onmouseout="this.style.color='#cbd5e1'"
                                    title="Supprimer">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </template>

                    {{-- Add answer --}}
                    <button type="button" @click="addAnswer(qi)"
                            x-show="q.answers.length < 6"
                            style="background:none;border:none;cursor:pointer;display:flex;align-items:center;gap:6px;font-size:0.8125rem;font-weight:600;color:#8E6CFF;padding:6px 0;font-family:'Inter',sans-serif;"
                            onmouseover="this.style.color='#6d51e0'" onmouseout="this.style.color='#8E6CFF'">
                        <i class="bi bi-plus-circle-fill"></i> Ajouter une reponse
                    </button>

                    {{-- Hidden correct index --}}
                    <input type="hidden" :name="'questions[' + qi + '][correct]'" :value="q.correct">
                </div>
            </div>
        </template>
    </div>

    {{-- ADD QUESTION button --}}
    <button type="button" @click="addQuestion()"
            style="width:100%;padding:14px;border:2px dashed #e2e8f0;border-radius:14px;background:transparent;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;font-size:0.875rem;font-weight:600;color:#64748b;font-family:'Inter',sans-serif;transition:all 0.15s;margin-bottom:24px;"
            onmouseover="this.style.borderColor='#8E6CFF';this.style.color='#8E6CFF';this.style.background='rgba(142,108,255,0.04)'"
            onmouseout="this.style.borderColor='#e2e8f0';this.style.color='#64748b';this.style.background='transparent'">
        <i class="bi bi-plus-circle-fill" style="font-size:1rem;"></i>
        Ajouter une question
    </button>

    {{-- SUBMIT footer --}}
    <div style="display:flex;align-items:center;justify-content:space-between;padding:18px 24px;background:#fff;border-radius:14px;border:1px solid #f1f5f9;">
        <div style="display:flex;align-items:center;gap:8px;font-size:0.8125rem;color:#64748b;">
            <i class="bi bi-info-circle" style="color:#8E6CFF;"></i>
            <span x-text="questions.length + ' question(s) — ' + coveredComps.length + ' competence(s) couverte(s)'"></span>
        </div>
        <div style="display:flex;gap:10px;">
            <button type="submit" name="status_submit" value="draft" class="btn btn-ghost">
                <i class="bi bi-cloud-arrow-up"></i> Brouillon
            </button>
            <button type="submit" name="status_submit" value="active" class="btn btn-purple">
                <i class="bi bi-send-fill"></i> Publier
            </button>
        </div>
    </div>

</div>
</form>

<script>
document.getElementById('quiz-form').addEventListener('submit', function(e) {
    const btn = document.activeElement;
    if (btn && btn.name === 'status_submit') {
        document.getElementById('status-field').value = btn.value;
    }
});

function quizBuilder() {
    let uid = 100;

    const competenceList = @json($competences);

    const makeAnswer = (text = '') => ({ uid: uid++, text });
    const makeQuestion = () => ({
        uid: uid++,
        text: '',
        competence: '',
        points: '1',
        correct: 0,
        answers: [makeAnswer(), makeAnswer(), makeAnswer(), makeAnswer()],
    });

    return {
        questions: [makeQuestion()],
        coveredComps: [],
        competenceList,

        addQuestion() {
            this.questions.push(makeQuestion());
        },
        removeQuestion(qi) {
            if (this.questions.length > 1) {
                this.questions.splice(qi, 1);
                this.updateCovered();
            }
        },
        addAnswer(qi) {
            if (this.questions[qi].answers.length < 6) {
                this.questions[qi].answers.push(makeAnswer());
            }
        },
        removeAnswer(qi, ai) {
            if (this.questions[qi].answers.length > 2) {
                this.questions[qi].answers.splice(ai, 1);
                if (this.questions[qi].correct >= this.questions[qi].answers.length) {
                    this.questions[qi].correct = 0;
                }
            }
        },
        updateCovered() {
            const comps = this.questions.map(q => q.competence).filter(c => c);
            this.coveredComps = [...new Set(comps)];
        },
    };
}
</script>
@endsection
