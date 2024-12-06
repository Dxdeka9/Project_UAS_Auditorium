let debounceTimeout;

document.getElementById('search').addEventListener('input', function () {
    clearTimeout(debounceTimeout); // Hapus timeout yang sedang berjalan
    const searchValue = this.value;

    // Tetapkan timeout baru (misalnya 500ms)
    debounceTimeout = setTimeout(() => {
        const url = new URL(window.location.href);
        url.searchParams.set('search', searchValue);
        window.location.href = url; // Redirect setelah penundaan
    }, 1000); // Tunggu 500ms setelah pengguna berhenti mengetik
});
