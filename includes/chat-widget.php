<div class="chat-bubble hidden" id="chatBubble">💬 Chat now for support!</div>

<div id="chat-panel">
    <div class="chat-header">
        <img class="chat-avatar" src="/assets/images/cari_288.png" alt="World-class support with Cari">
        <div class="chat-agent-info">
            <strong>Cari – Support</strong>
            <span class="chat-status">Typically replies in under 15 minutes</span>
        </div>
        <!--  <div class="chat-expand-icon">⤢</div> optional full screen icon -->
    </div>
    <div class="chat-wrapper">
        <div id="chatMessages"></div>
        <form class="chat-input" id="chatForm">
            <input type="text" />
            <button type="submit">Send</button>
        </form>
    </div>
    <!-- User Name Prompt Modal -->
    <div id="chatNameModal" class="chat-name-modal hidden">
        <div class="chat-name-content">
            <h3>Welcome!</h3>
            <p>Please enter your name to start the chat:</p>
            <input type="text" id="chatUserName" placeholder="Your name" />
            <button id="chatNameSubmit">Start Chat</button>
        </div>
    </div>

</div>