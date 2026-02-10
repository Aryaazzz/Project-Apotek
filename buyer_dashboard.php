<?php
session_start();
require "config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'pembeli') {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user_id'];

$data = mysqli_query($conn, "SELECT * FROM obat ORDER BY nama ASC");

if (!$data) {
    die("Query obat error: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Pembeli</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
  
@keyframes float {
  0%,100% { transform: translateY(0); }
  50% { transform: translateY(-12px); }
}
.float {
  animation: float 6s ease-in-out infinite;
}

body.dark{
  background:linear-gradient(135deg,#0f172a,#052e16);
  color:#e5e7eb;
}

body.dark .obat-card,
body.dark form,
body.dark #statusPesanan,
body.dark footer{
  background:rgba(15,23,42,.85);
  color:#e5e7eb;
}

/* ===============================
   MEDICAL BACKGROUND
================================ */
.medical-bg{
  position:fixed;
  inset:0;
  z-index:-1;
  overflow:hidden;
  pointer-events:none;
}

/* PILLS */
.pill{
  position:absolute;
  bottom:-60px;
  width:44px;
  height:18px;
  border-radius:999px;
  background:linear-gradient(90deg,#66bb6a 50%,#ffffff 50%);
  opacity:.22;
  animation:floatUp 20s linear infinite;
}

.pill::after{
  content:'';
  position:absolute;
  left:50%;
  top:0;
  width:2px;
  height:100%;
  background:#e0e0e0;
}

/* MEDICAL PLUS */
.plus{
  position:absolute;
  bottom:-40px;
  font-size:28px;
  color:#4caf50;
  opacity:.18;
  animation:floatUpRotate 24s linear infinite;
}

/* ANIMATIONS */
@keyframes floatUp{
  from{
    transform:translateY(0) rotate(0deg);
  }
  to{
    transform:translateY(-120vh) rotate(360deg);
  }
}

@keyframes floatUpRotate{
  from{
    transform:translateY(0) rotate(0deg);
  }
  to{
    transform:translateY(-120vh) rotate(-360deg);
  }
}

body::before{
  content:'';
  position:fixed;
  inset:0;
  background:
    radial-gradient(circle at 15% 20%, rgba(76,175,80,.15), transparent 40%),
    radial-gradient(circle at 85% 80%, rgba(102,187,106,.12), transparent 45%);
  z-index:-2;
  animation: backgroundShift 10s ease-in-out infinite alternate;
}

@keyframes backgroundShift {
  0% { opacity: 0.8; }
  100% { opacity: 1; }
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in-up {
  animation: fadeInUp 0.8s ease-out;
}

main > section {
  animation: fadeInUp 0.8s ease-out;
}

main > section:nth-child(1) { animation-delay: 0.1s; }
main > section:nth-child(2) { animation-delay: 0.2s; }
main > section:nth-child(3) { animation-delay: 0.3s; }
main > section:nth-child(4) { animation-delay: 0.4s; }
main > section:nth-child(5) { animation-delay: 0.5s; }
main > section:nth-child(6) { animation-delay: 0.6s; }


.review-title{
  font-size:1.8rem;
  font-weight:700;
  color:#2e7d32;
  display:flex;
  align-items:center;
  gap:10px;
  letter-spacing:.3px;
  position:relative;
  display:flex;
  justify-content:center;
  align-items:center;
}

.review-title i{
  font-size:1.2rem;
  color:#66bb6a;
  transform:translateY(1px);
}

.review-title::after{
  content:'';
  position:absolute;
  left:50%;
  bottom:-10px;
  width:0;
  height:3px;
  background:linear-gradient(90deg,#66bb6a,#4caf50);
  border-radius:999px;
  transform:translateX(-50%);
  transition:width .45s cubic-bezier(.22,.61,.36,1);
}

/* hover effect */
.review-title:hover::after{
  width:70%;
}

.review-section{
  margin-top:40px;
  background:var(--glass);
  padding:30px;
  border-radius:var(--radius);
  box-shadow:var(--shadow-soft);
  max-width:1100px;
  width:100%;
  overflow:hidden;
}
.review-section h2{
  display:flex;
  justify-content:center;
  align-items:center;
}

.review-container{
  display:flex;
  gap:18px;
  animation:autoScroll 40s linear infinite;
}
.review-section:hover .review-container{
  animation-play-state:paused;
}

@keyframes autoScroll{
  to{transform:translateX(-50%)}
}

.review-card{
  min-width:240px;
  background:#f9f9f9;
  padding:18px;
  border-radius:14px;
  text-align:center;
  transition:all .7s ease;
}

.review-card p{
  font-style:italic;
  color:#444;
  line-height:1.6;
}

.review-card .author{
  margin-top:10px;
  font-weight:600;
  color:#2e7d32;
}

.review-card:hover{
  transform:translateY(-5px);
  box-shadow:0 12px 28px rgba(0,0,0,.16);
}

.keluhan-box {
  display: flex;
  gap: 10px;
  max-width: 400px;
}

.keluhan-box input {
  flex: 1;
  padding: 10px;
  border-radius: 6px;
  border: 1px solid #ccc;
  font-size: 14px;
}

.btn-kirim {
  padding: 10px 16px;
  background: #2ecc71;
  border: none;
  border-radius: 6px;
  color: #fff;
  font-weight: bold;
  cursor: pointer;
}

.btn-kirim:hover {
  background: #27ae60;
}

.info-text {
  margin-top: 10px;
  color: #555;
  font-size: 14px;
}

</style>
</head>

<body class="bg-gradient-to-br from-blue-50 via-green-50 to-green-100 min-h-screen text-gray-700 overflow-x-hidden">

<div class="medical-bg">
  <span class="pill" style="left:10%; animation-delay:0s;"></span>
  <span class="pill" style="left:35%; animation-delay:6s;"></span>
  <span class="pill" style="left:60%; animation-delay:12s;"></span>
  <span class="pill" style="left:80%; animation-delay:3s;"></span>

  <span class="plus" style="left:20%; animation-delay:4s;">+</span>
  <span class="plus" style="left:50%; animation-delay:10s;">+</span>
  <span class="plus" style="left:70%; animation-delay:15s;">+</span>
</div>

<!-- HEADER -->
<header class="bg-gradient-to-r from-green-600 to-blue-600 shadow-2xl sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 py-6 flex items-center justify-between">
    <div class="flex items-center gap-4">
      <div class="w-14 h-14 rounded-full bg-white bg-opacity-20 text-white flex items-center justify-center text-2xl shadow-lg">
        <i class="fas fa-pills"></i>
      </div>
      <div class="text-white">
        <h1 class="text-2xl font-bold">Apotek Kelompok Satu</h1>
        <p class="text-sm text-green-100">Portal Pesanan Obat</p>
      </div>
    </div>
    <a href="auth/logout.php" class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg transition duration-300 transform hover:scale-105 font-medium shadow-lg">
      <i class="fas fa-sign-out-alt"></i> Logout
    </a>
  </div>
</header>

<main class="max-w-7xl mx-auto px-4 py-12 space-y-16">"
<!-- DAFTAR OBAT -->
<section class="bg-white rounded-2xl shadow-lg p-8">
  <h2 class="text-3xl font-bold text-green-700 mb-2 flex items-center gap-3">
    <i class="fas fa-capsules text-green-600 text-2xl"></i> Daftar Obat Tersedia
  </h2>
  <p class="text-gray-600 mb-8">Lihat berbagai pilihan obat yang tersedia di apotek kami</p>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <?php while ($o = mysqli_fetch_assoc($data)) : ?>
    <div class="group bg-gradient-to-br from-white to-green-50 rounded-2xl shadow-md hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-green-300">
      
      <div class="relative h-40 bg-gradient-to-br from-green-100 to-blue-50 flex items-center justify-center overflow-hidden">
        <img src="<?= $o['gambar'] ?>" class="h-32 object-contain transition-transform duration-500 group-hover:scale-125">
        <span class="absolute top-3 right-3 bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">
          <?= $o['kategori'] ?>
        </span>
      </div>

      <div class="p-5 space-y-3">
        <h3 class="font-bold text-lg text-gray-800 line-clamp-2"><?= $o['nama'] ?></h3>
        
        <p class="text-sm text-gray-600 line-clamp-2">
          <?= $o['deskripsi'] ?? 'Obat berkualitas tinggi' ?>
        </p>
        
        <div class="border-t border-gray-200 pt-3 flex items-center justify-between">
          <span class="text-2xl font-bold text-green-600">
            Rp<?= number_format($o['harga']) ?>
          </span>
          <div class="flex items-center justify-center w-10 h-10 rounded-full bg-green-100 text-green-600 font-bold">
            ✓
          </div>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</section>

<!-- FORM KELUHAN & STATUS -->
<section class="grid md:grid-cols-2 gap-8">
  <!-- Form Input -->
  <div class="bg-white rounded-2xl shadow-lg p-8 border-l-4 border-blue-500">
    <h2 class="text-2xl font-bold text-gray-800 mb-2 flex items-center gap-3">
      <i class="fas fa-comment-medical text-blue-500 text-xl"></i> Konsultasi Keluhan
    </h2>
    <p class="text-gray-600 text-sm mb-6">Ceritakan keluhan Anda kepada apoteker kami</p>

    <div class="space-y-5">
      <!-- Nama -->
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          <i class="fas fa-user text-blue-500 mr-2"></i>Nama Anda
        </label>
        <input
          type="text"
          id="nama_pembeli"
          placeholder="Masukkan nama lengkap"
          class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-blue-500 transition-all duration-300 hover:shadow-md text-gray-800"
        >
      </div>

      <!-- Keluhan -->
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          <i class="fas fa-stethoscope text-blue-500 mr-2"></i>Keluhan / Gejala
        </label>
        <textarea
          id="keluhan"
          rows="5"
          placeholder="Jelaskan keluhan atau gejala yang Anda alami secara detail..."
          class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-blue-500 transition-all duration-300 hover:shadow-md resize-none text-gray-800"
        ></textarea>
      </div>

      <!-- Tombol -->
      <button
        id="kirimKeluhan"
        class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 rounded-xl font-bold flex items-center justify-center gap-3 hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105"
      >
        <i class="fas fa-paper-plane text-lg"></i>
        Kirim Keluhan ke Admin
      </button>
    </div>
  </div>

  <!-- Status Pesanan -->
  <div class="bg-gradient-to-br from-white via-green-50 to-green-100 rounded-2xl shadow-lg p-8 border-l-4 border-green-500">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
      <i class="fas fa-clipboard-check text-green-600 text-xl animate-pulse"></i> Status Pesanan Anda
    </h2>
    
    <div id="statusPesanan" class="space-y-4">
      <div class="text-center py-12">
        <div class="flex justify-center mb-4">
          <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center">
            <i class="fas fa-hourglass-half text-gray-500 text-2xl animate-bounce"></i>
          </div>
        </div>
        <p class="text-gray-600 font-medium">Menunggu keluhan Anda...</p>
        <p class="text-sm text-gray-500 mt-2">Kirim keluhan di form sebelah untuk memulai</p>
      </div>
    </div>
  </div>
</section>

<!-- Section Review Apotek - Horizontal Scroll (ASLI, TIDAK DIUBAH) -->
 <h2 class="review-title">
  <i class="fas fa-star"></i>
  Review Apotek Kami
</h2>
 <section class="max-w-6xl mx-auto px-4">
<div class="review-section">
  <div class="review-container">
    <div class="review-card">
      <div class="stars">★★★★★</div>
      <p>"Pelayanan cepat dan obatnya berkualitas."</p>
      <div class="author">- Arya P.</div>
    </div>
    <div class="review-card">
      <div class="stars">★★★★☆</div>
      <p>"Apotek ini selalu stok obat lengkap."</p>
      <div class="author">- Reva A.</div>
    </div>
    <div class="review-card">
      <div class="stars">★★★★★</div>
      <p>"Dokter di sini sangat profesional."</p>
      <div class="author">- Regina A.</div>
    </div>
    <div class="review-card">
      <div class="stars">★★★★☆</div>
      <p>"Lokasi strategis dan jam operasional fleksibel."</p>
      <div class="author">- Raditya E.</div>
    </div>
    <div class="review-card">
      <div class="stars">★★★★★</div>
      <p>"Pengalaman belanja yang menyenangkan."</p>
      <div class="author">- Nida</div>
    </div>
    <div class="review-card">
      <div class="stars">★★★★☆</div>
      <p>"Stafnya friendly dan informatif."</p>
      <div class="author">- Kelompok Sebelah</div>
    </div>
  </div>
</div>
</section>


<!-- FOOTER -->
<footer class="bg-gradient-to-r from-green-600 to-blue-600 rounded-2xl shadow-lg p-8 text-white text-center space-y-4">
  <h3 class="text-2xl font-bold">Apotek Kelompok Satu</h3>
  <div class="h-1 w-20 bg-white bg-opacity-30 mx-auto rounded-full"></div>
  <div class="grid md:grid-cols-3 gap-6 py-4">
    <div>
      <p class="flex items-center justify-center gap-2 font-semibold">
        <i class="fas fa-phone text-lg"></i> +62 123 456 7890
      </p>
    </div>
    <div>
      <p class="flex items-center justify-center gap-2 font-semibold">
        <i class="fas fa-envelope text-lg"></i> info@apotek.com
      </p>
    </div>
    <div>
      <p class="flex items-center justify-center gap-2 font-semibold">
        <i class="fas fa-map-marker-alt text-lg"></i> Jl. Kesehatan No.123
      </p>
    </div>
  </div>
  <p class="text-sm text-green-100 pt-4 border-t border-white border-opacity-20">
    © 2026 Apotek Kelompok Satu. Semua hak dilindungi. | Kesehatan Anda Prioritas Kami
  </p>
</footer>

</main>


<!-- STATUS SCRIPT (TIDAK DIUBAH LOGIC) -->
<script>
document.getElementById("kirimKeluhan").addEventListener("click", () => {
  const nama = document.getElementById("nama_pembeli").value.trim();
  const keluhan = document.getElementById("keluhan").value.trim();

  if (!nama || !keluhan) {
    alert("Nama dan keluhan wajib diisi!");
    return;
  }

  fetch("api/kirim_keluhan.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `nama_pembeli=${encodeURIComponent(nama)}&keluhan=${encodeURIComponent(keluhan)}`
  })
  .then(res => res.text())
  .then(res => {
    if (res.trim() === "ok") {
      alert("Keluhan terkirim✅, Silahkan lihat Status pesanan untuk informasi lebih lanjut!");
      document.getElementById("keluhan").value = "";
      loadStatusPesanan(); // refresh langsung
    } else {
      alert("Gagal: " + res);
    }
  });
});

async function loadStatusPesanan(){
  const res = await fetch("api/cek_status.php")
  const data = await res.json();

  const box = document.getElementById("statusPesanan");

  if(data.status === "kosong"){
    box.innerHTML = "❌ Belum ada pesanan";
    return;
  }

  if(data.status === "proses"){
    box.innerHTML = "⏳ Pesanan akan masuk ke admin dalam 15 detik, harap sabar...";
    return;
  }

  if(data.status === "selesai"){
  let html = data.obat.map(o => `
    <div style="
      display:flex;
      align-items:center;
      gap:12px;
      padding:12px;
      margin-top:10px;
      border-radius:14px;
      background:#f0fdf4;
    ">
      <img src="${o.gambar}" style="width:60px;height:60px;object-fit:contain;">
      <div style="text-align:left;">
        <b>${o.nama}</b><br>
        <small style="color:#16a34a">
          Rp${Number(o.harga).toLocaleString("id-ID")}
        </small>
      </div>
    </div>
  `).join("");

  box.innerHTML = `
    ✅ <br>Pesanan selesai <br>Silahkan ke kasir untuk membawa dan membayar obat</b><br><br>
    <b>Obat untuk kamu:</b>
    ${html}
    <hr style="margin:14px 0">
    <b>Total: Rp${Number(data.total).toLocaleString("id-ID")}</b>
    <br><br>
    ⏳ Pesanan akan direset dalam 10 detik...
  `;

  // ⏱️ AUTO RESET 10 DETIK
  setTimeout(() => {
    fetch("api/reset_pesanan.php")
      .then(res => res.json())
      .then(() => {
        
      });
  }, 10000);

  return;
}
}
// ✅ PANGGIL YANG BENAR
setInterval(loadStatusPesanan, 2000);
loadStatusPesanan();
</script>


</body>
</html>
