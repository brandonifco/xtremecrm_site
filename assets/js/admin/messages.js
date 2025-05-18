export async function loadSession(sessionId, chatMessages, shouldScroll = false) {
    const res = await fetch(`/admin/get-session.php?session=${sessionId}`);
    const data = await res.json();
    const lastMessage = chatMessages.lastElementChild;
    const messages = data.messages || [];
    const typing = data.typing || false;

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
    // Remove existing typing indicator
    const oldTyping = chatMessages.querySelector('.typing-indicator');
    if (oldTyping) oldTyping.remove();

    // Show typing if flagged
    if (data.typing) {
        const typingEl = document.createElement('div');
        typingEl.className = 'typing-indicator';
        typingEl.textContent = 'User is typing...';
        chatMessages.appendChild(typingEl);
    }

    if (shouldScroll) {
        const lastMessage = chatMessages.lastElementChild;
        if (lastMessage) {
            lastMessage.scrollIntoView({ behavior: 'auto', block: 'end' });
        }
    }
    if (!shouldScroll) {
        const isAtBottom = chatMessages.scrollTop + chatMessages.clientHeight >= chatMessages.scrollHeight - 50;
        const hasUserMessage = messages.some(msg => msg.sender === 'user');
        const alertBanner = document.getElementById('newMessageAlert');

        if (!isAtBottom && hasUserMessage) {
            const sessionElement = document.querySelector(`.session[data-session-id="${sessionId}"]`);
            if (sessionElement) {
                sessionElement.classList.add('pulse');
            }

            if (alertBanner) {
                alertBanner.classList.remove('hidden'); // ✅ show alert
            }
        } else {
            // ✅ hide alert if user scrolled or no new messages
            if (alertBanner) {
                alertBanner.classList.add('hidden');
            }
        }
    }


}
