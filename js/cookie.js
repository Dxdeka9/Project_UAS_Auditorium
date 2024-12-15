// Fungsi untuk menyimpan cookie
function setCookie(nama, value, hari = 30) {
    const date = new Date();
    date.setTime(date.getTime() + hari * 24 * 60 * 60 * 1000);
    const expires = "expires=" + date.toUTCString();
    document.cookie = `${nama}=${value}; ${expires}; path=/`;
}

// Fungsi untuk membaca cookie
function getCookie(nama) {
    const cookies = document.cookie.split(';');
    for (let i = 0; i < cookies.length; i++) {
        const c = cookies[i].trim();
        if (c.indexOf(nama + "=") === 0) {
            return c.substring((nama + "=").length, c.length);
        }
    }
    return null;
}

// Fungsi untuk menghapus cookie
function deleteCookie(nama) {
    document.cookie = `${nama}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
}
