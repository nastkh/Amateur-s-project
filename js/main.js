document.addEventListener('DOMContentLoaded', function() {
    fetch('../php/get_chats.php')
        .then(response => response.json())
        .then(data => {
            const chatContainer = document.querySelector('.chat-container');
            chatContainer.innerHTML = '';

            data.forEach(chat => {
                const chatElement = document.createElement('div');
                chatElement.classList.add('chat');
                
                chatElement.innerHTML = `
                    <a href="chat_description.html?id=${chat.id}">
                        <img src="${chat.image_url}" alt="Фото чату">
                        <h3 class="chat-title">${chat.title}</h3>
                    </a>
                `;

                chatContainer.appendChild(chatElement);
            });
        })
        .catch(error => console.error('Error loading chats:', error));
});
