// Fungsi untuk menyimpan cookie
function setCookie(nama, value, hari = 30) { //membuat dan mengatur kuki dengan default hari = 30 
    const date = new Date(); // membuat objek tanggal
    date.setTime(date.getTime() + hari * 24 * 60 * 60 * 1000); // menambah jumlah hari ke waktu sekarang
    const expires = "expires=" + date.toUTCString(); // konversi expired ke format UTC (gmt) (Wed, 17 Jan 2024 12:00:00 GMT)
    document.cookie = `${nama}=${value}; ${expires}; path=/`; // menyimpan kuki
}

// Fungsi untuk membaca cookie
function getCookie(nama) {
    const cookies = document.cookie.split(';'); // mengambil semua kuki ke bentuk string, split digunakan untuk memisahkan 
    for (let i = 0; i < cookies.length; i++) { // mencari kuki dan memeriksa apakah nilai i masih kurang dari panjang array cookies.
        const c = cookies[i].trim(); // Mengakses elemen array cookies pada indeks i, kemudian menghapus spasi di awal dan akhir string, dan menyimpannya dalam variabel c
        if (c.indexOf(nama + "=") === 0) { // cek nama kuki yang sesuai
            return c.substring((nama + "=").length, c.length); // balikin nilai kuki, substring digunakan untuk mengambil potongan nilai string
        }
    }
    return null;
}

// Fungsi untuk menghapus cookie
function deleteCookie(nama) {
    document.cookie = `${nama}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`; // mengatur kuki dengan tanggal exp 
}
