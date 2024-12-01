function setCookie(nama, value, hari = 30){ // menyimpan cookie
    const date = new Date();
    date.setTime(date.getTime() + ( hari*24*60*60*1000));
    const expires = "expires=" + date.toUTCString();
    document.cookie = `${nama}=${value}; ${expires}; path=/`;
}

// membaca cookie
function getCookie(nama) {
    const cookies = document.cookie.split(';');
    for (let i = 0; i<cookies.length; i++){
        const c = cookies[i].trim();
        if (c.indexOf(nama + "=") === 0){
            return c.substring((nama + "=").length, c.length);
        }
    }
    return null;
}
// menghapus cookie
function deleteCookie(nama) {
    document.cookie = `${nama}=; expires=Sun, 01 Dec 2024 00:00:00 UTC; path=/;`;
}
