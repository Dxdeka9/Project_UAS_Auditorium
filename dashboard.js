// document.getElementById("search").addEventListener("input", function () {
//   var searchValue = this.value;

//   // Buat URL dengan parameter search
//   var url = "index.php?search=" + encodeURIComponent(searchValue);

//   // Gunakan fetch untuk memuat ulang tabel berdasarkan pencarian
//   fetch(url)
//     .then((response) => response.text())
//     .then((data) => {
//       // Update isi tabel dengan data hasil pencarian
//       document.querySelector("#search-results tbody").innerHTML = data;
//     });
// });

document.addEventListener("DOMContentLoaded", function () {
  const hamburgerMenu = document.getElementById("hamburger-menu");
  const sidebar = document.querySelector(".custom-sidebar");

  hamburgerMenu.addEventListener("click", function () {
    sidebar.classList.toggle("active");
  });
});
