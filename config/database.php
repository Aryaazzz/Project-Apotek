<?php
$conn = mysqli_connect("localhost", "root", "", "apotek");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}


