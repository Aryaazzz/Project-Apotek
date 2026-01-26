<?php
require "../config/database.php";

$data = mysqli_query($conn, "SELECT * FROM obat ORDER BY nama ASC");

$obat = [];
while ($o = mysqli_fetch_assoc($data)) {
    $obat[] = $o;
}

header('Content-Type: application/json');
echo json_encode($obat);
