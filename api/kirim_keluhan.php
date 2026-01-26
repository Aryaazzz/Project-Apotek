<?php
session_start();
require "../config/database.php";

if (!isset($_SESSION['user_id'])) {
  die("unauthorized");
}

$nama = trim($_POST['nama_pembeli'] ?? '');
$keluhan = trim($_POST['keluhan'] ?? '');
$user_id = $_SESSION['user_id'];

if ($nama === '' || $keluhan === '') {
  die("invalid");
}

// buat pesanan baru
$q = mysqli_query($conn, "
  INSERT INTO pesanan (user_id, nama_pembeli, keluhan, status)
  VALUES ('$user_id', '$nama', '$keluhan', 'proses')
");

if ($q) {
  echo "ok";
} else {
  echo "db_error";
}
