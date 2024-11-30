// Search functionality for room names
document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.querySelector('input[type="text"]');
  const roomCards = document.querySelectorAll(".card");

  searchInput.addEventListener("input", function () {
    const searchValue = searchInput.value.toLowerCase();
    roomCards.forEach((card) => {
      const roomName = card.querySelector("h5").textContent.toLowerCase();
      if (roomName.includes(searchValue)) {
        card.parentElement.style.display = "block";
      } else {
        card.parentElement.style.display = "none";
      }
    });
  });
});
