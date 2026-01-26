<?php
session_start();
require_once '../config/database.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$role     = $_POST['role'] ?? '';

$stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND role=?");
$stmt->bind_param("ss", $username, $role);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role']    = $user['role'];

        $redirect = $user['role'] === 'admin'
          ? '/apotek/admin_dashboard.php'
          : '/apotek/buyer_dashboard.php';

        echo json_encode([
            'status' => 'success',
            'redirect' => $redirect
        ]);
        exit;
    }
}

echo json_encode(['status' => 'error']);
