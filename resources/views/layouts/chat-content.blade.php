<div class="chat-sidebar">
    <div class="chat-header">
        <h3><i class="fas fa-comments"></i> Messages</h3>
        <div class="user-status {{ auth()->user()->is_online ? 'online' : 'offline' }}">
            <span class="status-indicator"></span>
            {{ auth()->user()->first_name }}
        </div>
    </div>
    <div class="conversation-list">
        @forelse($conversations as $userId => $messages)
            @php
                $otherUser = $messages->first()->sender_id == auth()->id() 
                    ? $messages->first()->receiver 
                    : $messages->first()->sender;
                $lastMessage = $messages->first();
                $unreadCount = $messages->where('is_read', false)
                    ->where('receiver_id', auth()->id())
                    ->count();
            @endphp
            <div class="conversation-item @if(isset($currentChat) && $currentChat->user_id == $userId) active @endif"
                 data-user-id="{{ $userId }}"
                 onclick="window.location.href='{{ route(auth()->user()->type === 'Investor' ? 'investor.messages.show' : 'entrepreneur.messages.show', $userId) }}'">
                <div class="conversation-avatar">
                    <i class="fas fa-user-circle"></i>
                    <span class="user-status {{ $otherUser->is_online ? 'online' : 'offline' }}"></span>
                </div>
                <div class="conversation-info">
                    <h4>{{ $otherUser->first_name }} {{ $otherUser->last_name }}</h4>
                    <p class="last-message">{{ Str::limit($lastMessage->message_content, 30) }}</p>
                    <span class="message-time">{{ $lastMessage->created_at->diffForHumans() }}</span>
                </div>
                @if($unreadCount > 0)
                    <span class="unread-badge">{{ $unreadCount }}</span>
                @endif
            </div>
        @empty
            <div class="no-conversations">
                <p>No conversations yet</p>
            </div>
        @endforelse
    </div>
</div>

<div class="chat-main">
    @if(isset($currentChat))
        <div class="chat-header">
            <div class="chat-user-info">
                <i class="fas fa-user-circle"></i>
                <h3>{{ $currentChat->first_name }} {{ $currentChat->last_name }}</h3>
                <span class="user-status {{ $currentChat->is_online ? 'online' : 'offline' }}">
                    {{ $currentChat->is_online ? 'Online' : 'Offline' }}
                </span>
            </div>
        </div>
        <div class="chat-messages" id="messageContainer" data-chat-id="{{ $currentChat->user_id }}">
            @foreach($messages->where('conversation_id', $currentChat->conversation_id)->sortBy('created_at') as $message)
                <div class="message {{ $message->sender_id == auth()->id() ? 'sent' : 'received' }}"
                     data-message-id="{{ $message->id }}">
                    <div class="message-content">
                        {{ $message->message_content }}
                        <div class="message-meta">
                            <span class="message-time">{{ $message->created_at->format('H:i') }}</span>
                            @if($message->sender_id == auth()->id())
                                <span class="message-status">
                                    <i class="fas fa-check{{ $message->is_read ? '-double' : '' }}"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="chat-input">
            <form id="messageForm">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $currentChat->user_id }}">
                <div class="input-wrapper">
                    <input type="text" 
                           name="message" 
                           id="messageInput" 
                           placeholder="Type your message..." 
                           required
                           autocomplete="off">
                    <button type="submit">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
            <div class="typing-indicator" style="display: none;">
                <span></span><span></span><span></span>
            </div>
        </div>
    @else
        <div class="no-chat-selected">
            <i class="fas fa-comments"></i>
            <p>Select a conversation to start messaging</p>
        </div>
    @endif
</div> 