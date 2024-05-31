document.getElementById('send-button').addEventListener('click', function() {
    const messageInput = document.getElementById('message-input');
    const message = messageInput.value;
    const chatId = new URLSearchParams(window.location.search).get('id');
    const username = 'current_username'; // Replace with the actual username of the logged-in user

    if (message.trim() !== '') {
        fetch('../php/send_message.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ chatId: chatId, username: username, message: message })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Add the message to the chat container
                const chatMessages = document.getElementById('chat-messages');
                const messageElement = document.createElement('div');
                messageElement.classList.add('chat-message');
                messageElement.textContent = `${username}: ${message}`;
                chatMessages.appendChild(messageElement);

                // Clear the input field
                messageInput.value = '';
            } else {
                console.error('Error sending message:', data.error);
            }
        })
        .catch(error => console.error('Error sending message:', error));
    }
});
