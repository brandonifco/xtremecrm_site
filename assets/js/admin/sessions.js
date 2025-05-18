// Load from localStorage or initialize empty
const sessionLastSeenMap = JSON.parse(localStorage.getItem('sessionLastSeenMap') || '{}');

export async function loadSessions(sessionList, loadSessionCallback) {
    try {
        const res = await fetch('/admin/get-sessions.php');

        if (!res.ok) {
            throw new Error(`HTTP ${res.status}`);
        }

        const json = await res.json();
        const sessions = json.sessions || [];

        sessionList.innerHTML = '<strong>Sessions</strong>';

        if (sessions.length === 0) {
            const emptyMessage = document.createElement('p');
            emptyMessage.textContent = 'No active sessions.';
            sessionList.appendChild(emptyMessage);
            return;
        }

        sessions.forEach(s => {
            const div = document.createElement('div');
            div.className = 'session';
            div.dataset.sessionId = s.session_id;
            div.textContent = `${s.session_id.slice(0, 8)}... (${s.last_time})`;

            // Previous state
            const state = sessionLastSeenMap[s.session_id] || {
                last_time: '',
                hasNewMessage: false
            };

            const isNewMessage = state.last_time && s.last_time > state.last_time;
            const isActive = s.session_id === window.activeSessionId;

            if (isNewMessage && !isActive) {
                state.hasNewMessage = true;
            }

            // ✅ Set last_time AFTER checking
            state.last_time = s.last_time;

            sessionLastSeenMap[s.session_id] = state;

            if (state.hasNewMessage && !isActive) {
                div.classList.add('pulse');
            }

            div.onclick = () => {
                div.classList.remove('pulse');
                sessionLastSeenMap[s.session_id].hasNewMessage = false;

                // ✅ Persist to localStorage
                localStorage.setItem('sessionLastSeenMap', JSON.stringify(sessionLastSeenMap));

                loadSessionCallback(s.session_id, true);
            };

            sessionList.appendChild(div);
        });

    } catch (err) {
        console.error('Failed to load sessions:', err);
        sessionList.innerHTML = '<p>Error loading sessions.</p>';
    }

    localStorage.setItem('sessionLastSeenMap', JSON.stringify(sessionLastSeenMap));
}
