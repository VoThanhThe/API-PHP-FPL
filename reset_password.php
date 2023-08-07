<?php
// url: http://127.0.0.1:3456/reset_password.php?email=channn3@fpt.edu.vn&token=682060aee5efa79252c4dd523378be75
include_once("./database/connection.php");
// GET
if (!isset($_POST['submit'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];
    // kiểm tra email và token có tồn tại hay không
    if (empty($email) || empty($token)) {
        header("Location: 404.php");
        exit();
    }
    // kiểm tra token có hợp lệ hay không
    $result = $dbConn->query(" select id from 
                        reset_password where email = '$email' 
                        and token = '$token' 
                        and createdAt >= DATE_SUB(NOW(), INTERVAL 1 HOUR) 
                        and avaiable = 1  ");
    $user = $result->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        header("Location: 404.php");
        exit();
    }
    // hiển thị form đổi mật khẩu
}
// POST
else {
    try {
        // đọc dữ liệu từ form
        $email = $_POST['email'];
        $token = $_POST['token'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        if ($password != $confirm_password) {
            echo "Mật khẩu không khớp";
            header("Location: 404.php");
            exit();
        }
        // kiểm tra token có hợp lệ hay không
        $result = $dbConn->query(" select id from 
                        reset_password where email = '$email' 
                        and token = '$token' 
                        and createdAt >= DATE_SUB(NOW(), INTERVAL 1 HOUR) 
                        and avaiable = 1  ");
        $user = $result->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            echo "Token không hợp lệ";
            header("Location: 404.php");
            exit();
        }
        // cập nhật mật khẩu mới
        $password = password_hash($password, PASSWORD_BCRYPT);
        $dbConn->query(" update users set 
                    password = '$password' 
                    where email = '$email' ");
        // hủy token
        $dbConn->query(" update reset_password set 
                    avaiable = 0 
                    where email = '$email'
                    and token = '$token' ");
        header("Location: login.php");
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khôi phục mật khẩu</title>
</head>

<body>
    <form action="reset_password.php" method="post">
        <input type="password" name="password" placeholder="Mật khẩu mới">
        <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu mới">
        <input type="hidden" name="email" value="<?php echo $_GET['email'] ?>">
        <input type="hidden" name="token" value="<?php echo $_GET['token'] ?>">
        <button type="submit" name="submit">Khôi phục</button>
    </form>
</body>

</html>