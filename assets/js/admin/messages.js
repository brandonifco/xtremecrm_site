const lastMessageTimesMap = {}; // sessionId => [time strings]

export async function loadSession(sessionId, chatMessages, shouldScroll = false) {
    const res = await fetch(`/admin/get-session.php?session=${sessionId}`);
    const data = await res.json();
    const lastMessage = chatMessages.lastElementChild;
    const messages = data.messages || [];
    const currentTimes = messages.map(m => m.time);
    const lastTimes = lastMessageTimesMap[sessionId] || [];
    const hasNewMessages = currentTimes.join() !== lastTimes.join();

    if (!hasNewMessages && !shouldScroll) {
        return; // ✅ Skip refresh if nothing changed
    }

    // Update the tracking map
    lastMessageTimesMap[sessionId] = currentTimes;

    const typing = data.typing || false;

    chatMessages.innerHTML = '';
    messages.forEach(msg => {
        const div = document.createElement('div');
        div.className = `chat-message ${msg.sender}`;
        if (msg.sender === 'admin') {
            div.innerHTML = `
                <span class="chat-time">[${msg.time}]</span><img src="/assets/images/cari_288.png" alt="Cari" class="chat-avatar-inline" /> ${msg.message}`;
        } else {
            const displayName = msg.name || 'User';
            if (msg.message.includes('File Uploaded.')) {
                const displayName = msg.name || 'User';
                const rawFilePart = msg.message.split('File Uploaded.')[1] || '';
                const filePart = rawFilePart.replace(/^\*+/, '').trim(); // Remove leading asterisks
                const date = new Date().toISOString().slice(0, 10);
                const userSlug = displayName.replace(/\s+/g, '_');
                const safeFilename = encodeURIComponent(filePart);
                const filePath = `/uploads/${userSlug}_${date}/${safeFilename}`;

                div.innerHTML = `
                                <span class="chat-time">[${msg.time}]</span>
                                <strong>${displayName}:</strong>
                                <em>uploaded a file:</em>
                                <a href="${filePath}" target="_blank">📎 ${filePart}</a>`;
            } else {
                div.innerHTML = `
                                <span class="chat-time">[${msg.time}]</span>
                                <strong>${displayName}:</strong> ${msg.message}`;
            }
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
        chatMessages.scrollTop = chatMessages.scrollHeight;
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
