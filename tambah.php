<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

// koneksi ke DBMS
require 'functions.php';

// cek tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {


    // cek data berhasil ditambahkan atau gagal
    if (tambah($_POST) > 0) {
        echo "<script>
         alert ('data berhasil ditambahkan!');
         document.location.href = 'index.php';
      </script>";
    } else {
        echo "<script>
         alert ('data gagal ditambahkan!');
         document.location.href = 'index.php';
      </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar bg-body-tertiary shadow-sm px-5 py-4 d-flex justify-content-between align-items-center" style="backdrop-filter: blur(10px); background-color: rgba(255, 255, 255, 0.8);">
        <button class="toggle-btn" id="toggleSidebar" type="button">
            <span class="bar1"></span>
            <span class="bar2"></span>
            <span class="bar3"></span>
        </button>
        <a class="navbar-brand fw-semibold me-auto" style="color:#475569" href="#">
            <img src="assets/img/logo.svg" alt="Logo" height="30" class="d-inline-block align-text-top" />
            <span style="margin-left: 4px; margin-top:2px">Sistem Informasi Akademik</span>
        </a>
        <div class="dropdown">
            <a href="#" class="d-flex text-body align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="assets/img/download.jpg" alt="Profile" width="32" height="32" class="rounded-circle me-2">
                <strong><?= $_SESSION["username"] ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar sidebar-hidden">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="index.php" class="nav-link text-body">
                    Daftar Mahasiswa
                </a>
            </li>
            <li>
                <a href="#" class="nav-link text-body">
                    Edit Data
                </a>
            </li>
            <li>
                <a href="tambah.php" class="nav-link active" aria-current="page">
                    Tambah Data
                </a>
            </li>
        </ul>
        <hr>
    </div>

    <div class="container my-4">
        <div class="main w-50 mx-auto rounded-2 shadow p-5 m-3 ">
            <h3 class="text-dark">Tambah Mahasiswa</h1>
                <form class="row" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nomor Induk Mahasiswa</label>
                        <input type="text" class="form-control" name="nim" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3 col-4">
                        <label for="exampleInputEmail1" class="form-label">Tempat</label>
                        <input type="text" class="form-control" name="tempat" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3 col-4">
                        <label for="exampleInputEmail1" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal-lahir" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3 col-4">
                        <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" name="jenis-kelamin" aria-label="Default select example">
                            <option selected>Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Prodi</label>
                        <select class="form-select" name="prodi" aria-label="Default select example">
                            <option selected>Program Studi</option>
                            <option value="Sistem Informasi">Sistem Informasi</option>
                            <option value="Teknik Informatika">Teknik Informatik</option>
                            <option value="Teknik Kimia">Teknik Kimia</option>
                            <option value="Teknik Geologi">Teknik Geologi</option>
                            <option value="Teknik Pertambangan">Teknik Pertambangan</option>
                            <option value="Teknik Mesin">Teknik Mesin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Gambar</label>
                        <input type="file" class="form-control" name="gambar" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary w-100 mx-auto">Submit</button>
                </form>
        </div>
    </div>
    <!-- Script -->
    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>