// Fungsi untuk menyimpan cookie
function setCookie(nama, value, hari = 30) {
    const date = new Date(); // membuat objek tanggal
    date.setTime(date.getTime() + hari * 24 * 60 * 60 * 1000); // menambah jumlah hari ke waktu sekarang
    const expires = "expires=" + date.toUTCString(); // konversi expired ke format UTC (gmt)
    document.cookie = `${nama}=${value}; ${expires}; path=/`; // menyimpan kuki
}

// Fungsi untuk membaca cookie
function getCookie(nama) {
    const cookies = document.cookie.split(';'); // mengambil semua kuki ke bentuk string
    for (let i = 0; i < cookies.length; i++) { // mencari kuki 
        const c = cookies[i].trim();
        if (c.indexOf(nama + "=") === 0) { // cek nama kuki yang sesuai
            return c.substring((nama + "=").length, c.length); // balikin nilai kuki
        }
    }
    return null;
}

// Fungsi untuk menghapus cookie
function deleteCookie(nama) {
    document.cookie = `${nama}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`; // mengatur kuki dengan tanggal exp 
}
