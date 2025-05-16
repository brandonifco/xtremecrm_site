document.addEventListener('DOMContentLoaded', () => {
    const chatForm = document.querySelector('.chat-input');
    const chatInput = chatForm.querySelector('input[type="text"]');
    const chatMessages = document.getElementById('chatMessages');
    let typingTimeout;

    // 👉 Fade in chat bubble after 5s
    setTimeout(() => {
        const chatBubble = document.getElementById('chatBubble');
        if (chatBubble) {
            chatBubble.classList.remove('hidden');
        }
    }, 5000);

    chatInput.addEventListener('input', () => {
        clearTimeout(typingTimeout);

        fetch('/chat/set-typing.php', {
            method: 'POST'
        });

        typingTimeout = setTimeout(() => {
            // No-op: backend expires typing automatically
        }, 2500);
    });

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const message = chatInput.value.trim();
        if (!message) return;

        await fetch('/chat/send-message.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ message })
        });

        chatInput.value = '';
        await loadMessages(); // Refresh messages
    });

    async function loadMessages(isInitial = false) {
        const res = await fetch('/chat/get-messages.php');
        const data = await res.json();

        const messages = Array.isArray(data.messages) ? data.messages : data;
        const isTyping = data.typing ?? false;

        const atBottom =
            chatMessages.scrollTop + chatMessages.clientHeight >= chatMessages.scrollHeight - 50;

        chatMessages.innerHTML = '';

        messages.forEach(msg => {
            const div = document.createElement('div');
            div.className = `chat-message ${msg.sender}`;
            div.innerHTML = `<span class="chat-time">[${msg.time}]</span> ${msg.message}`;
            chatMessages.appendChild(div);
        });

        if (isTyping) {
            const typingEl = document.createElement('div');
            typingEl.className = 'typing-indicator';
            typingEl.textContent = 'User is typing...';
            chatMessages.appendChild(typingEl);
        }

        if (isInitial || atBottom) {
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    const lastMessage = chatMessages.lastElementChild;
                    if (lastMessage) {
                        lastMessage.scrollIntoView({ behavior: 'auto', block: 'end' });
                    }
                });
            });
        }
    }

    loadMessages(true);

    setInterval(() => {
        loadMessages(false);
    }, 1000);
});
