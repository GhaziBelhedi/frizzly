<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizResult extends Model
{
    protected $fillable = [
        'quiz_id', 'user_id', 'teacher_name', 'teacher_email',
        'score', 'total_points', 'percentage',
        'competence_scores', 'passed', 'recommendations', 'completed_at',
    ];

    protected $casts = [
        'competence_scores' => 'array',
        'recommendations'   => 'array',
        'passed'            => 'boolean',
        'completed_at'      => 'datetime',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function displayName(): string
    {
        return $this->teacher_name
            ?? $this->user?->name
            ?? 'Enseignant inconnu';
    }

    public function scoreLabel(): string
    {
        if ($this->percentage >= 80) return 'Excellent';
        if ($this->percentage >= 65) return 'Bien';
        if ($this->percentage >= $this->quiz->passing_percentage) return 'Acquis';
        return 'En cours';
    }

    public function scoreColor(): string
    {
        if ($this->percentage >= 80) return '#2ECC71';
        if ($this->percentage >= 65) return '#4DA3FF';
        if ($this->percentage >= ($this->quiz->passing_percentage ?? 60)) return '#F97316';
        return '#EF4444';
    }
}
