<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\User;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        // ── QCM 1 : Test diagnostique ─────────────────────────────
        $q1 = Quiz::create([
            'title'              => 'Test diagnostique — Posture professionnelle',
            'description'        => 'Évaluation initiale des 9 compétences entrepreneuriales et pédagogiques. Ce test permet d\'identifier vos points forts et axes d\'amélioration.',
            'passing_percentage' => 60,
            'status'             => 'active',
        ]);

        $questions1 = [
            ['text' => 'Face à une situation de classe difficile, quelle est votre première réaction ?', 'competence' => 'adaptabilite', 'points' => 1,
             'answers' => [
                 ['text' => 'Vous improvisez une nouvelle activité pour recapturer l\'attention', 'correct' => true],
                 ['text' => 'Vous continuez le cours comme prévu sans dévier', 'correct' => false],
                 ['text' => 'Vous attendez que la situation se calme d\'elle-même', 'correct' => false],
                 ['text' => 'Vous notez les noms des élèves perturbateurs', 'correct' => false],
             ]],
            ['text' => 'Comment préparez-vous habituellement vos séquences pédagogiques ?', 'competence' => 'autonomie', 'points' => 1,
             'answers' => [
                 ['text' => 'Vous créez vos propres ressources adaptées à vos élèves', 'correct' => true],
                 ['text' => 'Vous suivez strictement le manuel scolaire', 'correct' => false],
                 ['text' => 'Vous vous appuyez uniquement sur les supports fournis', 'correct' => false],
                 ['text' => 'Vous reproduisez ce que vos collègues font', 'correct' => false],
             ]],
            ['text' => 'Lors d\'un projet d\'équipe pédagogique, quel rôle adoptez-vous naturellement ?', 'competence' => 'leadership', 'points' => 1,
             'answers' => [
                 ['text' => 'Vous proposez des idées et mobilisez le groupe autour d\'un objectif commun', 'correct' => true],
                 ['text' => 'Vous attendez les instructions des autres', 'correct' => false],
                 ['text' => 'Vous préférez travailler seul plutôt qu\'en groupe', 'correct' => false],
                 ['text' => 'Vous participez uniquement quand on vous le demande', 'correct' => false],
             ]],
            ['text' => 'Quand vous réfléchissez à votre pratique pédagogique, que faites-vous ?', 'competence' => 'pensee_critique', 'points' => 1,
             'answers' => [
                 ['text' => 'Vous analysez ce qui a fonctionné et ce qui doit être amélioré', 'correct' => true],
                 ['text' => 'Vous considérez que vos méthodes sont déjà efficaces', 'correct' => false],
                 ['text' => 'Vous ne consacrez pas de temps à cette réflexion', 'correct' => false],
                 ['text' => 'Vous demandez uniquement l\'avis de votre directeur', 'correct' => false],
             ]],
            ['text' => 'Lorsqu\'un élève n\'arrive pas à comprendre une notion, vous :', 'competence' => 'creativite', 'points' => 1,
             'answers' => [
                 ['text' => 'Trouvez une nouvelle façon d\'expliquer avec des exemples concrets et originaux', 'correct' => true],
                 ['text' => 'Répétez la même explication plus lentement', 'correct' => false],
                 ['text' => 'Lui demandez de revoir la leçon à la maison', 'correct' => false],
                 ['text' => 'Passez à la notion suivante pour ne pas freiner le groupe', 'correct' => false],
             ]],
            ['text' => 'Comment communiquez-vous avec les parents d\'élèves ?', 'competence' => 'communication', 'points' => 1,
             'answers' => [
                 ['text' => 'Vous initiez des échanges réguliers et clairs, en adaptant votre discours à chaque parent', 'correct' => true],
                 ['text' => 'Vous attendez qu\'ils prennent contact avec vous', 'correct' => false],
                 ['text' => 'Vous communiquez uniquement lors des réunions officielles', 'correct' => false],
                 ['text' => 'Vous déléguez cette tâche au directeur d\'école', 'correct' => false],
             ]],
            ['text' => 'Face à un problème organisationnel dans votre classe, vous :', 'competence' => 'resolution_problemes', 'points' => 1,
             'answers' => [
                 ['text' => 'Identifiez la cause, explorez plusieurs solutions et choisissez la plus adaptée', 'correct' => true],
                 ['text' => 'Appliquez la première solution qui vous vient à l\'esprit', 'correct' => false],
                 ['text' => 'Attendez que le problème se résolve tout seul', 'correct' => false],
                 ['text' => 'Demandez à un collègue de gérer à votre place', 'correct' => false],
             ]],
            ['text' => 'Dans votre pratique, comment intégrez-vous vos collègues ?', 'competence' => 'collaboration', 'points' => 1,
             'answers' => [
                 ['text' => 'Vous partagez ressources, idées et retours d\'expérience régulièrement', 'correct' => true],
                 ['text' => 'Vous préférez garder vos méthodes pour vous', 'correct' => false],
                 ['text' => 'Vous collaborez uniquement si c\'est imposé par l\'administration', 'correct' => false],
                 ['text' => 'Vous évitez les discussions professionnelles en dehors des réunions', 'correct' => false],
             ]],
            ['text' => 'Comment tenez-vous compte des nouvelles tendances pédagogiques ?', 'competence' => 'innovation', 'points' => 1,
             'answers' => [
                 ['text' => 'Vous vous formez activement et expérimentez de nouvelles approches dans votre classe', 'correct' => true],
                 ['text' => 'Vous attendez que ces approches soient validées avant de les essayer', 'correct' => false],
                 ['text' => 'Vous considérez que les méthodes traditionnelles sont suffisantes', 'correct' => false],
                 ['text' => 'Vous lisez des articles mais n\'appliquez rien en classe', 'correct' => false],
             ]],
        ];

        $this->createQuestions($q1, $questions1);

        // ── QCM 2 : Module 1 — Autonomie ────────────────────────
        $q2 = Quiz::create([
            'title'              => 'Module 1 — Se connaître : Autonomie & Confiance',
            'description'        => 'QCM de validation du premier module. Évalue votre niveau d\'autonomie professionnelle et votre capacité à vous auto-gérer.',
            'passing_percentage' => 65,
            'status'             => 'active',
        ]);

        $questions2 = [
            ['text' => 'Quelle pratique illustre le mieux l\'autonomie professionnelle d\'un enseignant ?', 'competence' => 'autonomie', 'points' => 2,
             'answers' => [
                 ['text' => 'Fixer ses propres objectifs de développement et les suivre sans supervision', 'correct' => true],
                 ['text' => 'Attendre les instructions de la direction pour toute décision', 'correct' => false],
                 ['text' => 'Reproduire exactement ce que font ses collègues expérimentés', 'correct' => false],
                 ['text' => 'Demander validation pour chaque petite décision pédagogique', 'correct' => false],
             ]],
            ['text' => 'Comment un enseignant autonome gère-t-il son temps de préparation ?', 'competence' => 'autonomie', 'points' => 2,
             'answers' => [
                 ['text' => 'Il planifie et priorise ses tâches selon ses objectifs pédagogiques', 'correct' => true],
                 ['text' => 'Il attend la dernière minute pour préparer ses cours', 'correct' => false],
                 ['text' => 'Il délègue la préparation à des ressources externes uniquement', 'correct' => false],
                 ['text' => 'Il suit uniquement le rythme imposé par ses collègues', 'correct' => false],
             ]],
            ['text' => 'Face à une critique de son directeur, un enseignant confiant :', 'competence' => 'adaptabilite', 'points' => 1,
             'answers' => [
                 ['text' => 'Écoute, analyse objectivement et intègre les retours pertinents', 'correct' => true],
                 ['text' => 'Se défend systématiquement et rejette toute critique', 'correct' => false],
                 ['text' => 'Abandonne ses pratiques sans vraiment réfléchir', 'correct' => false],
                 ['text' => 'Ignore les retours et continue comme avant', 'correct' => false],
             ]],
            ['text' => 'Qu\'est-ce qui caractérise une démarche d\'auto-évaluation efficace ?', 'competence' => 'pensee_critique', 'points' => 2,
             'answers' => [
                 ['text' => 'Analyser ses pratiques selon des critères clairs et formuler des axes d\'amélioration', 'correct' => true],
                 ['text' => 'Se contenter d\'une impression générale de réussite ou d\'échec', 'correct' => false],
                 ['text' => 'Comparer uniquement ses résultats avec ceux de ses collègues', 'correct' => false],
                 ['text' => 'Attendre l\'évaluation annuelle du directeur pour s\'interroger', 'correct' => false],
             ]],
            ['text' => 'Comment développer sa confiance en soi en tant qu\'enseignant ?', 'competence' => 'leadership', 'points' => 1,
             'answers' => [
                 ['text' => 'En acceptant des défis progressifs et en célébrant ses réussites', 'correct' => true],
                 ['text' => 'En évitant toute situation nouvelle pour ne pas échouer', 'correct' => false],
                 ['text' => 'En s\'appuyant uniquement sur la validation externe', 'correct' => false],
                 ['text' => 'En comparant constamment ses performances aux autres', 'correct' => false],
             ]],
        ];

        $this->createQuestions($q2, $questions2);

        // ── QCM 3 : Module 2 — Créativité ───────────────────────
        $q3 = Quiz::create([
            'title'              => 'Module 2 — Créativité & Innovation pédagogique',
            'description'        => 'Évaluation des compétences créatives et innovantes dans la pratique pédagogique quotidienne.',
            'passing_percentage' => 60,
            'status'             => 'active',
        ]);

        $questions3 = [
            ['text' => 'Quelle approche favorise le plus la créativité des élèves ?', 'competence' => 'creativite', 'points' => 2,
             'answers' => [
                 ['text' => 'Proposer des projets ouverts où les élèves définissent leur propre démarche', 'correct' => true],
                 ['text' => 'Donner des exercices avec une seule bonne réponse possible', 'correct' => false],
                 ['text' => 'Imposer un cadre très strict pour guider la production', 'correct' => false],
                 ['text' => 'Évaluer uniquement la conformité aux consignes données', 'correct' => false],
             ]],
            ['text' => 'Comment introduire l\'innovation dans une classe de manière efficace ?', 'competence' => 'innovation', 'points' => 2,
             'answers' => [
                 ['text' => 'Tester une nouvelle approche, l\'évaluer puis l\'adapter selon les résultats', 'correct' => true],
                 ['text' => 'Changer toutes les méthodes d\'un coup pour un renouveau total', 'correct' => false],
                 ['text' => 'Attendre l\'autorisation de l\'administration avant d\'innover', 'correct' => false],
                 ['text' => 'Copier exactement les méthodes utilisées dans d\'autres pays', 'correct' => false],
             ]],
            ['text' => 'Le brainstorming en classe est particulièrement utile pour :', 'competence' => 'creativite', 'points' => 1,
             'answers' => [
                 ['text' => 'Générer un maximum d\'idées sans jugement immédiat', 'correct' => true],
                 ['text' => 'Sélectionner rapidement la meilleure solution', 'correct' => false],
                 ['text' => 'Évaluer les connaissances antérieures des élèves', 'correct' => false],
                 ['text' => 'Discipliner les élèves qui manquent de concentration', 'correct' => false],
             ]],
            ['text' => 'Un enseignant innovant face à l\'échec d\'une nouvelle méthode :', 'competence' => 'adaptabilite', 'points' => 1,
             'answers' => [
                 ['text' => 'Analyse les causes de l\'échec et ajuste son approche pour la prochaine tentative', 'correct' => true],
                 ['text' => 'Abandonne définitivement toute idée d\'innover', 'correct' => false],
                 ['text' => 'Continue d\'appliquer la même méthode sans changement', 'correct' => false],
                 ['text' => 'Blâme les élèves pour leur manque d\'engagement', 'correct' => false],
             ]],
            ['text' => 'Quel outil numérique peut le mieux soutenir la créativité pédagogique ?', 'competence' => 'innovation', 'points' => 2,
             'answers' => [
                 ['text' => 'Un outil de création collaborative permettant aux élèves de co-construire', 'correct' => true],
                 ['text' => 'Un logiciel de présentation remplaçant le tableau noir', 'correct' => false],
                 ['text' => 'Un système de contrôle de présence automatisé', 'correct' => false],
                 ['text' => 'Un site de ressources pédagogiques statiques', 'correct' => false],
             ]],
        ];

        $this->createQuestions($q3, $questions3);

        // ── QCM 4 : Evaluation finale (brouillon) ────────────────
        $q4 = Quiz::create([
            'title'              => 'Évaluation finale — Les 9 compétences entrepreneuriales',
            'description'        => 'QCM complet couvrant l\'ensemble des 9 compétences de la plateforme Frizzly. Réservé aux enseignants ayant complété les 4 modules du programme.',
            'passing_percentage' => 70,
            'status'             => 'draft',
        ]);

        $questions4 = [
            ['text' => 'Quelle compétence permet de maintenir la motivation des élèves sur le long terme ?', 'competence' => 'leadership', 'points' => 2,
             'answers' => [
                 ['text' => 'Le leadership : inspirer et donner du sens aux apprentissages', 'correct' => true],
                 ['text' => 'La rigueur : appliquer les règles de manière stricte et constante', 'correct' => false],
                 ['text' => 'La rapidité : couvrir un maximum de contenu en peu de temps', 'correct' => false],
                 ['text' => 'La neutralité : ne pas montrer ses émotions face aux élèves', 'correct' => false],
             ]],
            ['text' => 'Comment développer la pensée critique des élèves ?', 'competence' => 'pensee_critique', 'points' => 2,
             'answers' => [
                 ['text' => 'En les encourageant à questionner, comparer et argumenter leurs réponses', 'correct' => true],
                 ['text' => 'En leur donnant uniquement des exercices avec des réponses univoques', 'correct' => false],
                 ['text' => 'En valorisant uniquement les bonnes réponses pour créer des modèles', 'correct' => false],
                 ['text' => 'En limitant les discussions pour maintenir le rythme du cours', 'correct' => false],
             ]],
            ['text' => 'La résolution de problèmes en classe passe avant tout par :', 'competence' => 'resolution_problemes', 'points' => 2,
             'answers' => [
                 ['text' => 'Définir clairement le problème avant de chercher des solutions', 'correct' => true],
                 ['text' => 'Appliquer immédiatement la solution la plus rapide', 'correct' => false],
                 ['text' => 'Attendre que le problème disparaisse naturellement', 'correct' => false],
                 ['text' => 'Consulter uniquement les ressources disponibles sans analyse', 'correct' => false],
             ]],
            ['text' => 'Un enseignant qui collabore efficacement avec ses collègues :', 'competence' => 'collaboration', 'points' => 1,
             'answers' => [
                 ['text' => 'Partage ses expériences, écoute et co-construit des solutions communes', 'correct' => true],
                 ['text' => 'Travaille en parallèle sans coordination avec les autres', 'correct' => false],
                 ['text' => 'Attend uniquement les décisions collectives pour agir', 'correct' => false],
                 ['text' => 'Partage uniquement ce qui l\'avantage personnellement', 'correct' => false],
             ]],
        ];

        $this->createQuestions($q4, $questions4);

        // ── QCM 5 : Communication (brouillon) ────────────────────
        $q5 = Quiz::create([
            'title'              => 'Auto-évaluation — Communication & Collaboration',
            'description'        => 'Questionnaire centré sur les compétences relationnelles essentielles à la pratique enseignante.',
            'passing_percentage' => 60,
            'status'             => 'draft',
        ]);

        $questions5 = [
            ['text' => 'Quelle est la base d\'une communication efficace avec les élèves ?', 'competence' => 'communication', 'points' => 2,
             'answers' => [
                 ['text' => 'L\'écoute active, la clarté du message et l\'adaptation au niveau des élèves', 'correct' => true],
                 ['text' => 'Parler fort et clairement en utilisant un vocabulaire académique', 'correct' => false],
                 ['text' => 'Répéter les consignes plusieurs fois jusqu\'à ce qu\'elles soient mémorisées', 'correct' => false],
                 ['text' => 'Utiliser uniquement des supports visuels pour éviter les malentendus', 'correct' => false],
             ]],
            ['text' => 'Comment favoriser la collaboration entre élèves dans un projet de groupe ?', 'competence' => 'collaboration', 'points' => 2,
             'answers' => [
                 ['text' => 'Définir des rôles clairs, encourager l\'écoute mutuelle et valoriser les contributions de chacun', 'correct' => true],
                 ['text' => 'Laisser les élèves s\'organiser seuls sans intervention de l\'enseignant', 'correct' => false],
                 ['text' => 'Attribuer le même travail à tous pour éviter les inégalités', 'correct' => false],
                 ['text' => 'Évaluer uniquement le résultat final sans tenir compte du processus', 'correct' => false],
             ]],
            ['text' => 'Un feedback constructif donné à un élève doit être :', 'competence' => 'communication', 'points' => 1,
             'answers' => [
                 ['text' => 'Spécifique, bienveillant et orienté vers des pistes d\'amélioration concrètes', 'correct' => true],
                 ['text' => 'Général et positif pour ne pas décourager l\'élève', 'correct' => false],
                 ['text' => 'Uniquement négatif pour l\'inciter à se surpasser', 'correct' => false],
                 ['text' => 'Comparatif avec les autres élèves pour le motiver', 'correct' => false],
             ]],
        ];

        $this->createQuestions($q5, $questions5);

        // ── Résultats de quiz (pour les enseignants) ─────────────
        $teachers = User::where('role', 'teacher')->get();
        $activeQuizzes = Quiz::where('status', 'active')->with('questions')->get();

        foreach ($activeQuizzes as $quiz) {
            $totalPts = $quiz->questions->sum('points');
            if ($totalPts === 0) continue;

            foreach ($teachers->take(8) as $teacher) {
                $score = rand((int)($totalPts * 0.4), $totalPts);
                $pct   = round($score / $totalPts * 100, 2);

                // Random competence scores
                $compScores = [];
                foreach ($quiz->questions->pluck('competence')->unique() as $comp) {
                    $compScores[$comp] = rand(38, 95);
                }

                $recs = [];
                foreach ($compScores as $comp => $cpct) {
                    $level = $cpct < 40 ? 'low' : ($cpct < 70 ? 'mid' : 'high');
                    $recs[$comp] = ['level' => $level, 'message' => "Recommandation pour $comp."];
                }

                QuizResult::create([
                    'quiz_id'           => $quiz->id,
                    'user_id'           => $teacher->id,
                    'teacher_name'      => $teacher->name,
                    'teacher_email'     => $teacher->email,
                    'score'             => $score,
                    'total_points'      => $totalPts,
                    'percentage'        => $pct,
                    'competence_scores' => $compScores,
                    'passed'            => $pct >= $quiz->passing_percentage,
                    'recommendations'   => $recs,
                    'completed_at'      => now()->subDays(rand(1, 30)),
                ]);
            }
        }
    }

    private function createQuestions(Quiz $quiz, array $questions): void
    {
        foreach ($questions as $order => $qData) {
            $question = Question::create([
                'quiz_id'    => $quiz->id,
                'text'       => $qData['text'],
                'competence' => $qData['competence'],
                'points'     => $qData['points'],
                'order'      => $order,
            ]);

            foreach ($qData['answers'] as $aData) {
                Answer::create([
                    'question_id' => $question->id,
                    'text'        => $aData['text'],
                    'is_correct'  => $aData['correct'],
                ]);
            }
        }
    }
}
