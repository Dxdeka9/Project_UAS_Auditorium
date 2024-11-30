let slideIndex = 0;
showSlides();

function showSlides() {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none"; /* Pastikan slide lainnya disembunyikan */
    }
    slideIndex++;
    if (slideIndex > slides.length) { slideIndex = 1; }
    slides[slideIndex - 1].style.display = "block"; /* Menampilkan slide saat ini */
    setTimeout(showSlides, 3000); /* Ganti gambar setiap 3 detik */
}
