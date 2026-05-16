<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = ['quiz_id', 'text', 'competence', 'points', 'order'];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function correctAnswer(): ?Answer
    {
        return $this->answers()->where('is_correct', true)->first();
    }

    public function competenceLabel(): string
    {
        return Quiz::COMPETENCES[$this->competence]['label'] ?? $this->competence;
    }

    public function competenceColor(): string
    {
        return Quiz::COMPETENCES[$this->competence]['color'] ?? '#64748b';
    }

    public function competenceBg(): string
    {
        return Quiz::COMPETENCES[$this->competence]['bg'] ?? '#f1f5f9';
    }
}
