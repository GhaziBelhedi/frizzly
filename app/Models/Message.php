<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_name', 'email', 'phone', 'subject', 'message',
        'status', 'reply', 'replied_at',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    public function isUnread(): bool
    {
        return $this->status === 'unread';
    }

    public function markAsRead(): void
    {
        $this->update(['status' => 'read']);
    }
}
