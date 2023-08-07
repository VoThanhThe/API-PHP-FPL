<?php

// dung session luu trang thai dang nhap

session_start();

//neu da đang nhap chuyen ve trang index.php
if(isset($_SESSION['email'])){
  header("Location: index.php");
  exit();
}


include_once("./database/connection.php");

if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $pswd = $_POST['password'];

  $user = $dbConn->query("SELECT id, email, password
                    FROM users where email = '$email'");

  if ($user->rowCount() > 0) {

    $row = $user->fetch(PDO::FETCH_ASSOC);
    $id = $row['id'];
    $email = $row['email'];
    $password = $row['password'];

    if(password_verify($pswd, $password)) {
      $_SESSION['email'] = $email;
      header("Location: index.php");
    }else {
      echo "<font color='red'>Mật khẩu không đúng</font><br/>";
    }
  } else {
    echo "<font color='red'>Email không tồn tại.</font><br/>";
  }
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
  <!-- <div>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Logo</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mynavbar">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="statistic.php">Statistic</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="resetPassword.php">ResetPassword</a>
            </li>
          </ul>
          <form class="d-flex">
            <input class="form-control me-2" type="text" placeholder="Search">
            <button class="btn btn-primary" type="button">Search</button>
          </form>
        </div>
      </div>
    </nav>
  </div> -->
  <section class="vh-100" style="background-color: #9A616D;">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-10">
          <div class="card" style="border-radius: 1rem;">
            <div class="row g-0">
              <div class="col-md-6 col-lg-5 d-none d-md-block">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img1.webp" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
              </div>
              <div class="col-md-6 col-lg-7 d-flex align-items-center">
                <div class="card-body p-4 p-lg-5 text-black">

                  <form action="login.php" method="post">

                    <div class="d-flex align-items-center mb-3 pb-1">
                      <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                      <span class="h1 fw-bold mb-0">Login Account</span>
                    </div>

                    <div class="form-outline mb-2">
                      <label class="form-label" for="form2Example17">Email address</label>
                      <input type="email" id="form2Example17" class="form-control form-control-lg" name="email" />
                    </div>

                    <div class="form-outline mb-4">
                      <label class="form-label" for="form2Example27">Password</label>
                      <input type="password" id="form2Example27" class="form-control form-control-lg" name = "password" />
                    </div>

                    <div class="pt-1 mb-4">
                      <button name="submit" class="btn btn-dark btn-lg btn-block" type="submit" >Login</button>
                    </div>

                    <a class="small text-muted" href="#!">Forgot password?</a>
                    <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="#!" style="color: #393f81;">Register here</a></p>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</body>

</html>