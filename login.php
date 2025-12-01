<?php
session_start();
require 'function.php';

$error = "";
$success = "";

if (isset($_SESSION['log']) && !isset($_POST['login'])) {
    header('location:dashboard.php');
    exit;
}

// LOGIN
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $cekdatabase = mysqli_query($conn, "SELECT * FROM user WHERE email='$email'");
    $data = mysqli_fetch_assoc($cekdatabase);

    if ($data) {
        if (password_verify($password, $data['password'])) {
            $_SESSION['log'] = true;
            $_SESSION['email'] = $data['email'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['role'] = $data['role']; 

            if ($data['role'] == 'Admin') {
                header('location:dashboard.php');
            } else {
                header('location:index.php'); 
            }
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak terdaftar!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Login</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(160deg, #2ecc71, #3498db);
    }
    .login-box { width: 400px; }
    .login-header { text-align: center; background: #2ecc71; padding: 20px; }
    .login-header img { width: 150px; margin-bottom: 10px; }
    .login-header h3 { margin: 0; color: white; font-weight: bold; }
  </style>
</head>
<body>
  <div class="card shadow-lg border-0 rounded-lg login-box">
    <div class="login-header">
      <img src='assets/img/logo_DLH.png' alt="Logo">
      <h3><b>Dinas</b> Lingkungan Hidup</h3>
    </div>
    <div class="card-body">

      <?php if($error != ""): ?>
        <div class="alert alert-danger text-center" role="alert">
          <?= $error; ?>
        </div>
      <?php endif; ?>
      <?php if($success != ""): ?>
        <div class="alert alert-success text-center" role="alert">
          <?= $success; ?>
        </div>
      <?php endif; ?>

      <form method="post">
        <div class="form-group">
          <label class="small mb-1" for="inputEmailAddress">Email</label>
          <input class="form-control py-4" name="email" id="inputEmailAddress" type="email" placeholder="Masukkan Email" required/>
        </div>
        <div class="form-group">
          <label class="small mb-1" for="inputPassword">Password</label>
          <input class="form-control py-4" name="password" id="inputPassword" type="password" placeholder="Masukkan Password" required/>
        </div>
        <div class="form-group d-flex flex-column align-items-center mt-4 mb-0">
          <button class="btn btn-primary mb-2 w-100" name="login">Login</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script>
    setTimeout(function() {
      $('.alert').fadeOut('slow');
    }, 3000);
  </script>
</body>
</html>
