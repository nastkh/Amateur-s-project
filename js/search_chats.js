document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const searchButton = document.getElementById('search-button');
    const chatContainer = document.querySelector('.chat-container');

    searchButton.addEventListener('click', function() {
        const query = searchInput.value;
        fetch(`../php/search_chats.php?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                chatContainer.innerHTML = '';

                if (data.error) {
                    console.error('Error:', data.error);
                    return;
                }

                if (data.length === 0) {
                    chatContainer.innerHTML = '<p>No chats found</p>';
                    return;
                }

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
});
