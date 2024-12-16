<?php
    session_start(); // untuk mengakses data sesi
    session_destroy(); // untuk menghapus sesi yang tersimpan
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie logout</title>
</head>
<body>
    <script src="cookie.js"></script>
    <script>
        deleteCookie('user_email'); //untuk menghapus cookie dengan nama user_email
        deleteCookie('user_id'); //untuk menghapus cookie dengan nama user_id
        window.location = 'index.php'; // redirect ke halaman index
    </script>
</body>
</html>