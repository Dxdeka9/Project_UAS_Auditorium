<?php
    session_start();
    session_destroy();
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
        deleteCookie('user_email');
        deleteCookie('user_id');
        alert('Kamu berhasil logout.');
        window.location='index.php';
    </script>
</body>
</html> 
