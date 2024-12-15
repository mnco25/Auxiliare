<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\UserTyping;
use App\Events\MessagesRead;

class ChatController extends Controller
{
    public function index($receiverId = null)
    {
        $userId = Auth::user()->user_id;

        $messages = Message::where(function($query) use ($userId) {
                        $query->where('sender_id', $userId)
                              ->orWhere('receiver_id', $userId);
                    })
                    ->orderBy('created_at', 'asc')
                    ->get();

        return view('chat', compact('messages', 'receiverId'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,user_id',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => Auth::user()->user_id,
            'receiver_id' => $request->receiver_id,
            'message_content' => $request->message,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => $message->load('sender', 'receiver')
        ]);
    }

    public function getNewMessages($lastMessageId)
    {
        $messages = Message::where(function($query) {
            $query->where('sender_id', Auth::id())
                  ->orWhere('receiver_id', Auth::id());
        })
        ->where('id', '>', $lastMessageId)
        ->with(['sender', 'receiver'])
        ->get();

        return response()->json($messages);
    }

    public function updateTypingStatus(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'is_typing' => 'required|boolean'
        ]);

        // Broadcast typing status to the receiver
        broadcast(new UserTyping(
            auth()->id(),
            $request->receiver_id,
            $request->is_typing
        ))->toOthers();

        return response()->json(['success' => true]);
    }

    public function markAsRead(Request $request)
    {
        $request->validate([
            'message_ids' => 'required|array',
            'message_ids.*' => 'exists:messages,id'
        ]);

        Message::whereIn('id', $request->message_ids)
            ->where('receiver_id', auth()->id())
            ->update(['is_read' => true]);

        broadcast(new MessagesRead(
            auth()->id(),
            $request->message_ids
        ))->toOthers();

        return response()->json(['success' => true]);
    }
}