document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const chatId = urlParams.get('id');

    if (!chatId) {
        console.error('Chat ID is missing in the URL');
        return;
    }

    fetch(`../php/get_chat_details.php?id=${chatId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(chat => {
            if (chat.error) {
                console.error('Error loading chat details:', chat.error);
                return;
            }
            const chatDetails = document.getElementById('chat-details');

            chatDetails.innerHTML = `
                <img src="${chat.image_url}" alt="Фото чату">
                <div class="chat-info">
                    <h1>${chat.title}</h1>
                    <p>${chat.description}</p>
                    <button id="join-button" class="join-button">Приєднатися</button>
                </div>
            `;

            document.getElementById('join-button').addEventListener('click', function() {
                window.location.href = `chat.html?id=${chat.id}`;
            });
        })
        .catch(error => console.error('Error loading chat details:', error));
});
