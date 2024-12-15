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
                const response = await fetch('{{ route(auth()->user()->type === "Investor" ? "investor.messages.send" : "entrepreneur.messages.send") }}', {
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