let slideIndex = 0;
// Variabel slideIndex digunakan untuk menyimpan indeks slide yang aktif saat ini.
// Dimulai dari indeks 0 (slide pertama).

const slides = document.querySelectorAll(".mySlides");
// slides menyimpan semua elemen dengan kelas .mySlides.
// querySelectorAll akan mengambil semua elemen tersebut dalam bentuk NodeList.

function showSlides() {
  // Hapus kelas 'active' dari semua slide
  slides.forEach((slide) => slide.classList.remove("active"));

  // Tambahkan kelas 'active' ke slide yang sesuai dengan slideIndex
  slides[slideIndex].classList.add("active");

  // Tingkatkan nilai slideIndex ke slide berikutnya.
  // Jika sudah mencapai slide terakhir, kembalikan ke indeks 0 (loop).
  slideIndex = (slideIndex + 1) % slides.length;

  // Panggil kembali fungsi showSlides setiap 3 detik
  setTimeout(showSlides, 3000);
}

// Mulai slideshow dengan memanggil fungsi showSlides
showSlides();

