<?php

include_once("./database/connection.php");

try {
    //cập nhật users
    $email = $_GET['email'];
    $token = $_GET['token'];
    //kiểm tra email, token
    if (empty($email) || empty($token)) {
        throw new Exception("Email hoặc token không tồn tại");
    }
    //kiểm tra email có tồn tại hay k
    $user = $dbConn->query("select id from users where email = '$email'");

    if ($user->rowCount() == 0) {
        throw new Exception("Email không tồn tại");
    }
    //xác thực tài khoản
    $dbConn->query("update users set
                verified = 1
                where email = '$email' ");
    //chuyển về trang login
} catch (Exception $e) {
    header("Location: 404.php");
};
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>200</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="container">
    <h1>Tài khoản đã xác thực</h1>
</body>

</html>