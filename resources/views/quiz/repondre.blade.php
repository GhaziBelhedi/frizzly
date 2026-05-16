@extends('layouts.app')
@section('title', $quiz->title . ' — QCM')

@push('head')
<style>
body { background: #f8fafc; }
.opt-card {
    display:flex; align-items:center; gap:16px;
    padding:14px 18px; border-radius:12px;
    border:2px solid #e5e7eb; background:#fff;
    cursor:pointer; transition:all 0.18s; user-select:none;
}
.opt-card:hover { border-color:#8E6CFF; background:rgba(142,108,255,0.03); }
.opt-card.selected { border-color:#8E6CFF; background:rgba(142,108,255,0.06); }
.opt-radio { width:20px; height:20px; border-radius:50%; border:2.5px solid #e5e7eb; display:flex; align-items:center; justify-content:center; flex-shrink:0; transition:all 0.18s; }
.opt-card.selected .opt-radio { border-color:#8E6CFF; background:#8E6CFF; }
.opt-card.selected .opt-radio::after { content:''; width:8px; height:8px; border-radius:50%; background:#fff; display:block; }
.opt-letter { width:26px; height:26px; border-radius:7px; background:#f1f5f9; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.75rem; color:#64748b; flex-shrink:0; }
.opt-card.selected .opt-letter { background:#8E6CFF; color:#fff; }
.qblock { background:#fff; border-radius:16px; border:1px solid #f1f5f9; padding:24px; }
.comp-tag { display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:20px; font-size:0.7rem; font-weight:600; }
</style>
@endpush

@section('content')
@php
use App\Models\Quiz;
$competences = Quiz::COMPETENCES;
$letters = ['A','B','C','D','E','F'];
@endphp

<div style="max-width:760px;margin:0 auto;padding:24px 16px;">

    {{-- Header --}}
    <div style="background:linear-gradient(135deg,#8E6CFF,#4DA3FF);border-radius:20px;padding:28px 32px;color:#fff;margin-bottom:28px;">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap;">
            <div>
                <p style="font-size:0.75rem;font-weight:600;opacity:0.8;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:8px;">QCM — Evaluation des competences</p>
                <h1 style="font-weight:800;font-size:1.375rem;margin-bottom:8px;line-height:1.3;">{{ $quiz->title }}</h1>
                <p style="font-size:0.9rem;opacity:0.85;line-height:1.6;">{{ $quiz->description }}</p>
            </div>
            <div style="text-align:center;flex-shrink:0;">
                <p style="font-size:2.5rem;font-weight:800;line-height:1;">{{ $quiz->questions->count() }}</p>
                <p style="font-size:0.75rem;opacity:0.8;">questions</p>
            </div>
        </div>
        <div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:16px;">
            @foreach($quiz->coveredCompetences() as $ck)
            @php $cc = $competences[$ck] ?? ['label'=>$ck,'color'=>'#fff','bg'=>'rgba(255,255,255,0.2)']; @endphp
            <span style="background:rgba(255,255,255,0.2);color:#fff;padding:3px 12px;border-radius:20px;font-size:0.7rem;font-weight:600;">{{ $cc['label'] }}</span>
            @endforeach
        </div>
    </div>

    <form method="POST" action="{{ route('quiz.submit', $quiz->id) }}" x-data="{ answered: {} }" id="quiz-form">
        @csrf

        <input type="hidden" name="teacher_name"  value="{{ auth()->user()->name }}">
        <input type="hidden" name="teacher_email" value="{{ auth()->user()->email }}">

        {{-- Progress bar --}}
        <div style="margin-bottom:20px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;font-size:0.8125rem;">
                <span style="color:#64748b;">Progression</span>
                <span style="font-weight:600;color:#8E6CFF;" x-text="Object.keys(answered).length + ' / {{ $quiz->questions->count() }} repondu(e)(s)'"></span>
            </div>
            <div style="height:6px;background:#f1f5f9;border-radius:99px;overflow:hidden;">
                <div style="height:100%;background:linear-gradient(90deg,#8E6CFF,#4DA3FF);border-radius:99px;transition:width 0.3s;"
                     :style="'width:' + Math.round(Object.keys(answered).length / {{ $quiz->questions->count() }} * 100) + '%'"></div>
            </div>
        </div>

        {{-- Questions --}}
        <div style="display:flex;flex-direction:column;gap:16px;margin-bottom:24px;">
            @foreach($quiz->questions as $qi => $question)
            @php
            $qc = $competences[$question->competence] ?? ['label'=>$question->competence,'color'=>'#8E6CFF','bg'=>'#F0ECFF'];
            @endphp
            <div class="qblock" x-data="{ selected: null }">

                {{-- Question header --}}
                <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:16px;">
                    <div style="width:30px;height:30px;border-radius:9px;background:linear-gradient(135deg,#8E6CFF,#4DA3FF);color:#fff;font-weight:700;font-size:0.8125rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">{{ $qi + 1 }}</div>
                    <div style="flex:1;">
                        <p style="font-weight:600;color:#0f172a;font-size:0.9375rem;line-height:1.5;margin-bottom:8px;">{{ $question->text }}</p>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <span class="comp-tag" style="color:{{ $qc['color'] }};background:{{ $qc['bg'] }};">{{ $qc['label'] }}</span>
                            <span style="font-size:0.75rem;color:#94a3b8;">{{ $question->points }} pt{{ $question->points > 1 ? 's' : '' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Answers --}}
                <div style="display:flex;flex-direction:column;gap:8px;">
                    @foreach($question->answers as $ai => $answer)
                    <label class="opt-card" :class="selected == {{ $answer->id }} ? 'selected' : ''"
                           @click="selected = {{ $answer->id }}; $parent.answered[{{ $question->id }}] = true">
                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}"
                               style="display:none;" :checked="selected == {{ $answer->id }}">
                        <div class="opt-radio"></div>
                        <span class="opt-letter">{{ $letters[$ai] ?? chr(65+$ai) }}</span>
                        <span style="font-size:0.875rem;color:#374151;">{{ $answer->text }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        {{-- Submit --}}
        <div style="background:#fff;border-radius:16px;border:1px solid #f1f5f9;padding:20px;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;">
            <div style="font-size:0.8125rem;color:#64748b;">
                <i class="bi bi-info-circle" style="color:#8E6CFF;margin-right:6px;"></i>
                Repondez a toutes les questions avant de soumettre
            </div>
            <button type="submit" class="btn btn-purple" style="padding:12px 28px;font-size:0.9375rem;">
                <i class="bi bi-send-fill"></i> Soumettre mes reponses
            </button>
        </div>
    </form>

</div>
@endsection
