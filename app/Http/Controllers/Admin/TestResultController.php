<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestResult;
use Illuminate\Http\Request;

class TestResultController extends Controller
{
    public function index(Request $request)
    {
        // 1. On récupère les TestResults (Tests Diagnostiques)
        $testQuery = TestResult::with('user');
        
        // 2. On récupère les QuizResults (QCMs)
        $quizQuery = \App\Models\QuizResult::with(['user', 'quiz']);

        // Filtre Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $testQuery->where(function ($q) use ($search) {
                $q->where('test_title', 'like', "%$search%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%$search%"));
            });
            $quizQuery->where(function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%$search%"))
                  ->orWhereHas('quiz', fn($u) => $u->where('title', 'like', "%$search%"));
            });
        }

        // Filtre Statut
        if ($request->filled('status')) {
            $testQuery->where('status', $request->status);
            // Pour les QuizResults, on considère 'completed' par défaut
            if ($request->status !== 'completed') {
                $quizQuery->whereRaw('1 = 0'); 
            }
        }

        $testResults = $testQuery->latest()->get();
        $quizResults = $quizQuery->latest()->get();

        // On uniformise les QuizResults pour la vue
        foreach($quizResults as $qr) {
            $qr->test_title = $qr->quiz?->title ?? 'QCM';
            $qr->status     = 'completed';
            $qr->result_data = $qr->competence_scores; // Uniformisation avec TestResult
        }

        // Fusion et tri par date
        $tests = $testResults->concat($quizResults)->sortByDesc('created_at');

        return view('admin.tests.index', compact('tests'));
    }

    public function show(TestResult $testResult)
    {
        return response()->json($testResult->load('user'));
    }

    public function destroy(TestResult $testResult)
    {
        $testResult->delete();
        return back()->with('success', 'Résultat supprimé.');
    }
}
