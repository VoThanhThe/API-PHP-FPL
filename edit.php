<?php
//including the database connection file
include("./database/connection.php");
//getting id of the data from url
try{
    $categories = $dbConn->query("SELECT id, name FROM categories");

    $id = $_GET['id'];
    if(empty($id)){
        //hiện trang 404
        header("Location: 404.php");
    }
    $product = $dbConn->query("SELECT id,name, price, quantity, 
    image, description, categoryId FROM products WHERE id=$id");

    while ($row = $product->fetch(PDO::FETCH_ASSOC)) {
        $id = $row['id'];
        $name = $row['name'];
        $price = $row['price'];
        $quantity = $row['quantity'];
        $image = $row['image'];
        $description = $row['description'];
        $categoryId = $row['categoryId'];

    }
}catch(Exception $e){
   
}
?>

<?php
if (isset($_POST['submit'])) {

    $currentDirectory = getcwd();
    $uploadDirectory = "/uploads/";
    $fileName = $_FILES['image']['name'];
    $fileTmpName  = $_FILES['image']['tmp_name'];
    $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);
    move_uploaded_file($fileTmpName, $uploadPath);

    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $image = $_POST['image'];
    $categoryId = $_POST['categoryId'];
    $description = $_POST['description'];

    // bắt lỗi khi người dùng không nhập đủ thông tin
    
    // upload file
    //$image = "https://cdn.tgdd.vn/Products/Images/42/213031/iphone-12-xanh-duong-new-600x600-200x200.jpg";

    //lấy ra đường dẫn tạm của file
    $image = "http://127.0.0.1:3456/uploads/".$fileName;

    //kiểm tra xem có cập nhật hình ảnh không
    if(empty($fileName)){
        $sql = "Update products set name = '$name', price = '$price', 
        quantity = '$quantity',
        categoryId = '$categoryId', 
        description = '$description'  where id = '$id'";
    }
    else
    {
        $sql = "Update products set name = '$name', price = '$price', 
    quantity = '$quantity', image = '$image', 
    categoryId = '$categoryId', 
    description = '$description'  where id = '$id'";
    }
    //thực hiện câu lệnh sql
    
    $dbConn->exec($sql);
    // chuyển hướng trang web về index.php
    header("Location: index.php");
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
        <h2>Chỉnh sửa sản phẩm</h2>
        <form id="form" action="edit.php?id=<?php echo $id?>" method="post" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="name">Tên sản phẩm:</label>
                <input value="<?php echo $id?>" type="hidden" class="form-control" id="name" placeholder="Enter id" name="id">
                <input value="<?php echo $name?>" type="text" class="form-control" id="name" placeholder="Enter name" name="name">
            </div>
            <div class="mb-3 mt-3">
                <label for="price">Giá sản phẩm:</label>
                <input value="<?php echo $price?>" type="number" class="form-control" id="price" placeholder="Enter price" name="price">
            </div>
            <div class="mb-3 mt-3">
                <label for="quantity">Số lượng:</label>
                <input value="<?php echo $quantity?>" type="number" class="form-control" id="quantity" placeholder="Enter quantity" name="quantity">
            </div>
            <div class="mb-3 mt-3">
                <label for="image">Hình ảnh:</label>
                <input type="file" class="form-control" id="image" placeholder="Enter image" name="image">
                <img  id="image-display" src="<?php echo $image?>" width="200" height="200" alt="Hình ảnh"/>

            </div>
           
            <div class="mb-3 mt-3">
                <label for="categoryId">Danh mục:</label>
                <select class="form-control" id="categoryId" name="categoryId">
                    <?php
                    while ($row = $categories->fetch(PDO::FETCH_ASSOC)) {
                        if($categoryId == $row['id']){
                            echo "<option selected value='".$row['id']."'>".$row['name']."</option>";
                        }else {
                            echo "<option value='".$row['id']."'>".$row['name']."</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label for="description">Mô tả:</label>
                <textarea class="form-control" id="description" placeholder="Enter description" name="description"><?php echo $description?></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


    <script>
        const image = document.querySelector('#image');
        const imageDisplay = document.querySelector('#image-display');
        image.addEventListener('change', function(e) {
            const file = this.files[0];
            const url = URL.createObjectURL(file);
            imageDisplay.src = url;
        });
    </script>

</body>

</html>