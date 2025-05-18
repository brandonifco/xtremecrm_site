import { loadSessions } from './sessions.js';
import { loadSession } from './messages.js';
import { sendAdminMessage } from './send.js';

const sessionList = document.getElementById('sessionList');
const chatMessages = document.getElementById('chatMessages');
const chatForm = document.getElementById('chatForm');
const chatInput = document.getElementById('chatInput');
const sessionLastSeenMap = {};  // session_id => last_time

let activeSessionId = null;

chatForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const message = chatInput.value.trim();
    if (!message || !activeSessionId) return;

    const success = await sendAdminMessage(activeSessionId, message);
    if (success) {
        chatInput.value = '';
        loadSession(activeSessionId, chatMessages, true);
    } else {
        console.error('Failed to send admin message');
    }
});

setInterval(() => {
    if (activeSessionId) {
        loadSession(activeSessionId, chatMessages, false); // stops scroll during polling
    }
}, 3000);

function refreshSessions() {
    loadSessions(sessionList, (sessionId, shouldScroll = true) => {
        activeSessionId = sessionId;
        window.activeSessionId = sessionId; // ensures sessions.js can check active
        loadSession(sessionId, chatMessages, shouldScroll);
    });
}


chatMessages.addEventListener('scroll', () => {
    const isAtBottom =
        chatMessages.scrollTop + chatMessages.clientHeight >= chatMessages.scrollHeight - 50;

    const alertBanner = document.getElementById('newMessageAlert');

    if (isAtBottom && activeSessionId) {
        const sessionElement = document.querySelector(`.session[data-session-id="${activeSessionId}"]`);
        if (sessionElement) {
            sessionElement.classList.remove('pulse');
        }

        if (alertBanner) {
            alertBanner.classList.add('hidden');
        }
    }
});

refreshSessions();

// 🔁 Refresh session list every 10 seconds to trigger pulse on inactive sessions
setInterval(() => {
    refreshSessions();
}, 10000); // Adjust interval (ms) as needed
