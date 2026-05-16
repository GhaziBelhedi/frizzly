<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibraryPdf extends Model
{
    protected $fillable = [
        'title', 'description', 'category', 'file', 'file_size',
    ];

    public function getFileSizeFormattedAttribute(): string
    {
        if (!$this->file_size) return '—';
        $kb = $this->file_size / 1024;
        if ($kb < 1024) return round($kb, 1) . ' Ko';
        return round($kb / 1024, 1) . ' Mo';
    }
}
