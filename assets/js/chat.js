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

        // Immediately notify server that user is typing
        fetch('/chat/set-typing.php', {
            method: 'POST'
        }).catch(err => {
            console.error('Typing indicator error:', err);
        });

        // Reset after 5 seconds of inactivity
        typingTimeout = setTimeout(() => {
            fetch('/chat/stop-typing.php', {
                method: 'POST'
            }).catch(err => {
                console.error('Stop typing error:', err);
            });
        }, 5000);

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
        await fetch('/chat/stop-typing.php', { method: 'POST' });
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

    setInterval(() => {
        loadMessages(false);
    }, 1000);

    (async () => {
        try {
            const checkName = await fetch('/chat/check-name.php');
            const checkResult = await checkName.json();

            if (!checkResult.name) {
                document.getElementById('chatNameModal').classList.remove('hidden');
            }
        } catch (err) {
            console.error('Name check failed:', err);
        }
    })();
    // 👇 Name submit handler
    document.getElementById('chatNameSubmit').addEventListener('click', async () => {
        const name = document.getElementById('chatUserName').value.trim();
        if (!name) {
            alert('Please enter your name.');
            return;
        }

        try {
            const res = await fetch('/chat/set-name.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ name })
            });

            const data = await res.json();

            if (data.success) {
                document.getElementById('chatNameModal').classList.add('hidden');
                console.log('Name saved. Chat can start.');
            } else {
                alert('Failed to set name.');
            }
        } catch (err) {
            console.error('Set name error:', err);
            alert('Something went wrong.');
        }
    });


});
