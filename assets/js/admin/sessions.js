export async function loadSessions(sessionList, loadSessionCallback) {
    const res = await fetch('/admin/get-sessions.php');
    const data = await res.json();
  
    sessionList.innerHTML = '<strong>Sessions</strong>';
    data.forEach(s => {
      const div = document.createElement('div');
      div.className = 'session';
      div.textContent = `${s.session_id.slice(0, 8)}... (${s.last_time})`;
      div.onclick = () => loadSessionCallback(s.session_id);
      sessionList.appendChild(div);
    });
  }
  