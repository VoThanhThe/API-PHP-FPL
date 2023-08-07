<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// http://127.0.0.1:3456/api/demo/phuongTrinhBacHai.php?a=5&b=6&c=7
//xử lí nghiệp vụ ở đây
//Phương trình bậc 2

 
$a = $_GET['a'];
$b = $_GET['b'];
$c = $_GET['c'];

$delta = $b*$b-4*$a*$c;
$ketqua = '';
$x1 = 0;
$x2 = 0;

if($delta < 0){
    $ketqua = "phuong trinh vo nghiem";
}elseif($delta == 0){
    $ketqua = "phuong trinh co nghiem kep";
    $x1 = -($b/2*$a);
    $x2 = -($b/2*$a);
}elseif($delta > 0){
    $ketqua = "phuong trinh co 2 nghiem phan biet";
    $x1 = (-$b+ sqrt($delta))/ 2* $a;
    $x2 = (-$b - sqrt($delta))/ 2* $a;
}

echo json_encode(
    array(
        "ketqua" => $ketqua,
        "X1" =>$x1,
        "X2" => $x2
    )
);