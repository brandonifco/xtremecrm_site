import { loadSessions } from './sessions.js';
import { loadSession } from './messages.js';
import { sendAdminMessage } from './send.js';

const sessionList = document.getElementById('sessionList');
const chatMessages = document.getElementById('chatMessages');
const chatForm = document.getElementById('chatForm');
const chatInput = document.getElementById('chatInput');

let activeSessionId = null;

chatForm.addEventListener('submit', async (e) => {
  e.preventDefault();
  const success = await sendAdminMessage(activeSessionId, chatInput.value);
  if (success) {
    chatInput.value = '';
    loadSession(activeSessionId, chatMessages);
  }
});

setInterval(() => {
  if (activeSessionId) {
    loadSession(activeSessionId, chatMessages);
  }
}, 3000);

loadSessions(sessionList, (sessionId) => {
  activeSessionId = sessionId;
  loadSession(sessionId, chatMessages);
});
