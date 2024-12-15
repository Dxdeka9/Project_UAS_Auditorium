// Tambahkan event listener pada tombol submit
document
  .querySelector(".btn-primary")
  .addEventListener("click", function (event) {
    // Tampilkan dialog konfirmasi
    if (
      !confirm(
        "Apakah data yang diisi sudah benar? Form tidak bisa di edit setelah ini."
      )
    ) {
      // Jika user membatalkan, maka event submit akan dicegah
      event.preventDefault();
    }
  });
