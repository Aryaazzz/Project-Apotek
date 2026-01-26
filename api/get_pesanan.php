<?php
require "../config/database.php";

$q = mysqli_query($conn, "
  SELECT id, nama_pembeli, keluhan, status
  FROM pesanan
  WHERE status='proses'
  ORDER BY id DESC
");

$data = [];
while($r = mysqli_fetch_assoc($q)){
  $data[] = $r;
}

echo json_encode($data);
