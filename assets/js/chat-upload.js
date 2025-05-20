document.addEventListener('DOMContentLoaded', () => {
    const uploadBtn = document.getElementById('uploadTriggerBtn');
    const fileInput = document.getElementById('fileInput');

    if (!uploadBtn || !fileInput) return;

    uploadBtn.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', async () => {
        const file = fileInput.files[0];
        if (!file) return;

        const name = sessionStorage.getItem('chat_name');
        if (!name) {
            alert('Please enter your name first.');
            return;
        }

        const formData = new FormData();
        formData.append('file', file);
        formData.append('chat_name', name);

        try {
            const res = await fetch('/chat/upload-file.php', {
                method: 'POST',
                body: formData
            });

            const result = await res.json();
            if (result.success) {
                // Post a confirmation message to the chat
                await fetch('/chat/send-message.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        name: name,
                        message: `*File Uploaded.* ${file.name}`
                    })
                });

                // Refresh messages in chat panel
                await fetch('/chat/stop-typing.php', { method: 'POST' });
                await loadMessages();

            } else {
                alert('Upload failed: ' + (result.error || 'Unknown error.'));
            }
        } catch (err) {
            console.error(err);
            alert('Upload error: ' + err.message);
        }

        fileInput.value = ''; // Reset input
    });
});
