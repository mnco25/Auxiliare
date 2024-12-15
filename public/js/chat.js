document.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.getElementById('messages');
    const messagesList = document.querySelector('.messages-list');
    const messageForm = document.getElementById('message-form');
    const messageInput = messageForm?.querySelector('input[name="message"]');
    const typingIndicator = document.querySelector('.typing-indicator');
    
    // Scroll to bottom initially
    scrollToBottom();

    // Handle message submission
    if (messageForm) {
        messageForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(messageForm);
            
            try {
                const response = await fetch(messageForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (response.ok) {
                    const result = await response.json();
                    appendMessage(result.message);
                    messageInput.value = '';
                    scrollToBottom();
                }
            } catch (error) {
                console.error('Error sending message:', error);
            }
        });
    }

    // Typing indicator
    let typingTimeout;
    if (messageInput) {
        messageInput.addEventListener('input', () => {
            // Show typing indicator to other user
            sendTypingStatus(true);
            
            clearTimeout(typingTimeout);
            typingTimeout = setTimeout(() => {
                sendTypingStatus(false);
            }, 2000);
        });
    }

    // Poll for new messages
    setInterval(async () => {
        await checkNewMessages();
    }, 3000);

    async function checkNewMessages() {
        const lastMessageId = messagesList.lastElementChild?.dataset.messageId;
        try {
            const response = await fetch(`/chat/messages/new/${lastMessageId}`);
            const newMessages = await response.json();
            
            if (newMessages.length > 0) {
                newMessages.forEach(message => appendMessage(message));
                scrollToBottom();
            }
        } catch (error) {
            console.error('Error checking new messages:', error);
        }
    }

    function appendMessage(message) {
        const messageElement = createMessageElement(message);
        messagesList.insertAdjacentHTML('beforeend', messageElement);
    }

    function createMessageElement(message) {
        const isOwn = message.sender_id === currentUserId;
        return `
            <div class="message ${isOwn ? 'sent' : 'received'}" data-message-id="${message.id}">
                <div class="message-content">
                    ${message.message_content}
                    <div class="message-meta">
                        <span class="message-time">${formatTime(message.created_at)}</span>
                        ${isOwn ? `<span class="message-status">
                            <i class="fas fa-check${message.is_read ? '-double' : ''}"></i>
                        </span>` : ''}
                    </div>
                </div>
            </div>
        `;
    }

    function scrollToBottom() {
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    }

    function formatTime(timestamp) {
        return new Date(timestamp).toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
    }

    async function sendTypingStatus(isTyping) {
        try {
            await fetch('/chat/typing', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ isTyping })
            });
        } catch (error) {
            console.error('Error sending typing status:', error);
        }
    }
});
