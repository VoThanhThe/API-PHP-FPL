//kunnlcokbzgpswxz
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../database/connection.php");

use PHPMailer\PHPMailer\PHPMailer;
//uri: http://127.0.0.1:3456/api/forgotPassword.php
include_once $_SERVER['DOCUMENT_ROOT'] . '/utilities/PHPMailer-master/src/PHPMailer.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/utilities/PHPMailer-master/src/SMTP.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/utilities/PHPMailer-master/src/Exception.php';

try{
    //lấy email từ body
    $data = json_decode(file_get_contents("php://input"));
    $email = $data->email;
    // kiểm tra email có tồn tại hay k
    $result = $dbConn->query("select id from users where email = '$email'");
    $user = $result->fetch(PDO::FETCH_ASSOC);
    if(!$user){
        throw new Exception("Email không tồn tại");
    }
    
    //tạo token bằng cách mã hóa email và thời gian
    $token = md5(time().$email);
    //
    $dbConn->query("insert into reset_password (email, token) 
    values ('$email', '$token')");
    //gửi email có link reset mật khẩu
    $link = "<a href='http://127.0.0.1:3456/resetPassword.php?email="
    . $email . "&token=" . $token . "'>Click to reset password</a>";
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
    $mail->FromName = "Nguyễn Anh Hùng";
    $mail->addAddress($email, 'Hello');
    $mail->Subject = "Reset Password";
    $mail->isHTML(true);
    $mail->Body = "Click on this link to reset password " . $link . " ";
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
catch(Exception $e){
    echo json_encode(array(
        "status" => false,
        "message" => $e->getMessage()
    ));
}
?>