<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../database/connection.php");

try{
    $body = json_decode(file_get_contents("php://input"));

    $email = $body->email;
    $pswd = $body->password;

    if(empty($email) || empty($pswd)){
        echo json_encode(array(
            "status" => false,
          ));
          return;

    }

    $user = $dbConn->query("SELECT id, email, password
                    FROM users where email = '$email'");

  if ($user->rowCount() > 0) {

    $row = $user->fetch(PDO::FETCH_ASSOC);
    $id = $row['id'];
    $email = $row['email'];
    $password = $row['password'];

    if(password_verify($pswd, $password)) {
      echo json_encode(array(
        "status" => true,
        "email" => $email,
        "id" => $id
      ));
    }else {
        echo json_encode(array(
            "status" => false,
          ));
    }
  } else {
    echo json_encode(array(
        "status" => false,
        "message" => "Không tìm thấy user"
      ));
  }
}catch(Exception $e){

}



?>