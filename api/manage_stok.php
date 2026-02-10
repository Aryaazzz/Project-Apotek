<?php
header('Content-Type: application/json');
session_start();
require "../config/database.php";

$action = $_GET['action'] ?? '';

// Get stok untuk buyer (PUBLIC - tidak perlu admin auth)
if ($action === 'get_stok_pembeli') {
    $query = "SELECT id, nama, stok, harga, kategori, gambar, deskripsi FROM obat ORDER BY nama ASC";
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Query error']);
        exit;
    }
    
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'data' => $data,
        'timestamp' => time()
    ]);
    exit;
}

// ADMIN ONLY - cek auth untuk endpoint lainnya
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Get stok obat
if ($action === 'get_stok') {
    $obat_id = intval($_GET['obat_id'] ?? 0);
    
    if ($obat_id <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid obat_id']);
        exit;
    }
    
    $query = "SELECT id, nama, stok FROM obat WHERE id = $obat_id";
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Query error: ' . mysqli_error($conn)]);
        exit;
    }
    
    $data = mysqli_fetch_assoc($result);
    
    if (!$data) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Obat tidak ditemukan']);
        exit;
    }
    
    echo json_encode([
        'success' => true,
        'data' => $data
    ]);
}

// Get semua stok untuk tabel
else if ($action === 'get_all_stok') {
    $query = "SELECT id, nama, stok, harga, kategori FROM obat ORDER BY nama ASC";
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Query error']);
        exit;
    }
    
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'data' => $data
    ]);
}

// Update stok (restok)
else if ($action === 'update_stok') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $obat_id = intval($input['obat_id'] ?? 0);
    $jumlah = intval($input['jumlah'] ?? 0);
    $tipe = $input['tipe'] ?? ''; // 'tambah' atau 'kurang'
    
    if ($obat_id <= 0 || $jumlah <= 0 || !in_array($tipe, ['tambah', 'kurang'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
        exit;
    }
    
    // Check if obat exists
    $check = mysqli_query($conn, "SELECT id, stok FROM obat WHERE id = $obat_id");
    if (!$check || mysqli_num_rows($check) == 0) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Obat tidak ditemukan']);
        exit;
    }
    
    $obat = mysqli_fetch_assoc($check);
    $stok_lama = $obat['stok'];
    
    if ($tipe === 'tambah') {
        $stok_baru = $stok_lama + $jumlah;
    } else {
        if ($stok_lama < $jumlah) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Stok tidak cukup untuk dikurangi']);
            exit;
        }
        $stok_baru = $stok_lama - $jumlah;
    }
    
    $query = "UPDATE obat SET stok = $stok_baru WHERE id = $obat_id";
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
        exit;
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Stok berhasil diupdate',
        'data' => [
            'obat_id' => $obat_id,
            'stok_lama' => $stok_lama,
            'stok_baru' => $stok_baru,
            'perubahan' => $tipe === 'tambah' ? '+' . $jumlah : '-' . $jumlah
        ]
    ]);
}

else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}
?>
