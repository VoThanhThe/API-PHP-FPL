
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../database/connection.php");

use PHPMailer\PHPMailer\PHPMailer;
//password: oejsnyptiwdkrraf
//uri: http://127.0.0.1:3456/api/register.php
include_once $_SERVER['DOCUMENT_ROOT'] . '/utilities/PHPMailer-master/src/PHPMailer.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/utilities/PHPMailer-master/src/SMTP.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/utilities/PHPMailer-master/src/Exception.php';

try {
    $body = json_decode(file_get_contents("php://input"));

    $email = $body->email;
    $password = $body->password;
    $name = $body->name;

    if (empty($email) || empty($password) || empty($name)) {
        echo json_encode(array(
            "status" => false,
            "message"=>"Vui lòng nhập đầy đủ thông tin"
        ));
        return;
    }

    //kiem tra email co hay k

    $user = $dbConn->query("SELECT id, email, password
                    FROM users where email = '$email'");

    if ($user->rowCount() > 0) {

        echo json_encode(array(
            "status" => false,
            "message"=>"Email đã tồn tại"
        ));
        return;

    } else {
        //mã hóa password
        $password = password_hash($password, PASSWORD_BCRYPT);
        $dbConn->query("INSERT INTO users (email, password, name) 
        VALUES ('$email', '$password', '$name')");
        echo json_encode(array(
            "status" => true,
        ));
        $token = md5(time().$email);
        //gửi email có link reset mật khẩu
    $link = "<a href='http://127.0.0.1:3456/verified.php?email="
    . $email . "&token=" . $token . "'>Nhấn vào đây để xác thực tài khoản</a>";
    $mail = new PHPMailer();
    $mail->CharSet = "utf-8";
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Username = "vothanhthepct2020";
    $mail->Password = "kunnlcokbzgpswxz";
    $mail->SMTPSecure = "ssl";
    $mail->Host = "ssl://smtp.gmail.com";
    $mail->Port = "465";
    $mail->From = "vothanhthepct2020@gmail.com";
    $mail->FromName = "Võ Thành Thế";
    $mail->addAddress($email, 'Hello');
    $mail->Subject = "Xác thực tài khoản";
    $mail->isHTML(true);
    $mail->Body = "Click on this link to email verification " . $link . " ";
    $res = $mail->Send();

    if($res){
        echo json_encode(array(
            "status" => true,
            "message" => "Email sent successfully"
        ));
    }else{
        echo json_encode(array(
            "status" => false,
            "message" => "Email not sent"
        ));
    }
    }
} catch (Exception $e) {
    echo json_encode(array(
        "status" => false,
        "message"=> $e->getMessage()
    ));
}
