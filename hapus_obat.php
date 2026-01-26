<?php
require "config/database.php";

$id = $_GET['id'];
mysqli_query($conn,"DELETE FROM pesanan_obat WHERE obat_id='$id'");
mysqli_query($conn,"DELETE FROM obat WHERE id='$id'");

header("Location: admin_dashboard.php");
