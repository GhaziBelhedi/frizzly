<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;

class QuizTakeController extends Controller
{
    public function show(Quiz $quiz)
    {
        if ($quiz->status !== 'active') {
            abort(404, 'Ce QCM n\'est pas disponible.');
        }
        $quiz->load('questions.answers');
        return view('quiz.repondre', compact('quiz'));
    }

    public function submit(Quiz $quiz, Request $request)
    {
        $quiz->load('questions.answers');
        $answers = $request->input('answers', []);

        $teacherName  = auth()->user()->name;
        $teacherEmail = auth()->user()->email;

        $score       = 0;
        $totalPoints = 0;
        $compData    = []; // [comp => [earned, total]]

        foreach ($quiz->questions as $question) {
            $totalPoints += $question->points;
            $comp = $question->competence;

            if (!isset($compData[$comp])) {
                $compData[$comp] = ['earned' => 0, 'total' => 0];
            }
            $compData[$comp]['total'] += $question->points;

            $selectedId = $answers[$question->id] ?? null;
            if ($selectedId) {
                $answer = $question->answers->find($selectedId);
                if ($answer && $answer->is_correct) {
                    $score += $question->points;
                    $compData[$comp]['earned'] += $question->points;
                }
            }
        }

        $percentage = $totalPoints > 0 ? round(($score / $totalPoints) * 100, 2) : 0;

        // Pourcentage par compétence
        $competenceScores = [];
        foreach ($compData as $comp => $data) {
            $competenceScores[$comp] = $data['total'] > 0
                ? round(($data['earned'] / $data['total']) * 100)
                : 0;
        }

        // Recommandations intelligentes
        $recommendations = $this->generateRecommendations($competenceScores);

        $result = QuizResult::create([
            'quiz_id'          => $quiz->id,
            'user_id'          => auth()->id(),
            'teacher_name'     => $teacherName,
            'teacher_email'    => $teacherEmail,
            'score'            => $score,
            'total_points'     => $totalPoints,
            'percentage'       => $percentage,
            'competence_scores'=> $competenceScores,
            'passed'           => $percentage >= $quiz->passing_percentage,
            'recommendations'  => $recommendations,
            'completed_at'     => now(),
        ]);

        return redirect()->route('quiz.resultat', [$quiz->id, $result->id]);
    }

    public function result(Quiz $quiz, QuizResult $result)
    {
        $result->load('quiz');
        $competences = \App\Models\Quiz::COMPETENCES;
        return view('quiz.resultat', compact('quiz', 'result', 'competences'));
    }

    // ── Moteur de recommandations ──────────────────────────────
    private function generateRecommendations(array $scores): array
    {
        $messages = [
            'creativite' => [
                'low'  => 'Travaillez votre créativité en pratiquant des activités de brainstorming et en sortant de votre zone de confort pédagogique.',
                'mid'  => 'Continuez à développer votre créativité en expérimentant de nouvelles méthodes d\'enseignement.',
                'high' => 'Excellente créativité ! Partagez vos méthodes innovantes avec vos collègues.',
            ],
            'leadership' => [
                'low'  => 'Renforcez votre leadership en prenant l\'initiative dans des projets collaboratifs et en développant votre assertivité.',
                'mid'  => 'Votre leadership est en développement. Cherchez des opportunités pour guider et motiver votre équipe.',
                'high' => 'Votre leadership est un atout majeur. Continuez à inspirer et accompagner vos collègues.',
            ],
            'autonomie' => [
                'low'  => 'Développez votre autonomie en fixant des objectifs personnels clairs et en gérant votre temps de façon proactive.',
                'mid'  => 'Bonne autonomie. Continuez à renforcer votre capacité à travailler de manière indépendante.',
                'high' => 'Excellente autonomie ! Votre capacité à vous auto-gérer est remarquable.',
            ],
            'pensee_critique' => [
                'low'  => 'Entraînez votre pensée critique en analysant régulièrement vos pratiques et en questionnant vos habitudes.',
                'mid'  => 'Votre pensée critique se développe bien. Approfondissez l\'analyse des situations complexes.',
                'high' => 'Excellente pensée critique ! Votre capacité d\'analyse est un vrai atout professionnel.',
            ],
            'adaptabilite' => [
                'low'  => 'Travaillez votre adaptabilité en vous exposant volontairement à de nouvelles situations et méthodes.',
                'mid'  => 'Bonne adaptabilité. Continuez à développer votre flexibilité face au changement.',
                'high' => 'Excellente adaptabilité ! Vous gérez très bien les situations nouvelles et imprévues.',
            ],
            'resolution_problemes' => [
                'low'  => 'Améliorez votre résolution de problèmes en pratiquant des méthodes structurées comme le design thinking.',
                'mid'  => 'Bonne résolution de problèmes. Développez des approches plus systématiques et créatives.',
                'high' => 'Excellent en résolution de problèmes ! Votre approche méthodique est très efficace.',
            ],
            'communication' => [
                'low'  => 'Renforcez votre communication en pratiquant l\'écoute active et en travaillant votre expression orale et écrite.',
                'mid'  => 'Bonne communication. Continuez à affiner vos techniques d\'expression et d\'écoute.',
                'high' => 'Excellente communication ! Vos capacités relationnelles sont un atout précieux.',
            ],
            'collaboration' => [
                'low'  => 'Développez votre collaboration en participant activement aux projets d\'équipe et en valorisant les contributions de chacun.',
                'mid'  => 'Bonne collaboration. Renforcez votre capacité à travailler en équipe et à partager.',
                'high' => 'Excellente collaboration ! Votre esprit d\'équipe est remarquable.',
            ],
            'innovation' => [
                'low'  => 'Stimulez votre esprit d\'innovation en vous formant aux nouvelles technologies éducatives et en testant de nouvelles approches.',
                'mid'  => 'Bonne capacité d\'innovation. Osez expérimenter et introduire de nouvelles idées dans votre pratique.',
                'high' => 'Excellent esprit d\'innovation ! Vous êtes un moteur de changement positif.',
            ],
        ];

        $recs = [];
        foreach ($scores as $comp => $pct) {
            $level = $pct < 40 ? 'low' : ($pct < 70 ? 'mid' : 'high');
            if (isset($messages[$comp][$level])) {
                $recs[$comp] = [
                    'level'   => $level,
                    'message' => $messages[$comp][$level],
                ];
            }
        }
        return $recs;
    }
}
