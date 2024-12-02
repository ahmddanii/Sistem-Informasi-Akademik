<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

// koneksi ke DBMS
require 'functions.php';

// ambil data di URL
$id = $_GET["id"];

// query data siswa berdasarkan id
$student = query("SELECT * FROM mahasiswa WHERE id = $id")[0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous" />

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
                <strong>Ahmad Dani</strong>
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
                <a href="index.php" class="nav-link active" aria-current="page">
                    Daftar Mahasiswa
                </a>
            </li>
            <li>
                <a href="crud.php" class=" nav-link text-body">
                    Edit Data
                </a>
            </li>
            <li>
                <a href="tambah.php" class="nav-link text-body">
                    Tambah Data
                </a>
            </li>
        </ul>
        <hr>
    </div>

    <div class="container">
        <div class="main row">
            <h3 class="fw-semibold" style="margin-top: 30px; margin-bottom:0">Biodata</h3>
            <div class="col-3 rounded-2 shadow p-4 m-3">
                <div class="d-flex align-items-center">
                    <img class="me-2 rounded-1" style="width: 120px; height: 150px; object-fit:cover" src="assets/img/<?= $student["gambar"] ?>" width="150" alt="">
                    <div class="me-2 d-flex flex-column">
                        <p class="m-0 fs-5 fw-semibold"><?= $student["nama"] ?></p>
                        <p class="m-0"><?= $student["nim"] ?></p>
                    </div>
                </div>
            </div>
            <div class="my-3 col-7 rounded-2 shadow p-4 m-3">
                <div class="row">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nama</label>
                        <input type="text" class="form-control" placeholder="<?= $student["nama"] ?>" name="nama" id="exampleInputEmail1" aria-describedby="emailHelp" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nomor Induk Mahasiswa</label>
                        <input type="text" class="form-control" placeholder="<?= $student["nim"] ?>" name="nim" id="exampleInputEmail1" aria-describedby="emailHelp" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="text" class="form-control" placeholder="<?= $student["email"] ?>" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" disabled>
                    </div>
                    <div class="mb-3 col-4">
                        <label for="exampleInputEmail1" class="form-label">Tempat</label>
                        <input type="text" class="form-control" placeholder="<?= $student["tempat"] ?>" name="tempat" id="exampleInputEmail1" aria-describedby="emailHelp" disabled>
                    </div>
                    <div class="mb-3 col-4">
                        <label for="exampleInputEmail1" class="form-label">Tanggal Lahir</label>
                        <input type="text" class="form-control" placeholder="<?= $student["tanggal-lahir"] ?>" name="tanggal-lahir" id="exampleInputEmail1" aria-describedby="emailHelp" disabled>
                    </div>
                    <div class="mb-3 col-4">
                        <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" name="jenis-kelamin" aria-label="Default select example" disabled>
                            <option selected> <?= $student["jenis-kelamin"] ?></option>
                            <option value="Laki-laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Prodi</label>
                        <select class="form-select" name="prodi" aria-label="Default select example" disabled>
                            <option selected><?= $student["prodi"] ?></option>
                            <option value="Sistem Informasi">Sistem Informasi</option>
                            <option value="Teknik Informatika">Teknik Informatik</option>
                            <option value="Teknik Kimia">Teknik Kimia</option>
                            <option value="Teknik Geologi">Teknik Geologi</option>
                            <option value="Teknik Pertambangan">Teknik Pertambangan</option>
                            <option value="Teknik Mesin">Teknik Mesin</option>
                        </select>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- Javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>