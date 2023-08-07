<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// http://127.0.0.1:3456/api/demo/tinhToan.php?a=5&b=6&c=7
//xử lí nghiệp vụ ở đây
//Lấy dữ liệu từ client gửi lên

$a = $_GET['a'];
$b = $_GET['b'];

//xử lý nghiệp vụ

$tong = $a + $b;
$hieu = $a - $b;
$tich = $a * $b;
$thuong = $a / $b;

echo json_encode(
    array(
        "tong" => $tong,
        "hieu" => $hieu,
        "tich" => $tich,
        "thuong" => $thuong,
    )
);
