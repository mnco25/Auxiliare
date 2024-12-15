@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/chat.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="chat-container">
    <div class="chat-sidebar">
        <div class="chat-header">
            <h3>Messages</h3>
            <div class="user-status online">
                <span class="status-indicator"></span>
                {{ Auth::user()->first_name }}
            </div>
        </div>
        
        <div class="conversation-list">
            @foreach($conversations as $userId => $conversation)
                @php
                    $otherUser = $conversation->first()->sender_id === Auth::id() 
                        ? $conversation->first()->receiver 
                        : $conversation->first()->sender;
                @endphp
                <div class="conversation-item {{ $receiverId == $userId ? 'active' : '' }}"
                     onclick="window.location.href='{{ route('chat.index', $userId) }}'">
                    <div class="avatar">
                        <img src="{{ $otherUser->profile->avatar ?? asset('images/default-avatar.png') }}" alt="Avatar">
                        <span class="status-dot {{ $otherUser->isOnline() ? 'online' : 'offline' }}"></span>
                    </div>
                    <div class="conversation-info">
                        <h4>{{ $otherUser->first_name }} {{ $otherUser->last_name }}</h4>
                        <p class="last-message">{{ Str::limit($conversation->first()->message_content, 30) }}</p>
                    </div>
                    @if($conversation->where('is_read', false)->where('receiver_id', Auth::id())->count() > 0)
                        <span class="unread-badge">
                            {{ $conversation->where('is_read', false)->where('receiver_id', Auth::id())->count() }}
                        </span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <div class="chat-main">
        @if($receiverId)
            <div class="chat-header">
                <div class="chat-user-info">
                    <img src="{{ $receiver->profile->avatar ?? asset('images/default-avatar.png') }}" alt="Avatar">
                    <div>
                        <h4>{{ $receiver->first_name }} {{ $receiver->last_name }}</h4>
                        <span class="user-status">{{ $receiver->isOnline() ? 'Online' : 'Offline' }}</span>
                    </div>
                </div>
            </div>

            <div class="messages-wrapper">
                <div class="messages-container" id="messages">
                    <div class="messages-list">
                        @foreach($messages as $message)
                            <div class="message {{ $message->sender_id === Auth::id() ? 'sent' : 'received' }}"
                                 data-message-id="{{ $message->id }}">
                                <div class="message-content">
                                    <div class="message-text">{{ $message->message_content }}</div>
                                    <div class="message-meta">
                                        <span class="message-time">
                                            {{ $message->created_at->format('g:i A') }}
                                        </span>
                                        @if($message->sender_id === Auth::id())
                                            <span class="message-status">
                                                <i class="fas fa-check{{ $message->is_read ? '-double' : '' }}"></i>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="message-input">
                <form id="message-form" action="{{ route('chat.send') }}" method="POST">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $receiverId }}">
                    <div class="input-group">
                        <input type="text" name="message" placeholder="Type your message..." autocomplete="off">
                        <button type="submit">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
                <div class="typing-indicator" style="display: none;">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        @else
            <div class="no-chat-selected">
                <i class="fas fa-comments"></i>
                <h3>Select a conversation to start messaging</h3>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/chat.js') }}"></script>
@endsection
