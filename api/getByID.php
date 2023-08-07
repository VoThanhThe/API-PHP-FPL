<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../database/connection.php");

// url: http://127.0.0.1:3456/api/getByID.php?123
try{

    $id = $_GET['id'];
    $result = $dbConn->query("SELECT p.id, p.name, p.price,
    p.quantity, p.image, p.description, 
    p.id as category_id FROM products p 
    where p.id = $id");
    $products = $result->fetch(PDO::FETCH_ASSOC);
    echo json_encode(array(
        "status" => true,
        "products" => $products
    ));
}
catch(Exception $e){
    echo $e->getMessage();
}
?>