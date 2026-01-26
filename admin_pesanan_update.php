<?php
require "config/database.php";

$pesanan_id = $_POST['pesanan_id'] ?? null;
$obat_ids   = $_POST['obat_id'] ?? [];

if (!$pesanan_id) die("ID pesanan tidak ditemukan");
if (count($obat_ids) === 0) die("Pilih minimal 1 obat");

$q = mysqli_query($conn, "SELECT status FROM pesanan WHERE id='$pesanan_id'");
$p = mysqli_fetch_assoc($q);

if ($p['status'] === 'selesai') die("Pesanan sudah selesai");

foreach ($obat_ids as $oid) {
  mysqli_query($conn, "
    INSERT INTO pesanan_obat (pesanan_id, obat_id)
    VALUES ('$pesanan_id', '$oid')
  ");
}

mysqli_query($conn, "
  UPDATE pesanan SET status='selesai'
  WHERE id='$pesanan_id'
");

echo "Pesanan berhasil diselesaikan ✅";
