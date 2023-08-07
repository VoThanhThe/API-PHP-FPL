<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../database/connection.php");

// url: http://127.0.0.1:3456/api/getAllProduct.php

// SELECT p.id, p.name, p.price,
//     p.quantity, p.image, p.description, 
//     c.id as category_id, c.name as category_name FROM products p 
//     inner join categories c on p.`categoryId` = c.id LIMIT 0,100

try{
    $result = $dbConn->query("SELECT p.id, p.name, p.price,
    p.quantity, p.image, p.description, 
    c.id as category_id, c.name as category_name FROM products p 
    inner join categories c on p.`categoryId` = c.id");
    $products = $result->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(array(
        "status" => true,
        "products" => $products
    ));
}
catch(Exception $e){
    echo json_encode(array(
        "status" => false,
        "message" => $e->getMessage()
    ));
}
?>