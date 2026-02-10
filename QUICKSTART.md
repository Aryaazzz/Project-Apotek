## 🚀 Quick Start - Fitur Stok Realtime

### Langkah 1: Jalankan Setup
1. Buka browser dan akses: `http://localhost/apotek/setup_stok.php`
2. Klik tombol **"🚀 Setup Sekarang"**
3. Tunggu hingga setup selesai

### Langkah 2: Login sebagai Admin
1. Akses `http://localhost/apotek/admin_dashboard.php`
2. Login dengan akun admin
3. Masuk ke menu **"Daftar Obat & Kelola Stok"**

### Langkah 3: Coba Restok
1. Klik tombol **"Restok"** (warna ungu) pada salah satu obat
2. Masukkan jumlah yang ingin ditambahkan
3. Klik **"Simpan Restok"**
4. Lihat perubahan stok secara instant!

### Langkah 4: Lihat di Buyer Dashboard
1. Login sebagai pembeli
2. Akses `http://localhost/apotek/buyer_dashboard.php`
3. Di bagian "Daftar Obat Tersedia", lihat badge stok di setiap obat
4. Refresh halaman atau tunggu 3 detik untuk melihat stok update realtime

---

## 📂 File yang Ditambahkan

```
apotek/
├── api/
│   └── manage_stok.php          ← API untuk stok management
├── db/
│   └── migration_add_stok.sql    ← SQL migration file
├── setup_stok.php               ← Setup wizard
├── FITUR_STOK_REALTIME.md       ← Dokumentasi lengkap
└── QUICKSTART.md                ← File ini
```

---

## ✨ Fitur Utama

### Admin Dashboard 📊
- ✅ Lihat stok semua obat dalam satu tabel
- ✅ Restok obat langsung dari dashboard (tanpa halaman baru)
- ✅ Modal input yang user-friendly
- ✅ Indikator stok dengan warna (Hijau/Oranye/Merah)
- ✅ Toast notification untuk feedback

### Buyer Dashboard 👥
- ✅ Lihat stok realtime di setiap kartu obat
- ✅ Badge stok dengan indikator: "Tersedia", "Stok Terbatas", "Habis"
- ✅ Auto-update setiap 3 detik (tanpa reload manual)
- ✅ Obat yang habis tetap ditampilkan dengan opacity berkurang
- ✅ Responsive design di mobile

### API Realtime ⚡
- ✅ GET stok single obat
- ✅ GET semua stok dengan pagination support
- ✅ POST update stok (tambah/kurang)
- ✅ Filter stok untuk buyer (hanya yang > 0)
- ✅ Error handling & validation

---

## 🔑 Endpoints API

```bash
# Get stok obat tertentu
GET /api/manage_stok.php?action=get_stok&obat_id=1

# Get semua stok
GET /api/manage_stok.php?action=get_all_stok

# Update/Restok obat
POST /api/manage_stok.php?action=update_stok
Body: {
  "obat_id": 1,
  "jumlah": 20,
  "tipe": "tambah"
}

# Get stok untuk buyer (hanya stok > 0)
GET /api/manage_stok.php?action=get_stok_pembeli
```

---

## 🎨 Visual Indicators

### Stok Status di Admin
```
Stok ≥ 10  → 🟢 Hijau (Normal)
Stok < 10  → 🟠 Oranye (Limited)
Stok = 0   → 🔴 Merah (Habis)
```

### Stok Badge di Buyer
```
📦 Tersedia: 25        (Hijau)
📦 Stok Terbatas: 5    (Oranye)
📦 Habis: 0           (Merah)
```

---

## ⚙️ Konfigurasi Interval Update

Edit di JavaScript untuk mengubah interval:

**Admin Dashboard** (`admin_dashboard.php`):
```javascript
setInterval(loadPesanan, 10000);  // Setiap 10 detik
```

**Buyer Dashboard** (`buyer_dashboard.php`):
```javascript
setInterval(loadDaftarObat, 3000);      // Setiap 3 detik
setInterval(loadStatusPesanan, 2000);   // Setiap 2 detik
```

---

## 🐛 Troubleshooting

### Kolom stok tidak ada di tabel
**Solusi:**
1. Jalankan `setup_stok.php` lagi
2. Atau jalankan query manual di phpMyAdmin:
```sql
ALTER TABLE `obat` ADD COLUMN `stok` INT(11) NOT NULL DEFAULT 0 AFTER `harga`;
```

### Restok button tidak merespons
**Solusi:**
1. Buka Console (F12) dan lihat error message
2. Pastikan admin sudah login
3. Pastikan `api/manage_stok.php` accessible

### Stok tidak update di buyer dashboard
**Solusi:**
1. Cek internet connection
2. Periksa browser console untuk error
3. Pastikan session pembeli masih aktif

### API returns 403 Forbidden
**Solusi:**
- API hanya bisa diakses oleh admin
- Pastikan sudah login sebagai admin

---

## 📊 Database Schema

Setelah setup, tabel `obat` akan memiliki struktur:

```sql
CREATE TABLE `obat` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,  ← KOLOM BARU
  `gambar` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## 💾 Backup Database

Sebelum running setup, pastikan backup database:

**Via Command Line:**
```bash
mysqldump -u root -p apotek > backup_apotek.sql
```

**Via phpMyAdmin:**
1. Export database `apotek`
2. Save file backup

---

## 📝 Catatan Penting

- Fitur ini menggunakan **polling** (fetch setiap 2-3 detik), bukan WebSocket
- Untuk production, consider menggunakan WebSocket untuk efisiensi
- Default stok setelah setup = 100 untuk semua obat
- Admin bisa restore stok ke default dengan SQL: `UPDATE obat SET stok = 100`

---

## 🎯 Use Cases

**Skenario 1: Obat Habis**
```
1. Admin restok obat Paracetamol: 0 → 50
2. Buyer langsung lihat badge berubah: "Habis" → "Tersedia: 50"
3. Tidak perlu reload manual
```

**Skenario 2: Stok Terbatas**
```
1. Admin restok obat Ibuprofen: 15 → 8
2. Badge berubah dari hijau ke oranye
3. Buyer tahu stok sedang terbatas
```

---

## 🔗 Links Useful

- Admin: `http://localhost/apotek/admin_dashboard.php`
- Buyer: `http://localhost/apotek/buyer_dashboard.php`
- Setup: `http://localhost/apotek/setup_stok.php`
- Docs: `FITUR_STOK_REALTIME.md`

---

**Created:** 10 February 2026  
**Version:** 1.0  
**Status:** ✅ Production Ready
