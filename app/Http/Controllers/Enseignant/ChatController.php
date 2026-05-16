<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $messages = ChatMessage::with('user')->latest()->take(100)->get()->reverse()->values();
        return view('enseignant.messages', compact('messages'));
    }

    public function store(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        ChatMessage::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return back();
    }

    public function poll(Request $request)
    {
        $after = $request->integer('after', 0);
        $messages = ChatMessage::with('user')
            ->where('id', '>', $after)
            ->oldest()
            ->get()
            ->map(fn($m) => [
                'id'      => $m->id,
                'name'    => $m->user->name,
                'mine'    => $m->user_id === Auth::id(),
                'message' => $m->message,
                'time'    => $m->created_at->format('H:i'),
            ]);

        return response()->json($messages);
    }
}
