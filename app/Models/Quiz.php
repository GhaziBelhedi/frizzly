<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    protected $fillable = ['title', 'description', 'passing_percentage', 'status'];

    // ── 9 competences de la plateforme ──────────────────────────
    public const COMPETENCES = [
        'creativite'           => ['label' => 'Créativité',              'color' => '#EC4899', 'bg' => '#FDF0F7'],
        'leadership'           => ['label' => 'Leadership',              'color' => '#E94E3C', 'bg' => '#FDECEA'],
        'autonomie'            => ['label' => 'Autonomie',               'color' => '#F97316', 'bg' => '#FEF3EA'],
        'pensee_critique'      => ['label' => 'Pensée critique',         'color' => '#8E6CFF', 'bg' => '#F0ECFF'],
        'adaptabilite'         => ['label' => 'Adaptabilité',            'color' => '#4DA3FF', 'bg' => '#EBF4FF'],
        'resolution_problemes' => ['label' => 'Résolution de problèmes', 'color' => '#2ECC71', 'bg' => '#E8FAF0'],
        'communication'        => ['label' => 'Communication',           'color' => '#F59E0B', 'bg' => '#FEF3C7'],
        'collaboration'        => ['label' => 'Collaboration',           'color' => '#0EA5E9', 'bg' => '#E0F2FE'],
        'innovation'           => ['label' => 'Innovation',              'color' => '#6366F1', 'bg' => '#EEF2FF'],
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }

    public function results(): HasMany
    {
        return $this->hasMany(QuizResult::class);
    }

    // Competences couvertes par ce quiz (keys uniques des questions)
    public function coveredCompetences(): array
    {
        // reorder() removes the orderBy('order') from the relationship
        // so DISTINCT on a single column works in strict MySQL mode
        return $this->questions()
            ->reorder()
            ->distinct()
            ->pluck('competence')
            ->toArray();
    }

    public function averageScore(): float
    {
        return round($this->results()->avg('percentage') ?? 0, 1);
    }

    public function totalPoints(): int
    {
        return $this->questions()->sum('points');
    }
}
