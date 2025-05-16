export async function loadSession(sessionId, chatMessages) {
    const res = await fetch(`/admin/get-session.php?session=${sessionId}`);
    const data = await res.json();
    
    const messages = data.messages || [];
    const typing = data.typing || false;
    
    chatMessages.innerHTML = '';
    messages.forEach(msg => {
        const div = document.createElement('div');
        div.className = `chat-message ${msg.sender}`;
        div.innerHTML = `<span class="chat-time">[${msg.time}]</span> ${msg.message}`;
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

    chatMessages.scrollTop = chatMessages.scrollHeight;
}
