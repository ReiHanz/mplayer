// Script to handle music player, add to favorites, and admin delete functionality

// Get all audio elements
const audioPlayers = document.querySelectorAll('.audio-player');

// Add event listeners to each audio player
audioPlayers.forEach(audio => {
    audio.addEventListener('play', function() {
        // Pause all other audio players
        audioPlayers.forEach(otherAudio => {
            if (otherAudio !== audio) {
                otherAudio.pause();
                otherAudio.currentTime = 0; // Reset the other audio to the start
            }
        });
    });
});

// Add to favorites dynamically
const favoriteButtons = document.querySelectorAll('button[name="favorite"]');

favoriteButtons.forEach(button => {
    button.addEventListener('click', (e) => {
        e.preventDefault();
        const musicId = button.previousElementSibling.value;

        fetch('../config/music.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `favorite=true&music_id=${musicId}`
        })
        .then(response => response.text())
        .then(data => {
            alert('Added to favorites!');
            // Optionally, update favorite list dynamically
        })
        .catch(error => console.error('Error:', error));
    });
});

// Confirm before deleting music (for admins)
const deleteButtons = document.querySelectorAll('button[name="delete"]');

deleteButtons.forEach(button => {
    button.addEventListener('click', (e) => {
        e.preventDefault();
        const confirmed = confirm('Are you sure you want to delete this music?');

        if (confirmed) {
            const musicId = button.previousElementSibling.value;

            fetch('../config/music.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `delete=true&music_id=${musicId}`
            })
            .then(response => response.text())
            .then(data => {
                alert('Music deleted successfully!');
                button.closest('div').remove(); // Remove music from DOM
            })
            .catch(error => console.error('Error:', error));
        }
    });
});

// LiveChat
const chatForm = document.getElementById('chat-form');
const chatMessages = document.getElementById('chat-messages');
const chatInput = document.getElementById('chat-input');

// Fungsi untuk menambah pesan ke chat box
// Fungsi untuk menambah pesan ke chat box
function addMessage(sender, message, isUser = false) {
    const messageElement = document.createElement('div');
    messageElement.classList.add('chat-message');
    messageElement.classList.add(isUser ? 'user' : 'bot'); // Tambahkan class user/bot
    messageElement.textContent = sender + ": " + message;
    document.getElementById('chat-messages').appendChild(messageElement);
    document.getElementById('chat-messages').scrollTop = document.getElementById('chat-messages').scrollHeight;
}

// Fungsi untuk mengambil pesan dari server
async function fetchMessages() {
    const response = await fetch('get_messages.php');
    const messages = await response.json();
    
    document.getElementById('chat-messages').innerHTML = ''; // Bersihkan chat messages

    messages.forEach(msg => {
        addMessage(msg.username, msg.message, msg.username === "YourUsername"); // Ubah "YourUsername" sesuai nama pengguna
    });
}

// Kirim pesan ke server
document.getElementById('chat-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const message = document.getElementById('chat-input').value.trim();
    
    if (message !== "") {
        // Kirim pesan ke server
        await fetch('send_message.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ message: message })
        });

        document.getElementById('chat-input').value = ''; // Bersihkan input
        fetchMessages(); // Perbarui chat
    }
});

// Panggil fetchMessages secara berkala untuk simulasi polling
setInterval(fetchMessages, 2000); // Poll setiap 2 detik

// Pencarian Music
// Event listener untuk pencarian musik
document.getElementById("search-input").addEventListener("input", function () {
    const searchValue = this.value;

    if (searchValue.trim() !== "") {
        // Menggunakan AJAX untuk permintaan pencarian
        $.ajax({
            url: "search_music.php",
            type: "GET",
            data: { query: searchValue },
            dataType: "json",
            success: function (data) {
                const musicList = document.getElementById("music-list");
                musicList.innerHTML = ""; // Kosongkan daftar musik saat ini

                // Tampilkan hasil pencarian
                data.forEach(music => {
                    const musicItem = document.createElement("div");
                    musicItem.classList.add("music-item");
                    musicItem.innerHTML = `
                        <h4 class="music-title">${music.title}</h4>
                        <audio controls class="audio-player">
                            <source src="${music.file_path}" type="audio/mpeg">
                        </audio>
                        <form action="music.php" method="POST">
                            <input type="hidden" name="music_id" value="${music.id}">
                            <button type="submit" name="favorite">Favorites</button>
                            <?php if ($_SESSION['role'] == 'admin'): ?>
                                <button type="submit" name="delete">Delete</button>
                            <?php endif; ?>
                        </form>
                    `;
                    musicList.appendChild(musicItem);
                });
            },
            error: function (xhr, status, error) {
                console.error("Error: " + error);
            }
        });
    } else {
        // Kosongkan hasil jika input pencarian kosong
        document.getElementById("music-list").innerHTML = "<p>Enter a search term to see results.</p>";
    }
});

