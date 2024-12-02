<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "sisteminformasiakademik");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


function tambah($data)
{
    global $conn;
    // ambil data dari tiap elemen dalam form
    $nim = htmlspecialchars($data["nim"]);
    $nama = htmlspecialchars($data["nama"]);
    $tempat = htmlspecialchars($data["tempat"]);
    $tanggalLahir = htmlspecialchars($data["tanggal-lahir"]);
    $jenisKelamin = htmlspecialchars($data["jenis-kelamin"]);
    $email = htmlspecialchars($data["email"]);
    $prodi = htmlspecialchars($data["prodi"]);

    // upload gambar
    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    // query insert data
    $query = "INSERT INTO mahasiswa
      VALUES
      ('','$nama', '$nim',  '$tempat', '$tanggalLahir','$jenisKelamin', '$email','$prodi', '$gambar')

   ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload()
{

    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        echo "
      <script>
      alert('File Gambar Tidak Boleh Kosong!')</script>
      ";
        return false;
    }

    // cek apakah yg diup adalah gambar
    $ekstensiGambarValid = ['jpeg', 'jpg', 'jfif', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "
      <script>
      alert('Upload Ekstensi Gambar!')</script>
      ";
        return false;
    }

    // cek jika ukurannya terlalu besar
    if ($ukuranFile > 1000000) {
        echo "
      <script>
      alert('Ukuran File Terlalu Besar!')</script>
      ";
        return false;
    }

    // lolos pengecekan, gambar siap upload
    // generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'assets/img/' . $namaFileBaru);

    return $namaFileBaru;
}

function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

    return mysqli_affected_rows($conn);
}


function ubah($data)
{
    global $conn;
    // ambil data dari tiap elemen dalam form
    $id = $data["id"];
    $nim = htmlspecialchars($data["nim"]);
    $nama = htmlspecialchars($data["nama"]);
    $tempat = htmlspecialchars($data["tempat"]);
    $tanggalLahir = htmlspecialchars($data["tanggal-lahir"]);
    $jenisKelamin = htmlspecialchars($data["jenis-kelamin"]);
    $email = htmlspecialchars($data["email"]);
    $prodi = htmlspecialchars($data["prodi"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    // cek apakah user pilih gambar baru atau tidak
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    // query insert data
    $query = "UPDATE mahasiswa SET
      nim = '$nim',
      nama = '$nama',
      email = '$email',
      tempat = '$tempat',
      tanggal-lahir = '$tanggalLahir',
      jenis-kelamin = '$jenisKelamin',
      prodi = '$prodi',
      gambar = '$gambar'
      WHERE id = $id
   ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


// Searching
function cari($keyword)
{
    $query = "SELECT * FROM mahasiswa
      WHERE
      nama LIKE '%$keyword%' OR
      nim LIKE '%$keyword%' OR
      email LIKE '%$keyword%' OR
      prodi LIKE '%$keyword%'
   ";

    return query($query);
}

function registrasi($data)
{
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // cek apakah user sudah terdaftar atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "
      <script>
      alert('User Sudah Terdaftar, Silahkan Login!');
      </script>
      ";

        return false;
    }
    // konfirmasi password
    if ($password !== $password2) {
        echo "<script>
      alert('Password Tidak Sama');
      </script>";

        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan user ke database
    mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");
}
