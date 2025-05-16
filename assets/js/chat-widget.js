const chatBubble = document.getElementById('chat-bubble');
const chatPanel = document.getElementById('chat-panel');

chatBubble.addEventListener('click', () => {
    chatPanel.classList.toggle('open');
  
    if (chatPanel.classList.contains('open')) {
      // Scroll to bottom once visible
      requestAnimationFrame(() => {
        requestAnimationFrame(() => {
          const lastMessage = chatMessages.lastElementChild;
          if (lastMessage) {
            lastMessage.scrollIntoView({ behavior: 'auto', block: 'end' });
          }
        });
      });
    }
  });
  