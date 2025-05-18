export async function sendAdminMessage(sessionId, message) {
    if (!sessionId || !message.trim()) return false;

    const res = await fetch('/admin/send-message.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            session_id: sessionId,       
            message: message.trim()    
        })
    });

    const result = await res.json();
    return result.success;
}
