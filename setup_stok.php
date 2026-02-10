<?php
/**
 * Setup Helper untuk Fitur Stok Realtime
 * File ini membantu melakukan migrasi database otomatis
 */

header('Content-Type: text/html; charset=utf-8');

require "config/database.php";

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'setup') {
    
    // Check if stok column already exists
    $checkColumn = mysqli_query($conn, "SHOW COLUMNS FROM obat LIKE 'stok'");
    
    if (mysqli_num_rows($checkColumn) > 0) {
        die('
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Setup Stok Realtime - Sudah Disetup</title>
            <style>
                body { font-family: Arial; max-width: 600px; margin: 50px auto; padding: 20px; }
                .info { background: #e8f4f8; padding: 15px; border-radius: 5px; border-left: 4px solid #0066cc; }
                .success { background: #e8f5e9; padding: 15px; border-radius: 5px; border-left: 4px solid #4caf50; margin-top: 20px; }
            </style>
        </head>
        <body>
            <h2>✅ Fitur Stok Realtime Sudah Disetup</h2>
            <div class="info">
                <p><strong>Kolom stok sudah ada di tabel obat.</strong></p>
                <p>Anda sudah bisa menggunakan fitur:</p>
                <ul>
                    <li>✓ Restok obat di Admin Dashboard</li>
                    <li>✓ Lihat stok realtime di Buyer Dashboard</li>
                    <li>✓ API manage_stok.php</li>
                </ul>
            </div>
            <div class="success">
                <p><a href="admin_dashboard.php">← Kembali ke Admin Dashboard</a></p>
            </div>
        </body>
        </html>
        ');
    }
    
    // Run migration
    $migration1 = mysqli_query($conn, "ALTER TABLE `obat` ADD COLUMN `stok` INT(11) NOT NULL DEFAULT 0 AFTER `harga`");
    
    if ($migration1) {
        // Set default stock untuk existing obat
        $migration2 = mysqli_query($conn, "UPDATE `obat` SET `stok` = 100 WHERE `stok` = 0");
        
        die('
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Setup Stok Realtime - Success</title>
            <style>
                body { font-family: Arial; max-width: 600px; margin: 50px auto; padding: 20px; }
                .success { background: #e8f5e9; padding: 20px; border-radius: 5px; border-left: 4px solid #4caf50; }
                .info { background: #f5f5f5; padding: 15px; border-radius: 5px; margin-top: 20px; }
                a { color: #0066cc; text-decoration: none; font-weight: bold; }
                a:hover { text-decoration: underline; }
            </style>
        </head>
        <body>
            <div class="success">
                <h2>✅ Setup Berhasil!</h2>
                <p>Database berhasil diupdate dengan fitur stok realtime.</p>
                <h3>Yang dilakukan:</h3>
                <ul>
                    <li>✓ Menambah kolom <strong>stok</strong> ke tabel obat</li>
                    <li>✓ Set default stok = 100 untuk semua obat yang ada</li>
                </ul>
            </div>
            
            <div class="info">
                <h3>🚀 Fitur yang Sekarang Aktif:</h3>
                <ul>
                    <li>📦 Restok Obat - Admin Dashboard</li>
                    <li>👥 Lihat Stok Realtime - Buyer Dashboard</li>
                    <li>⚡ API Manage Stok - api/manage_stok.php</li>
                </ul>
            </div>
            
            <div class="info">
                <h3>📚 Dokumentasi:</h3>
                <p>Baca file <strong>FITUR_STOK_REALTIME.md</strong> untuk panduan lengkap.</p>
            </div>
            
            <p style="margin-top: 30px;">
                <a href="admin_dashboard.php">→ Ke Admin Dashboard</a> | 
                <a href="buyer_dashboard.php">→ Ke Buyer Dashboard</a>
            </p>
        </body>
        </html>
        ');
    } else {
        die('
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Setup Stok Realtime - Error</title>
            <style>
                body { font-family: Arial; max-width: 600px; margin: 50px auto; padding: 20px; }
                .error { background: #ffebee; padding: 20px; border-radius: 5px; border-left: 4px solid #f44336; }
            </style>
        </head>
        <body>
            <div class="error">
                <h2>❌ Setup Gagal</h2>
                <p><strong>Error:</strong> ' . mysqli_error($conn) . '</p>
                <p>Coba jalankan query SQL ini di phpMyAdmin:</p>
                <pre style="background: #f5f5f5; padding: 10px; overflow-x: auto;">
ALTER TABLE `obat` ADD COLUMN `stok` INT(11) NOT NULL DEFAULT 0 AFTER `harga`;
UPDATE `obat` SET `stok` = 100;
                </pre>
            </div>
        </body>
        </html>
        ');
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Fitur Stok Realtime</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 100%;
            padding: 40px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }
        
        .header p {
            color: #666;
            font-size: 14px;
        }
        
        .icon {
            font-size: 50px;
            margin-bottom: 15px;
            display: block;
        }
        
        .features {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 25px 0;
        }
        
        .features h3 {
            font-size: 16px;
            color: #333;
            margin-bottom: 15px;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            font-size: 14px;
            color: #555;
        }
        
        .feature-item:last-child {
            margin-bottom: 0;
        }
        
        .feature-item i {
            color: #4caf50;
            font-weight: bold;
        }
        
        .info-box {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            font-size: 13px;
            color: #1565c0;
            line-height: 1.6;
        }
        
        .setup-form {
            text-align: center;
        }
        
        button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 14px 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-bottom: 10px;
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        button:active {
            transform: translateY(0);
        }
        
        .secondary-btn {
            background: #f0f0f0;
            color: #333;
            margin-top: 10px;
        }
        
        .secondary-btn:hover {
            background: #e0e0e0;
            box-shadow: none;
        }
        
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <span class="icon">📦</span>
            <h1>Fitur Stok Realtime</h1>
            <p>Setup Sistem Manajemen Stok Obat</p>
        </div>
        
        <div class="features">
            <h3>🎯 Fitur yang akan diaktifkan:</h3>
            <div class="feature-item">
                <span>✓</span> Restok obat di Admin Dashboard
            </div>
            <div class="feature-item">
                <span>✓</span> Tampil stok realtime di Buyer Dashboard
            </div>
            <div class="feature-item">
                <span>✓</span> API manajemen stok
            </div>
            <div class="feature-item">
                <span>✓</span> Auto-refresh setiap 2-3 detik
            </div>
        </div>
        
        <div class="info-box">
            <strong>ℹ️ Info:</strong> Proses ini akan menambahkan kolom <code>stok</code> ke tabel obat dan set default stok = 100 untuk semua obat yang sudah ada.
        </div>
        
        <div class="setup-form">
            <form method="POST">
                <input type="hidden" name="action" value="setup">
                <button type="submit">🚀 Setup Sekarang</button>
            </form>
            
            <a href="admin_dashboard.php">
                <button class="secondary-btn">← Kembali ke Dashboard</button>
            </a>
        </div>
        
        <div class="footer">
            <p>Pastikan Anda sudah backup database sebelum melanjutkan</p>
        </div>
    </div>
</body>
</html>
