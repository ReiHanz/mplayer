<h2>Music List</h2>
<input type="text" id="search-input" placeholder="Search for music...">
<div id="music-list">
    <!-- Daftar musik akan ditampilkan di sini -->
</div>
<script>
    let allMusic = []; // Array untuk menyimpan semua musik

// Fungsi untuk mengambil data musik dari server saat halaman pertama kali dimuat
function fetchMusic() {
    fetch("music_list.php")
        .then(response => response.json())
        .then(data => {
            allMusic = data; // Simpan data musik ke variabel global
            displayMusic(allMusic); // Tampilkan seluruh daftar musik
        })
        .catch(error => console.error("Error fetching music list:", error));
}

// Fungsi untuk menampilkan daftar musik
function displayMusic(musicList) {
    const musicListContainer = document.getElementById("music-list");
    musicListContainer.innerHTML = ""; // Bersihkan daftar yang ada

    musicList.forEach(music => {
        const musicItem = document.createElement("div");
        musicItem.classList.add("music-item");
        musicItem.innerHTML = `
            <h4 class="music-title">${music.title}</h4>
            <audio controls class="audio-player">
                <source src="${music.file_path}" type="audio/mpeg">
            </audio>
            <form action="music_.php" method="POST">
                <input type="hidden" name="music_id" value="${music.id}">
                <button type="submit" name="favorite">Favorites</button>
                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <button type="submit" name="delete">Delete</button>
                <?php endif; ?>
            </form>
        `;
        musicListContainer.appendChild(musicItem);
    });
}

// Fungsi untuk memfilter daftar musik berdasarkan pencarian
document.getElementById("search-input").addEventListener("input", function () {
    const searchValue = this.value.toLowerCase();
    const filteredMusic = allMusic.filter(music => 
        music.title.toLowerCase().includes(searchValue)
    );
    displayMusic(filteredMusic); // Tampilkan daftar musik yang sudah difilter
});

// Panggil fetchMusic saat halaman pertama kali dimuat
fetchMusic();



</script>