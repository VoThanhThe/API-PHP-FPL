<?php
include_once("./database/connection.php");
$categories = $dbConn->query("SELECT id, name FROM categories");
?>

<!-- Lưu dữ liệu vào database khi Submit -->

<?php
if (isset($_POST['submit'])) {
    //upload anh vao sever

    // $currentDirectory = getcwd();
    // $uploadDirectory = "/uploads/";
    // $fileName = $_FILES['image']['name'];
    // $fileTmpName  = $_FILES['image']['tmp_name'];
    // $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);
    // move_uploaded_file($fileTmpName, $uploadPath);

    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $image = $_POST['imageUrl']; //sua cho nay
    $categoryId = $_POST['categoryId'];
    $description = $_POST['description'];

    // bắt lỗi khi người dùng không nhập đủ thông tin

    // upload file
    //$image = "https://cdn.tgdd.vn/Products/Images/42/213031/iphone-12-xanh-duong-new-600x600-200x200.jpg";
    //lấy ra đường dẫn tạm của file
    //$image = "http://127.0.0.1:3456/uploads/".$fileName;
    //thực hiện câu lệnh sql
    $sql = "INSERT INTO products (name, price, quantity, image, categoryId, description)
    VALUES ('$name', '$price', '$quantity', '$image', '$categoryId', '$description')";
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- firebase -->
    <script src="https://www.gstatic.com/firebasejs/5.4.0/firebase.js"></script>
</head>

<body>

    <div class="container mt-3">
        <h2>Thêm mới sản phẩm</h2>
        <form id="form" action="insert.php" method="post">
            <div class="mb-3 mt-3">
                <label for="name">Tên sản phẩm:</label>
                <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
            </div>
            <div class="mb-3 mt-3">
                <label for="price">Giá sản phẩm:</label>
                <input type="number" class="form-control" id="price" placeholder="Enter price" name="price">
            </div>
            <div class="mb-3 mt-3">
                <label for="quantity">Số lượng:</label>
                <input type="number" class="form-control" id="quantity" placeholder="Enter quantity" name="quantity">
            </div>
            <div class="mb-3 mt-3">
                <label for="image">Hình ảnh:</label>
                <input onchange="onChangeImage()" type="file" class="form-control" id="image" name="image">
                <img id="image-display" width="200" height="200" alt="Hình ảnh" />
                <input type="hidden" name="imageUrl" id="imageUrl" />
            </div>
            <div class="mb-3 mt-3">
                <label for="categoryId">Danh mục:</label>
                <select class="form-control" id="categoryId" name="categoryId">
                    <?php
                    while ($row = $categories->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label for="description">Mô tả:</label>
                <textarea class="form-control" id="description" placeholder="Enter description" name="description"></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        //validate ở client
        const form = document.querySelector('#form');
        form.addEventListener('submit', function(e) {
            const name = document.querySelector('#name').value;
            const price = document.querySelector('#price').value;
            const quantity = document.querySelector('#quantity').value;
            const description = document.querySelector('#description').value;
            const image = document.querySelector('#image').value;
            if (!name || name.trim().length === 0 &&
                !price || price.trim().length === 0 &&
                !quantity || quantity.trim().length === 0 &&
                !description || description.trim().length === 0 &&
                !image || image.trim().length === 0) {
                swal('Vui lòng nhập đầy đủ thông tin sản phẩm!');
                e.preventDefault();
                return false;
            }
            //submit form
            return true;

        });

        // const image = document.querySelector('#image');
        // const imageDisplay = document.querySelector('#image-display');
        // image.addEventListener('change', function(e) {
        //     const file = this.files[0];
        //     const url = URL.createObjectURL(file);
        //     imageDisplay.src = url;
        // });

        const firebaseConfig = {
            apiKey: "AIzaSyAzCmbINFnKwo9QpJj6uTqp2QjGiPPGqlg",
            authDomain: "android-networking-2a786.firebaseapp.com",
            projectId: "android-networking-2a786",
            storageBucket: "android-networking-2a786.appspot.com",
            messagingSenderId: "814366332930",
            appId: "1:814366332930:web:c93cd6d56b828328732f1b",
            measurementId: "G-BCZE3WKX2L"
        };

        firebase.initializeApp(firebaseConfig);

        //xử lý khi chọn ảnh thì upload lên firebase
        const onChangeImage = () => {
            const file = document.getElementById('image').files[0];
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('image-display').src = e.target.result;
            }
            reader.readAsDataURL(file);
            //upload file lên firebase
            const ref = firebase.storage().ref(new Date().getTime() + '-' + file.name);
            const uploadTask = ref.put(file);
            uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,
                (snapshot) => {},
                (error) => {
                    console.log('firebase error: ', error)
                },
                () => {
                    uploadTask.snapshot.ref.getDownloadURL().then(url => {
                        console.log('>>>>> File available at:', url);
                        document.getElementById('imageUrl').value = url;
                    })
                }
            );
        }
    </script>

</body>

</html>