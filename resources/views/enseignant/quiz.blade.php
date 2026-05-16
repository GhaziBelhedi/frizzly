@extends('layouts.enseignant')
@section('title', 'Tests')
@section('page-title', 'Tests')
@section('page-sub', 'Questionnaires publiés par l\'administrateur')

@section('content')
@php
use App\Models\Quiz;
$quizzes = Quiz::where('status', 'active')->withCount('questions')->latest()->get();
@endphp

@if($quizzes->isEmpty())
<div class="flex flex-col items-center justify-center py-24 text-center">
    <div class="w-20 h-20 rounded-3xl flex items-center justify-center mb-5"
         style="background:linear-gradient(135deg,#F0ECFF,#EBF4FF);">
        <i class="bi bi-clipboard2-x" style="color:#8E6CFF;font-size:2rem;"></i>
    </div>
    <h2 class="font-bold text-gray-800 text-lg mb-2">Aucun test disponible</h2>
    <p class="text-gray-400 text-sm max-w-xs">
        L'administrateur n'a pas encore publié de test. Revenez plus tard.
    </p>
</div>
@else

{{-- Count header --}}
<div class="flex items-center gap-3 mb-6">
    <span class="text-sm font-semibold text-gray-500">
        {{ $quizzes->count() }} test{{ $quizzes->count() > 1 ? 's' : '' }} disponible{{ $quizzes->count() > 1 ? 's' : '' }}
    </span>
</div>

{{-- Grid --}}
<div class="grid md:grid-cols-2 xl:grid-cols-3 gap-5">
    @foreach($quizzes as $quiz)
    <div class="bg-white rounded-2xl border-2 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
         style="border-color:#8E6CFF25;">

        <div class="h-1.5" style="background:linear-gradient(90deg,#8E6CFF,#4DA3FF);"></div>

        <div class="p-6">
            {{-- Icon + passing badge --}}
            <div class="flex items-center justify-between mb-4">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center"
                     style="background:#F0ECFF;">
                    <i class="bi bi-patch-question-fill" style="color:#8E6CFF;font-size:1.2rem;"></i>
                </div>
                <span class="text-xs font-bold px-2.5 py-1 rounded-full"
                      style="background:#F0ECFF;color:#8E6CFF;">
                    Seuil {{ $quiz->passing_percentage }}%
                </span>
            </div>

            {{-- Title & description --}}
            <h3 class="font-bold text-gray-900 text-sm leading-snug mb-2">{{ $quiz->title }}</h3>
            @if($quiz->description)
            <p class="text-xs text-gray-400 leading-relaxed mb-4 line-clamp-2">{{ $quiz->description }}</p>
            @else
            <div class="mb-4"></div>
            @endif

            {{-- Meta --}}
            <div class="flex items-center gap-4 text-xs text-gray-400 mb-5">
                <span class="flex items-center gap-1">
                    <i class="bi bi-list-ol" style="color:#8E6CFF;"></i>
                    {{ $quiz->questions_count }} question{{ $quiz->questions_count > 1 ? 's' : '' }}
                </span>
                <span class="flex items-center gap-1">
                    <i class="bi bi-award" style="color:#4DA3FF;"></i>
                    {{ $quiz->passing_percentage }}% pour réussir
                </span>
            </div>

            {{-- CTA --}}
            <a href="{{ route('quiz.repondre', $quiz->id) }}"
               class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-xs font-bold text-white transition-all hover:-translate-y-0.5"
               style="background:linear-gradient(135deg,#8E6CFF,#4DA3FF);">
                <i class="bi bi-play-fill"></i> Commencer le test
            </a>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection
