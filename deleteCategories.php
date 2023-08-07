<?php
//including the database connection file
include("./database/connection.php");
//getting id of the data from url
try{
    $id = $_GET['id'];
    $sql = "DELETE FROM categories WHERE id=:id";
    $query = $dbConn->prepare($sql);
    $query->execute(array(':id' => $id));
    header("Location: categories.php");
}catch(Exception $e){
    //chuyển hướng về trang index
    //hiện thông báo k thành công
}

?>