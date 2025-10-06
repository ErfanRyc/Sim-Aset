.<?php
require 'function.php';


if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $cekdatabase = mysqli_query($conn, "SELECT * FROM login where email='$email' and password='$password'");

    $hitung = mysqli_num_rows($cekdatabase);

    if($hitung>0){
        $_SESSION['log'] = 'True';
        header('location:index.php');
    } else {
        header('location:login.php');
    };
}; 

if(!isset($_SESSION['log'])){

} else {
    header ('location:index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
                <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
                    <title>Login</title>
  <link href="css/styles.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      justify-content: center;  /* center horizontal */
      align-items: center;      /* center vertical */
      background: linear-gradient(160deg, #2ecc71, #3498db);
    }

    .login-box {
      width: 400px;  /* ukuran login box */
    }

    .login-header {
      text-align: center;
      background: #2ecc71;
      padding: 20px;
    }

    .login-header img {
      width: 150px; /* ukuran logo */
      margin-bottom: 10px;
    }

    .login-header h3 {
      margin: 0;
      color: white;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="card shadow-lg border-0 rounded-lg login-box">
    <div class="login-header">
      <img src='assets/img/logo_DLH.png' alt="Logo"> <!-- Logo -->
      <h3><b>Dinas</b> Lingkungan Hidup</h3>
    </div>
    <div class="card-body">
      <form method="post">
        <div class="form-group">
          <label class="small mb-1" for="inputEmailAddress">Email</label>
          <input class="form-control py-4" name="email" id="inputEmailAddress" type="email" placeholder="Masukkan Email" />
        </div>
        <div class="form-group">
          <label class="small mb-1" for="inputPassword">Password</label>
          <input class="form-control py-4" name="password" id="inputPassword" type="password" placeholder="Masukkan Password" />
        </div>
        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
          <button class="btn btn-primary" name="login">Login</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
