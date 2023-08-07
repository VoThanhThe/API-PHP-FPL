<?php
//including the database connection file
include("./database/connection.php");
//getting id of the data from url
try{

    $id = $_GET['id'];
    if(empty($id)){
        //hiện trang 404
        header("Location: 404.php");
    }
    $categories = $dbConn->query("SELECT id,name FROM categories WHERE id=$id");

    while ($row = $categories->fetch(PDO::FETCH_ASSOC)) {
        $id = $row['id'];
        $name = $row['name'];
    }
}catch(Exception $e){
   
}
?>

<?php
if (isset($_POST['submit'])) {

    $id = $_POST['id'];
    $name = $_POST['name'];

    // bắt lỗi khi người dùng không nhập đủ thông tin
    
    // upload file
    //$image = "https://cdn.tgdd.vn/Products/Images/42/213031/iphone-12-xanh-duong-new-600x600-200x200.jpg";

    //lấy ra đường dẫn tạm của file
    $image = "http://127.0.0.1:3456/uploads/".$fileName;

    //kiểm tra xem có cập nhật hình ảnh không
    $sql = "Update categories set name = '$name' where id = '$id'";
    //thực hiện câu lệnh sql
    
    $dbConn->exec($sql);
    // chuyển hướng trang web về index.php
    header("Location: categories.php");
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

    <div class="container mt-3">
        <h2>Chỉnh sửa danh mục</h2>
        <form id="form" action="editCategories.php?id=<?php echo $id?>" method="post" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="name">Tên sản phẩm:</label>
                <input value="<?php echo $id?>" type="hidden" class="form-control" id="name" placeholder="Enter id" name="id">
                <input value="<?php echo $name?>" type="text" class="form-control" id="name" placeholder="Enter name" name="name">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


</body>

</html>