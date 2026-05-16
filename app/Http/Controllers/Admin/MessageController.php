<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $query = Message::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) =>
                $q->where('sender_name', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%")
                  ->orWhere('subject', 'like', "%$s%")
            );
        }

        if ($request->filled('status')) $query->where('status', $request->status);

        $messages = $query->latest()->paginate(20)->withQueryString();
        $unread   = Message::where('status', 'unread')->count();

        return view('admin.messages.index', compact('messages', 'unread'));
    }

    public function show(Message $message)
    {
        $message->markAsRead();
        return response()->json($message);
    }

    public function reply(Request $request, Message $message)
    {
        $request->validate(['reply' => 'required|string']);
        $message->update([
            'reply'      => $request->reply,
            'status'     => 'read',
            'replied_at' => now(),
        ]);
        return back()->with('success', 'Réponse envoyée.');
    }

    public function markRead(Message $message)
    {
        $message->markAsRead();
        return back()->with('success', 'Message marqué comme lu.');
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return back()->with('success', 'Message supprimé.');
    }
}
