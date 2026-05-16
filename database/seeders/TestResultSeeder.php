<?php

namespace Database\Seeders;

use App\Models\TestResult;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestResultSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = User::where('role', 'enseignant')->get();

        $tests = [
            ['title' => 'Compétences entrepreneuriales — Module 1', 'data' => ['leadership'=>75,'creativite'=>68,'autonomie'=>72]],
            ['title' => 'Auto-évaluation : Créativité & Innovation',  'data' => ['creativite'=>82,'innovation'=>78,'pensee_critique'=>65]],
            ['title' => 'Test diagnostique — Posture professionnelle','data' => ['leadership'=>55,'autonomie'=>60,'adaptabilite'=>58]],
            ['title' => 'Compétences entrepreneuriales — Module 2',   'data' => ['leadership'=>88,'communication'=>84,'collaboration'=>79]],
            ['title' => 'Leadership & Management d\'équipe',          'data' => ['leadership'=>72,'collaboration'=>68,'communication'=>75]],
            ['title' => 'Communication interpersonnelle',             'data' => ['communication'=>91,'collaboration'=>85,'adaptabilite'=>88]],
            ['title' => 'Gestion du stress et résilience',            'data' => ['adaptabilite'=>63,'resolution_problemes'=>58,'autonomie'=>67]],
            ['title' => 'Intelligence émotionnelle',                  'data' => ['communication'=>77,'collaboration'=>74,'leadership'=>80]],
            ['title' => 'Pensée critique et résolution de problèmes', 'data' => ['pensee_critique'=>69,'resolution_problemes'=>72,'adaptabilite'=>65]],
        ];

        foreach ($teachers as $teacher) {
            $numTests = rand(2, 5);
            $shuffled = collect($tests)->shuffle()->take($numTests);

            foreach ($shuffled as $test) {
                $mainScore = array_sum($test['data']) / count($test['data']);

                TestResult::create([
                    'user_id'     => $teacher->id,
                    'test_title'  => $test['title'],
                    'score'       => round($mainScore),
                    'percentage'  => round($mainScore, 2),
                    'result_data' => $test['data'],
                    'status'      => 'completed',
                    'created_at'  => now()->subDays(rand(1, 60)),
                    'updated_at'  => now()->subDays(rand(1, 60)),
                ]);
            }
        }
    }
}
