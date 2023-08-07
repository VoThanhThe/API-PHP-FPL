<?php
include_once("./database/connection.php");
$categories = $dbConn->query("SELECT id, name, image FROM categories");
?>

<!-- Lưu dữ liệu vào database khi Submit -->

<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $image = $_POST['image'];
    // bắt lỗi khi người dùng không nhập đủ thông tin
    
    // upload file
    // upload file
    $image = "https://cdn.tgdd.vn/Products/Images/42/213031/iphone-12-xanh-duong-new-600x600-200x200.jpg";
    
    $sql = "INSERT INTO categories (name, image)
    VALUES ('$name', '$image')";
    $dbConn->exec($sql);
    // chuyển hướng trang web về categories.php
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>

<body>

    <div class="container mt-3">
        <h2>Thêm mới danh mục</h2>
        <form id="form" action="insertCategory.php" method="post">
            <div class="mb-3 mt-3">
                <label for="name">Tên danh mục:</label>
                <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        const form = document.querySelector('#form');
        form.addEventListener('submit', function(e) {
            const name = document.querySelector('#name').value;
            if(!name || name.trim().length === 0) {
                swal('Vui lòng nhập đầy đủ thông tin sản phẩm!');
                e.preventDefault();
                return false;
            }
            //submit form
            return true;

        });
    </script>

</body>

</html>