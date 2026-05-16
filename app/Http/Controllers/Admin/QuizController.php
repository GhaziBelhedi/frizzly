<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::withCount(['questions', 'results'])->latest()->get();

        $stats = [
            'total'     => $quizzes->count(),
            'active'    => $quizzes->where('status', 'active')->count(),
            'draft'     => $quizzes->where('status', 'draft')->count(),
            'responses' => QuizResult::count(),
        ];

        return view('admin.quiz.index', compact('quizzes', 'stats'));
    }

    public function create()
    {
        $competences = Quiz::COMPETENCES;
        return view('admin.quiz.create', compact('competences'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'              => 'required|string|max:255',
            'description'        => 'nullable|string',
            'passing_percentage' => 'required|integer|between:1,100',
            'status'             => 'required|in:draft,active,archived',
            'questions'          => 'required|array|min:1',
            'questions.*.text'             => 'required|string',
            'questions.*.competence'       => 'required|string',
            'questions.*.points'           => 'nullable|integer|min:1',
            'questions.*.answers'          => 'required|array|min:2',
            'questions.*.answers.*.text'   => 'required|string',
        ]);

        $quiz = Quiz::create([
            'title'              => $request->title,
            'description'        => $request->description,
            'passing_percentage' => $request->passing_percentage,
            'status'             => $request->status,
        ]);

        foreach ($request->questions as $qi => $qData) {
            $question = $quiz->questions()->create([
                'text'       => $qData['text'],
                'competence' => $qData['competence'],
                'points'     => $qData['points'] ?? 1,
                'order'      => $qi,
            ]);

            $correctIndex = $qData['correct'] ?? null;

            foreach ($qData['answers'] as $ai => $aData) {
                if (empty(trim($aData['text']))) continue;
                $question->answers()->create([
                    'text'       => $aData['text'],
                    'is_correct' => (string)$correctIndex === (string)$ai,
                ]);
            }
        }

        return redirect()->route('admin.quiz.show', $quiz)
            ->with('success', 'QCM créé avec succès.');
    }

    public function show(Quiz $quiz)
    {
        $quiz->load(['questions.answers', 'results.user']);
        $competences    = Quiz::COMPETENCES;
        $covered        = $quiz->coveredCompetences();
        $averageScore   = $quiz->averageScore();

        // Moyenne par compétence sur tous les résultats
        $competenceAverages = [];
        if ($quiz->results->isNotEmpty()) {
            foreach ($covered as $comp) {
                $scores = $quiz->results
                    ->filter(fn($r) => isset($r->competence_scores[$comp]))
                    ->map(fn($r) => $r->competence_scores[$comp]);
                $competenceAverages[$comp] = $scores->isNotEmpty()
                    ? round($scores->avg(), 1)
                    : 0;
            }
        }

        return view('admin.quiz.show', compact(
            'quiz', 'competences', 'covered', 'averageScore', 'competenceAverages'
        ));
    }

    public function edit(Quiz $quiz)
    {
        $quiz->load('questions.answers');
        $competences = Quiz::COMPETENCES;
        return view('admin.quiz.edit', compact('quiz', 'competences'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'title'              => 'required|string|max:255',
            'description'        => 'nullable|string',
            'passing_percentage' => 'required|integer|between:1,100',
            'status'             => 'required|in:draft,active,archived',
            'questions'          => 'required|array|min:1',
            'questions.*.text'             => 'required|string',
            'questions.*.competence'       => 'required|string',
            'questions.*.answers'          => 'required|array|min:2',
            'questions.*.answers.*.text'   => 'required|string',
        ]);

        $quiz->update([
            'title'              => $request->title,
            'description'        => $request->description,
            'passing_percentage' => $request->passing_percentage,
            'status'             => $request->status,
        ]);

        // Delete old questions/answers and recreate
        $quiz->questions()->delete();

        foreach ($request->questions as $qi => $qData) {
            $question = $quiz->questions()->create([
                'text'       => $qData['text'],
                'competence' => $qData['competence'],
                'points'     => $qData['points'] ?? 1,
                'order'      => $qi,
            ]);

            $correctIndex = $qData['correct'] ?? null;

            foreach ($qData['answers'] as $ai => $aData) {
                if (empty(trim($aData['text']))) continue;
                $question->answers()->create([
                    'text'       => $aData['text'],
                    'is_correct' => (string)$correctIndex === (string)$ai,
                ]);
            }
        }

        return redirect()->route('admin.quiz.show', $quiz)
            ->with('success', 'QCM mis à jour.');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.quiz.index')
            ->with('success', 'QCM supprimé.');
    }

    public function toggleStatus(Quiz $quiz)
    {
        $quiz->update([
            'status' => $quiz->status === 'active' ? 'draft' : 'active',
        ]);
        return back()->with('success', 'Statut mis à jour.');
    }
}
