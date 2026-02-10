# Panduan Fitur Restok Obat & Stok Realtime

## 📋 Overview

Fitur ini memungkinkan admin untuk mengelola stok obat dan buyer untuk melihat ketersediaan obat secara realtime.

## 🔧 Instalasi

### 1. Update Database Schema

Jalankan query SQL berikut di phpMyAdmin atau MySQL CLI:

```sql
ALTER TABLE `obat` ADD COLUMN `stok` INT(11) NOT NULL DEFAULT 0 AFTER `harga`;

-- Set default stock untuk obat yang sudah ada (opsional)
UPDATE `obat` SET `stok` = 100 WHERE `stok` = 0;
```

Atau gunakan file migration yang sudah dibuat:
- File: `db/migration_add_stok.sql`

### 2. Verifikasi File API

Pastikan file berikut sudah ada di folder `api/`:
- `manage_stok.php` - API untuk mengelola stok obat

## 📱 Fitur Admin Dashboard

### A. Lihat Stok Obat
- Masuk ke menu **"Daftar Obat & Kelola Stok"**
- Tabel menampilkan kolom baru: **Stok 📦**
- Stok ditampilkan dengan warna:
  - 🟢 **Hijau**: Stok normal (≥ 10)
  - 🟠 **Oranye**: Stok terbatas (< 10)
  - 🔴 **Merah**: Habis (0)

### B. Restok Obat
1. Klik tombol **"Restok"** (ikon ungu dengan +) pada baris obat
2. Modal akan menampilkan:
   - Nama obat
   - Stok saat ini
   - Input jumlah tambah
   - Preview stok setelah restok
3. Masukkan jumlah yang ingin ditambahkan
4. Klik **"Simpan Restok"**
5. Sistem akan update stok ke database secara langsung

### C. Fitur Realtime
- Stok diperbarui secara **instant** ketika restok dilakukan
- Tidak perlu reload halaman
- Toast notification akan muncul untuk konfirmasi

## 🛒 Fitur Buyer Dashboard

### A. Lihat Stok Realtime
- Bagian **"Daftar Obat Tersedia"** menampilkan:
  - **Gambar obat**
  - **Nama obat**
  - **Kategori**
  - **Harga**
  - **Badge Stok** (📦 Stok dengan warna indikator)

### B. Indikator Stok
```
🟢 Tersedia (Hijau)    → Stok ≥ 5
🟠 Stok Terbatas (Kuning) → Stok 1-4
🔴 Habis (Merah)       → Stok 0
```

### C. Update Realtime
- Daftar obat **direfresh setiap 3 detik**
- Jika admin melakukan restok, buyer akan **otomatis melihat perubahan stok**
- Tidak perlu reload manual

## 🔌 API Endpoints

### 1. Get Stok Obat (Admin)
```
GET api/manage_stok.php?action=get_stok&obat_id=1
```
**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "nama": "Paracetamol",
    "stok": 50
  }
}
```

### 2. Get Semua Stok (Admin)
```
GET api/manage_stok.php?action=get_all_stok
```
**Response:**
```json
{
  "success": true,
  "data": [
    {"id": 1, "nama": "Paracetamol", "stok": 50, "harga": 13000, "kategori": "Pereda Nyeri"},
    ...
  ]
}
```

### 3. Update Stok (Restok)
```
POST api/manage_stok.php?action=update_stok
Content-Type: application/json

{
  "obat_id": 1,
  "jumlah": 20,
  "tipe": "tambah"  // atau "kurang"
}
```
**Response:**
```json
{
  "success": true,
  "message": "Stok berhasil diupdate",
  "data": {
    "obat_id": 1,
    "stok_lama": 30,
    "stok_baru": 50,
    "perubahan": "+20"
  }
}
```

### 4. Get Stok untuk Buyer
```
GET api/manage_stok.php?action=get_stok_pembeli
```
**Response:** Menampilkan hanya obat yang stoknya > 0
```json
{
  "success": true,
  "data": [
    {"id": 1, "nama": "Paracetamol", "stok": 50, "harga": 13000, "kategori": "Pereda Nyeri", "gambar": "..."},
    ...
  ],
  "timestamp": 1707560000
}
```

## 🔐 Keamanan

- **Admin saja** yang bisa mengakses API `manage_stok.php`
- Session check dilakukan di API
- Input validation untuk semua parameter
- Error handling yang proper

## ⚙️ Interval Update

- **Admin Dashboard**: Pesanan update setiap 10 detik
- **Buyer Dashboard**: 
  - Obat/Stok update setiap **3 detik**
  - Status pesanan update setiap **2 detik**

## 🐛 Troubleshooting

### Stok tidak muncul di buyer dashboard
1. Pastikan kolom `stok` sudah ditambahkan ke tabel `obat`
2. Pastikan `api/manage_stok.php` ada dan tidak ada error
3. Buka browser console (F12) dan lihat error message

### Restok tidak bekerja di admin
1. Pastikan user sudah login sebagai admin
2. Cek di browser console apakah ada error JavaScript
3. Pastikan `api/manage_stok.php` accessible

### Realtime tidak update
1. Periksa internet connection
2. Cek apakah browser memblok CORS (jarang terjadi di localhost)
3. Pastikan PHP session masih aktif

## 📝 Database Schema Update

Struktur tabel `obat` setelah update:
```sql
CREATE TABLE `obat` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,  -- ← KOLOM BARU
  `gambar` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

## 🎯 Fitur-Fitur yang Ditambahkan

### Admin Dashboard (`admin_dashboard.php`)
✅ Tambah kolom Stok di tabel daftar obat
✅ Tambah tombol Restok (ungu)
✅ Modal input restok dengan preview
✅ Real-time stok update tanpa reload

### Buyer Dashboard (`buyer_dashboard.php`)
✅ Load obat via API (bukan dari PHP loop)
✅ Tampilkan badge stok di setiap kartu obat
✅ Auto-update stok setiap 3 detik
✅ Indikator warna status stok
✅ Tampilkan status "Tersedia", "Stok Terbatas", atau "Habis"

### API (`api/manage_stok.php`)
✅ Get stok single obat
✅ Get semua stok untuk admin
✅ Update stok (tambah/kurang)
✅ Get stok untuk buyer (filter stok > 0)
✅ Error handling & validation

## 💡 Tips

- Bisa mengatur interval update dengan mengubah `setInterval()` di JavaScript
- Stok realtime bekerja karena fetch API polling setiap 2-3 detik
- Untuk performa lebih baik, bisa implementasi WebSocket di masa depan
- Admin bisa melihat total stok di dashboard dengan menambahkan query agregasi

---

**Last Updated:** 10 February 2026
**Version:** 1.0
