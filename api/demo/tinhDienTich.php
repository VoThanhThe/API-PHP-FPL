<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// http://127.0.0.1:3456/api/demo/tinhDienTich.php
//xử lí nghiệp vụ ở đây
//Tính diện tích
//method: post
//tính diện tích hình chữ nhật

$data = json_decode(file_get_contents("php://input"));

//đọc dữ liệu từ body của request
//chiều dài, chiều rộng

$chieuDai = $data -> chieuDai;
$chieuRong = $data -> chieuRong;
$dienTich = $chieuDai * $chieuRong;

//trả kết quả dạng json

echo json_encode(
    array(
        "dien tich" => $dienTich
    )
    );