let slideIndex = 0;
showSlides();

function showSlides() {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) { slideIndex = 1 }
    slides[slideIndex - 1].style.display = "block";
    setTimeout(showSlides, 3000); // Change image every 3 seconds
}

/* ini code buat jaga-jaga klo slideshow register.css ngawur
let slideIndex = 0;
const slides = document.querySelectorAll(".mySlides");

function showSlides() {
  slides.forEach((slide, index) => {
    slide.classList.remove("active");
  });
  
  slides[slideIndex].classList.add("active");
  slideIndex = (slideIndex + 1) % slides.length;

  setTimeout(showSlides, 3000); // Ubah slide setiap 3 detik
}

showSlides();
*/
