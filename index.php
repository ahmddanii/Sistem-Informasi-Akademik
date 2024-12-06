<?php
session_start();

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

require 'functions.php';

// pagination
// konfigurasi
$jumlahDataPerHalaman = 10;
$jumlahData = count(query('SELECT * FROM mahasiswa'));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awalData, $jumlahDataPerHalaman");
if (isset($_POST["search"])) {
  $mahasiswa = cari($_POST["keyword"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sistem Informasi Akademik</title>
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
        <img src="assets/img/<?= $_SESSION["profile-picture"] ?>" alt="Profile" width="32" height="32" class="rounded-circle me-2">
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

  <!-- Main Content -->
  <div class="container p-4" id="mainContent">
    <div class="main mx-auto my-3">
      <div class="head d-flex justify-content-between ">
        <h3>Data Mahasiswa</h3>
        <form action="" method="post">
          <div class="row g-3 align-items-center justify-content-end ">
            <div class="col-auto d-flex flex-row mb-2 ">
              <input type="text" placeholder="Cari Data Mahasiswa" id="keyword" name="keyword" class="form-control mx-2" autocomplete="off" autofocus>
              <button type="submit" id="search" name="search" class="btn btn-primary">Search</button>
            </div>
          </div>
        </form>


      </div>
      <table class="table table-bordered rounded-2 ">
        <tr>
          <th>No.</th>
          <th>Lihat Profil</th>
          <th>NIM</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Prodi</th>
        </tr>
        <?php $i = "1";    ?>
        <?php foreach ($mahasiswa as $row) : ?>
          <tr class="table-light">
            <td><?= $i; ?></td>
            <td>
              <a href="profil.php?id=<?= $row["id"]; ?>" class="btn btn-primary btn-sm">Lihat Biodata</a>
            </td>
            <td><?= $row["nim"]; ?></td>
            <td><?= $row["nama"]; ?></td>
            <td><?= $row["email"]; ?></td>
            <td><?= $row["prodi"]; ?></td>
          </tr>
          <?php $i++; ?>
        <?php endforeach; ?>
      </table>

      <!-- navigasi -->
      <div class="footer d-flex justify-content-between">
        <div class="navigasi">

          <nav>
            <ul class="pagination mb-0  ">
              <?php if ($halamanAktif > 1) : ?>
                <li class="page-item">
                  <a href="?page=<?= $halamanAktif - 1 ?>" class="page-link">Previous</a>
                </li>
              <?php endif; ?>


              <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                <?php if ($i == $halamanAktif) : ?>
                  <li class="page-item active" aria-current="page">
                    <a href="?page=<?= $i; ?>" class="page-link"><?= $i; ?></a>
                  </li>
                <?php else : ?>
                  <li class="page-item"><a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a></li>
                <?php endif; ?>
              <?php endfor; ?>

              <?php if ($halamanAktif < $jumlahHalaman) : ?>
                <li class="page-item">
                  <a class="page-link" href="?page=<?= $halamanAktif + 1 ?>">Next</a>
                </li>
              <?php endif; ?>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
  </div>


  <!-- JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="assets/js/script.js"></script>
</body>

</html>