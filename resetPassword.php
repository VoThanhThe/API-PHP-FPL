
<?php
//url: http://127.0.0.1:3456/resetPassword.php?email=vothanhthepct2020@gmail.com&token=9d6e8e719467cccdf09b80ece644c7bd
include_once("./database/connection.php");
//GET
if (!isset($_POST['submit'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];
    //kiểm tra email và token có tồn tại hay k
    if (empty($email) || empty($token)) {
        echo "email và token có tồn tại hay k";
        header('Location: 404.php');
        exit();
    }
    // kiểm tra token có hợp lệ hay k
    $result = $dbConn->query("SELECT id from 
    reset_password where email = '$email' 
    and token = '$token' 
    and  createdAt >= DATE_SUB(NOW(), INTERVAL 1 HOUR) 
    and avaiable =1 ");
    $user = $result->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        echo "token có hợp lệ hay k";
        header('Location: 404.php');
        exit();
    }
}
//POST
else {
    try {
        //đọc dữ liệu từ form
        $email = $_POST['email'];
        $token = $_POST['token'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password != $confirm_password) {
            echo "Mật khẩu không khớp";
            header('Location: 404.php');
            exit();
        }
        // kiểm tra token có hợp lệ hay không
        $result = $dbConn->query("select id from 
                            reset_password where email = '$email' 
                            and token = '$token' 
                            and  createdAt >= DATE_SUB(NOW(), INTERVAL 1 HOUR) 
                            and avaiable =1 ");
        $user = $result->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            echo "Token không hợp lệ";
            header('Location: 404.php');
            exit();
        }

        //cập nhật mật khẩu mới
        $password = password_hash($password, PASSWORD_BCRYPT);
        $dbConn->query("update users set
                        password = '$password'
                        where email = '$email' ");

        //hủy token
        $dbConn->query("update reset_password set 
                        avaiable = 0 
                        where email = '$email' 
                        and token = '$token' ");

        header('Location: login.php');
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}



?>




<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="bg-image" style="background-image: url('https://mdbootstrap.com/img/Photos/Others/images/76.jpg');
            height: 100vh">
        <div style="display: flex; justify-content: center; align-items: center; ">
            <form action="resetPassword.php" method="post" style="width: 300px; padding: 20px; background-color: rgba(0, 0, 0, 0.5); border-radius: 20px; margin-top: 150px; ">
                <h2 style="color: white; text-align: center; text-transform: capitalize;">Password Reset</h2>
                <h6 class="card-text py-2" style="color: white; text-align: center;">
                    Enter your email address and we'll send you an email with instructions to reset your password.
                </h6>
                <div class="mb-3 mt-3">
                    <input type="password" class="form-control" id="email" name="password" placeholder="Mật khẩu mới">
                    <input type="password" style = "margin-top: 10px" class="form-control" id="email" name="confirm_password" placeholder="Nhập lại mật khẩu mới">
                    <input type="hidden" class="form-control" id="email" name="email" value="<?php echo $_GET['email'] ?>">
                    <input type="hidden" class="form-control" id="email" name="token" value="<?php echo $_GET['token'] ?>">
                </div>
                <button type="submit" name="submit" class="btn btn-primary" style="width: 100%;">Reset password</button>
            </form>
        </div>

    </div>
</body>

</html>