document.addEventListener('DOMContentLoaded', () => {
    const chatForm = document.querySelector('.chat-input');
    const chatInput = chatForm.querySelector('input[type="text"]');
    const chatMessages = document.getElementById('chatMessages');
    let typingTimeout;
    let lastMessageTimes = [];

    // 👉 Fade in chat bubble after 5s
    setTimeout(() => {
        const chatBubble = document.getElementById('chat-bubble');
        if (chatBubble) {
            chatBubble.classList.remove('hidden');
        }
    }, 5000);

    // ✅ Show name modal if not set in sessionStorage
    if (!sessionStorage.getItem('chat_name')) {
        document.getElementById('chatNameModal').classList.remove('hidden');
    }

    // ✅ Handle name submit
    document.getElementById('chatNameSubmit').addEventListener('click', () => {
        const name = document.getElementById('chatUserName').value.trim();
        if (!name) {
            alert('Please enter your name.');
            return;
        }

        sessionStorage.setItem('chat_name', name);
        document.getElementById('chatNameModal').classList.add('hidden');
    });

    // ✅ Handle message submit
    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const message = chatInput.value.trim();
        if (!message) return;

        const name = sessionStorage.getItem('chat_name');
        if (!name) {
            alert('Please re-enter your name to continue chatting.');
            document.getElementById('chatNameModal').classList.remove('hidden');
            return;
        }

        await fetch('/chat/send-message.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ name, message })
        });

        await fetch('/chat/stop-typing.php', { method: 'POST' });
        chatInput.value = '';
        await loadMessages(); // Refresh messages
    });

    chatInput.addEventListener('input', () => {
        clearTimeout(typingTimeout);

        fetch('/chat/set-typing.php', { method: 'POST' }).catch(console.error);

        typingTimeout = setTimeout(() => {
            fetch('/chat/stop-typing.php', { method: 'POST' }).catch(console.error);
        }, 5000);
    });

    // ✅ Load messages loop
    async function loadMessages(isInitial = false) {
        const res = await fetch('/chat/get-messages.php');
        const data = await res.json();

        const messages = Array.isArray(data.messages) ? data.messages : data;
        const isTyping = data.typing ?? false;

        // Compare message times to see if there’s a change
        const currentTimes = messages.map(m => m.time);
        const hasNewMessages = currentTimes.join() !== lastMessageTimes.join();

        if (!hasNewMessages && !isInitial) return; // ✅ Skip unnecessary DOM updates

        lastMessageTimes = currentTimes;

        const atBottom =
            chatMessages.scrollTop + chatMessages.clientHeight >= chatMessages.scrollHeight - 50;

        chatMessages.innerHTML = '';

        messages.forEach(msg => {
            const div = document.createElement('div');
            div.className = `chat-message ${msg.sender}`;

            if (msg.sender === 'admin') {
                div.innerHTML = `
                <img src="/assets/images/cari_288.png" alt="Cari" class="chat-avatar-inline" />
                <span class="chat-time">[${msg.time}]</span> ${msg.message}
            `;
            } else {
                div.innerHTML = `<span class="chat-time">[${msg.time}]</span> ${msg.message}`;
            }

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
    setInterval(() => loadMessages(false), 1000);
});
