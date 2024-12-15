let slideIndex = 0;
const slides = document.querySelectorAll(".mySlides");

function showSlides() {
    // Remove active class from all slides
    slides.forEach((slide) => slide.classList.remove("active"));

    // Add active class to the current slide
    slides[slideIndex].classList.add("active");

    // Increment slide index and reset if at the end
    slideIndex = (slideIndex + 1) % slides.length;

    // Change slide every 5 seconds
    setTimeout(showSlides, 3000);
}

// Start the slideshow
showSlides();


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
