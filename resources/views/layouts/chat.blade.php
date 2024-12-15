@extends($userType === 'Investor' ? 'investor.layout' : 'entrepreneur.layout')

@section('title', 'Chat - Auxiliare')

@section('additional_css')
<link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@if($userType === 'Investor')
<link rel="stylesheet" href="{{ asset('css/entrepreneur/home.css') }}">
@endif
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="{{ $userType === 'Investor' ? 'investor-container' : 'page-container' }}">
    <div class="{{ $userType === 'Investor' ? 'investor-header' : 'page-title-container' }}">
        <div class="{{ $userType === 'Investor' ? 'header-content' : '' }}">
            <h1 class="{{ $userType === 'Investor' ? '' : 'page-title' }}">Messages</h1>
            <p class="{{ $userType === 'Investor' ? 'text-muted' : 'page-subtitle' }}">
                Chat with entrepreneurs and other investors
            </p>
        </div>
    </div>

    <div class="chat-container">
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
                         onclick="window.location.href='{{ route($userType === 'Investor' ? 'investor.messages.show' : 'entrepreneur.messages.show', $userId) }}'">
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
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const messageForm = document.getElementById('messageForm');
    const messageContainer = document.getElementById('messageContainer');
    const messageInput = document.getElementById('messageInput');
    const currentChatId = messageContainer ? messageContainer.dataset.chatId : null;
    let lastMessageId = '{{ isset($messages) && $messages->isNotEmpty() ? $messages->last()->id : 0 }}';
    let isTyping = false;
    let typingTimeout;

    function scrollToBottom(smooth = false) {
        if (messageContainer) {
            messageContainer.scrollTo({
                top: messageContainer.scrollHeight,
                behavior: smooth ? 'smooth' : 'auto'
            });
        }
    }

    scrollToBottom();

    // Mark messages as read when they become visible
    function markMessagesAsRead() {
        if (!messageContainer) return;
        
        const unreadMessages = messageContainer.querySelectorAll('.message.received:not(.read)');
        if (!unreadMessages.length) return;

        const messageIds = Array.from(unreadMessages).map(msg => msg.dataset.messageId);
        
        fetch('{{ route("messages.mark-as-read") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message_ids: messageIds })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                unreadMessages.forEach(msg => msg.classList.add('read'));
            }
        });
    }

    async function checkNewMessages() {
        if (!currentChatId) return;
        
        try {
            const response = await fetch(`/chat/messages/new/${lastMessageId}/${currentChatId}`);
            const data = await response.json();
            
            if (data.messages && data.messages.length > 0) {
                const fragment = document.createDocumentFragment();
                
                data.messages
                    .filter(message => message.conversation_id === currentChatId)
                    .forEach(message => {
                        const messageDiv = document.createElement('div');
                        messageDiv.className = `message ${message.sender_id == {{ auth()->id() }} ? 'sent' : 'received'}`;
                        messageDiv.dataset.messageId = message.id;
                        
                        messageDiv.innerHTML = `
                            <div class="message-content">
                                ${message.message_content}
                                <div class="message-meta">
                                    <span class="message-time">
                                        ${new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                                    </span>
                                    ${message.sender_id == {{ auth()->id() }} ? `
                                        <span class="message-status">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    ` : ''}
                                </div>
                            </div>
                        `;
                        
                        fragment.appendChild(messageDiv);
                    });
                
                messageContainer.appendChild(fragment);
                lastMessageId = data.messages[data.messages.length - 1].id;
                scrollToBottom(true);
                markMessagesAsRead();
            }
        } catch (error) {
            console.error('Error fetching new messages:', error);
        }
    }

    if (messageContainer && currentChatId) {
        setInterval(checkNewMessages, 3000);
        markMessagesAsRead();
        
        // Intersection Observer for marking messages as read
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    markMessagesAsRead();
                }
            });
        });
        
        observer.observe(messageContainer);
    }

    if (messageForm) {
        messageForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const messageText = formData.get('message').trim();
            
            if (!messageText) return;
            
            messageInput.disabled = true;

            try {
                const response = await fetch('{{ route($userType === "Investor" ? "investor.messages.send" : "entrepreneur.messages.send") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        receiver_id: formData.get('receiver_id'),
                        message: messageText
                    })
                });

                const data = await response.json();
                if (data.success) {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'message sent';
                    messageDiv.dataset.messageId = data.message.id;
                    
                    messageDiv.innerHTML = `
                        <div class="message-content">
                            ${messageText}
                            <div class="message-meta">
                                <span class="message-time">
                                    ${new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                                </span>
                                <span class="message-status">
                                    <i class="fas fa-check"></i>
                                </span>
                            </div>
                        </div>
                    `;
                    
                    messageContainer.appendChild(messageDiv);
                    scrollToBottom(true);
                    messageForm.reset();
                    lastMessageId = data.message.id;
                }
            } catch (error) {
                console.error('Error sending message:', error);
                alert('Failed to send message. Please try again.');
            } finally {
                messageInput.disabled = false;
                messageInput.focus();
            }
        });

        // Typing indicator
        messageInput.addEventListener('input', function() {
            if (!isTyping) {
                isTyping = true;
                fetch('{{ route("chat.typing") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        receiver_id: currentChatId,
                        is_typing: true
                    })
                });
            }

            clearTimeout(typingTimeout);
            typingTimeout = setTimeout(() => {
                isTyping = false;
                fetch('{{ route("chat.typing") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        receiver_id: currentChatId,
                        is_typing: false
                    })
                });
            }, 2000);
        });
    }
});
</script>
@endsection 