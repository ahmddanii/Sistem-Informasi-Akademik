<?php
session_start();
require 'functions.php';

if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
  $id = $_COOKIE['id'];
  $key = $_COOKIE['key'];

  // ambil username sesuai id
  $result = mysqli_query($conn, "SELECT username FROM users WHERE id= $id");
  $row = mysqli_fetch_assoc($result);

  // cek cookie dan username
  if ($key === hash('sha256', $row['username'])) {
    $_SESSION['login'] = true;
  }
}


if (isset($_SESSION["login"])) {
  header("Location: index.php");
  exit;
}



if (isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

  // cek username 
  if (mysqli_num_rows($result) === 1) {
    // cek password
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row["password"])) {
      // set session
      $_SESSION["login"] = true;
      $_SESSION["username"] = $username;

      // cek remember me
      if (isset($_POST['remember'])) {
        // buat cookie
        setcookie('id', $row['id'], time() + 60);
        setcookie('key', hash('sha256', $row['username']), time() + 60);
      }

      header("Location: index.php");
      exit;
    }
  }

  $error = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Sistem Informasi Akademik</title>

  <!-- Bootstrap -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet" />

  <!-- Bootstrap Icons -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
    rel="stylesheet" />

  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/style.css" />
  <style>
    body {
      background-color: white;
    }

    .background-side {
      background: url(assets/img/sia.jpg) no-repeat center center;
      background-size: cover;
      height: 100vh;
    }

    .login-container {
      background: white;
      border-radius: 10px;
      padding: 40px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .btn-login {
      background: #0d6efd;
      color: white;
    }

    .btn-login:hover {
      background: #084298;
    }

    .footer {
      text-align: center;
      font-size: 0.9em;
      color: #aaa;
      margin-top: 20px;
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Bagian Kiri (Background) -->
      <div class="col-md-6 d-none d-md-block background-side"></div>

      <!-- Bagian Form -->
      <div class="col-md-6 d-flex justify-content-center align-items-center">
        <div class="login-container d-flex flex-column">
          <img
            src="assets/img/logo.svg"
            alt="logo SIA"
            width="150"
            class="my-3 mx-auto" />
          <h3 class="text-center mb-4">Sistem Informasi Akademik</h3>
          <hr />
          <?php if (isset($error)) : ?>
            <p class="text-danger text-center">Username atau Password salah!</p>
          <?php endif; ?>
          <form action="" method="post">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input
                type="text"
                name="username"
                id="username"
                class="form-control"
                required />
            </div>
            <div class="mb-3 position-relative">
              <label for="password" class="form-label">Password</label>
              <input
                type="password"
                name="password"
                id="password"
                class="form-control"
                required />
              <a
                href="#"
                id="toggle-password"
                class="position-absolute text-body"
                style="
                    top: 50%;
                    right: 15px;
                    transform: translateY(20%);
                    text-decoration: none;
                  ">
                <i id="toggle-icon" class="bi bi-eye-slash"></i>
              </a>
            </div>
            <div class="mb-3 form-check">
              <input
                type="checkbox"
                class="form-check-input"
                id="remember"
                name="remember" />
              <label for="remember" class="form-check-label">Remember Me</label>
            </div>
            <button type="submit" name="login" class="btn btn-login w-100">
              Login
            </button>
          </form>
          <div class="footer mt-3">
            <p>
              &copy;
              <?= date('Y'); ?>
              Ahmad Dani. All Rights Reserved.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Javascript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const passwordInput = document.getElementById("password");
    const togglePassword = document.getElementById("toggle-password");
    const toggleIcon = document.getElementById("toggle-icon");

    togglePassword.addEventListener("click", function(e) {
      e.preventDefault(); // Mencegah redirect
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.remove("bi-eye-slash");
        toggleIcon.classList.add("bi-eye");
      } else {
        passwordInput.type = "password";
        toggleIcon.classList.remove("bi-eye");
        toggleIcon.classList.add("bi-eye-slash");
      }
    });
  </script>
</body>

</html>