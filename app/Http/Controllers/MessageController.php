<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function show($userId)
    {
        $currentChat = User::findOrFail($userId);
        
        // Get messages only between current user and selected user
        $messages = Message::where(function($query) use ($userId) {
                $query->where(function($q) use ($userId) {
                    $q->where('sender_id', auth()->id())
                      ->where('receiver_id', $userId);
                })->orWhere(function($q) use ($userId) {
                    $q->where('sender_id', $userId)
                      ->where('receiver_id', auth()->id());
                });
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        $conversations = $this->getConversations();

        // Return the appropriate view based on user type
        $viewName = auth()->user()->user_type === 'Investor' ? 'investor.chat' : 'entrepreneur.chat';
        return view($viewName, compact('messages', 'currentChat', 'conversations'));
    }

    public function getNewMessages($lastMessageId, $currentChatId)
    {
        // Get only new messages between current user and selected chat user
        $messages = Message::where('id', '>', $lastMessageId)
            ->where(function($query) use ($currentChatId) {
                $query->where(function($q) use ($currentChatId) {
                    $q->where('sender_id', auth()->id())
                      ->where('receiver_id', $currentChatId);
                })->orWhere(function($q) use ($currentChatId) {
                    $q->where('sender_id', $currentChatId)
                      ->where('receiver_id', auth()->id());
                });
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json(['messages' => $messages]);
    }

    public function getConversations()
    {
        $userId = auth()->id();
        
        // Get the latest message from each conversation
        return Message::where(function($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($message) use ($userId) {
                // Group by the other user's ID
                return $message->sender_id == $userId 
                    ? $message->receiver_id 
                    : $message->sender_id;
            })
            ->map(function ($messages) {
                // Keep only the latest message for each conversation
                return $messages->sortByDesc('created_at');
            });
    }

    public function index($receiverId = null)
    {
        $userId = auth()->id();
        $currentChat = null;
        $messages = collect();

        if ($receiverId) {
            $currentChat = User::findOrFail($receiverId);
            
            // Get messages only between current user and selected user
            $messages = Message::where(function($query) use ($userId, $receiverId) {
                    $query->where(function($q) use ($userId, $receiverId) {
                        $q->where('sender_id', $userId)
                          ->where('receiver_id', $receiverId);
                    })->orWhere(function($q) use ($userId, $receiverId) {
                        $q->where('sender_id', $receiverId)
                          ->where('receiver_id', $userId);
                    });
                })
                ->with(['sender', 'receiver'])
                ->orderBy('created_at', 'asc')
                ->get();
        }

        $conversations = $this->getConversations();

        // Return the appropriate view based on user type
        $viewName = auth()->user()->user_type === 'Investor' ? 'investor.chat' : 'entrepreneur.chat';
        return view($viewName, compact('messages', 'currentChat', 'conversations'));
    }

    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,user_id',
            'message' => 'required|string|max:1000',
            'project_id' => 'nullable|exists:projects,id'
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $validated['receiver_id'],
            'project_id' => $validated['project_id'] ?? null,
            'message_content' => $validated['message'],
            'is_read' => false,
        ]);

        // Load relationships for the response
        $message->load(['sender', 'receiver']);

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }
}
