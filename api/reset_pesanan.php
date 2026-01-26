<?php
session_start();
require "../config/database.php";

if(!isset($_SESSION['user_id'])){
  echo json_encode(["success"=>false]);
  exit;
}

$user_id = $_SESSION['user_id'];

// ambil pesanan terakhir user
$q = mysqli_query($conn,"
  SELECT id FROM pesanan 
  WHERE user_id='$user_id' 
  ORDER BY id DESC LIMIT 1
");

$p = mysqli_fetch_assoc($q);
if(!$p){
  echo json_encode(["success"=>false]);
  exit;
}

$pesanan_id = $p['id'];

// hapus relasi obat
mysqli_query($conn,"
  DELETE FROM pesanan_obat WHERE pesanan_id='$pesanan_id'
");

// hapus pesanan
mysqli_query($conn,"
  DELETE FROM pesanan WHERE id='$pesanan_id'
");

echo json_encode(["success"=>true]);
