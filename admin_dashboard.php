<?php
session_start();
require "config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit;
}

$totalObat = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM obat"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Apotek</title>

<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
  background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 25%, #dcfce7 50%, #f0fdf4 75%, #ecfeff 100%);
  background-size: 200% 200%;
  animation: bg 15s ease infinite;
}
@keyframes bg{
  0%{background-position: 0% 50%}
  50%{background-position: 100% 50%}
  100%{background-position: 0% 50%}
}
.card {
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
.card:hover {
  transform: translateY(-10px) scale(1.02);
  box-shadow: 0 20px 40px rgba(34, 197, 94, 0.15);
}
.section {
  display: none;
}
.section.active {
  display: block;
  animation: fade 0.4s ease;
}
@keyframes fade {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
</head>

<body class="min-h-screen text-gray-700 bg-gray-50">

<div class="flex min-h-screen">

<!-- SIDEBAR -->
<aside class="w-64 bg-white shadow-xl flex flex-col">
  <div class="p-8 text-center border-b-2 border-gray-200">
    <div class="w-16 h-16 mx-auto rounded-full bg-gradient-to-br from-green-500 to-green-600 text-white flex items-center justify-center text-3xl shadow-lg">
      <i class="fas fa-capsules"></i>
    </div>
    <h2 class="mt-4 font-bold text-xl text-green-700">Admin Apotek</h2>
    <p class="text-xs text-gray-500 mt-1">Manajemen Obat</p>
  </div>

  <nav class="p-5 space-y-1 flex-1">
    <button onclick="showSection('dashboard')" class="w-full px-4 py-3 rounded-lg bg-green-100 text-green-700 font-semibold transition hover:bg-green-200 flex items-center gap-3">
      <i class="fas fa-chart-line w-5 text-center"></i> <span>Dashboard</span>
    </button>
    <button onclick="showSection('tambah')" class="w-full px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 font-medium transition flex items-center gap-3">
      <i class="fas fa-plus w-5 text-center text-green-600"></i> <span>Tambah Obat</span>
    </button>
    <button onclick="showSection('obat')" class="w-full px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 font-medium transition flex items-center gap-3">
      <i class="fas fa-list w-5 text-center text-green-600"></i> <span>Daftar Obat</span>
    </button>
    <button onclick="showSection('pesanan')" class="w-full px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 font-medium transition flex items-center gap-3">
      <i class="fas fa-shopping-box w-5 text-center text-green-600"></i> <span>Pesanan</span>
    </button>
  </nav>

  <div class="p-5 border-t-2 border-gray-200">
    <a href="auth/logout.php" class="block text-center bg-gradient-to-r from-red-500 to-red-600 text-white py-3 rounded-lg font-medium hover:from-red-600 hover:to-red-700 transition flex items-center justify-center gap-2">
      <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
    </a>
  </div>
</aside>

<!-- MAIN -->
<div class="flex-1 flex flex-col">

<header class="bg-white shadow-md px-8 py-5 flex items-center gap-3 border-b-2 border-green-100">
  <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-green-500 to-green-600 text-white flex items-center justify-center text-xl">
    <i class="fas fa-home"></i>
  </div>
  <h1 class="text-2xl font-bold text-green-700">
    Dashboard Admin
  </h1>
</header>

<main class="p-8 space-y-8 bg-gray-50 flex-1">

<!-- DASHBOARD -->
<section id="dashboard" class="section active">
  <div class="bg-gradient-to-r from-green-500 to-green-600 p-10 rounded-2xl shadow-lg text-white text-center mb-10">
    <h2 class="text-3xl font-bold mb-2">Selamat Datang Apoteker</h2>
    <p class="text-green-100">Kelola data obat dan pesanan dengan mudah 💪💊</p>
  </div>

  <div class="grid md:grid-cols-3 gap-6 w-full">
    <div class="bg-white p-8 rounded-2xl shadow-md card hover:shadow-xl text-center border-t-4 border-green-500">
      <div class="w-14 h-14 mx-auto rounded-full bg-green-100 text-green-600 flex items-center justify-center text-3xl mb-4">
        <i class="fas fa-pills"></i>
      </div>
      <p class="text-gray-600 text-sm mb-1">Total Obat</p>
      <h2 class="text-4xl font-bold text-green-600"><?= $totalObat ?></h2>
    </div>
    <div class="bg-white p-8 rounded-2xl shadow-md card hover:shadow-xl text-center border-t-4 border-blue-500">
      <div class="w-14 h-14 mx-auto rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-3xl mb-4">
        <i class="fas fa-clock"></i>
      </div>
      <p class="text-gray-600 text-sm mb-1">Status</p>
      <h2 class="text-2xl font-bold text-blue-600">Realtime</h2>
    </div>
    <div class="bg-white p-8 rounded-2xl shadow-md card hover:shadow-xl text-center border-t-4 border-purple-500">
      <div class="w-14 h-14 mx-auto rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-3xl mb-4">
        <i class="fas fa-check-circle"></i>
      </div>
      <p class="text-gray-600 text-sm mb-1">Sistem</p>
      <h2 class="text-2xl font-bold text-purple-600">Aktif</h2>
    </div>
  </div>
</section>

<!-- TAMBAH OBAT -->
<section id="tambah" class="section bg-white p-8 rounded-2xl shadow-md">
<h3 class="text-2xl font-bold text-green-700 mb-6 flex items-center gap-2">
  <i class="fas fa-plus-circle"></i> Tambah Obat Baru
</h3>
<form action="admin_obat_tambah.php" method="POST" class="grid md:grid-cols-2 gap-5">
  <input name="nama" placeholder="Nama Obat" class="border-2 border-gray-300 p-3 rounded-lg focus:outline-none focus:border-green-500" required>
  <input name="kategori" placeholder="Kategori" class="border-2 border-gray-300 p-3 rounded-lg focus:outline-none focus:border-green-500" required>
  <input name="harga" type="number" placeholder="Harga" class="border-2 border-gray-300 p-3 rounded-lg focus:outline-none focus:border-green-500" required>
  <input name="gambar" placeholder="URL Gambar" class="border-2 border-gray-300 p-3 rounded-lg focus:outline-none focus:border-green-500" required>
  <textarea name="deskripsi" placeholder="Deskripsi" class="border-2 border-gray-300 p-3 rounded-lg focus:outline-none focus:border-green-500 md:col-span-2 resize-none" rows="4"></textarea>
  <button class="bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-lg md:col-span-2 font-semibold hover:from-green-600 hover:to-green-700 transition flex items-center justify-center gap-2">
    <i class="fas fa-save"></i> Simpan Obat
  </button>
</form>
</section>

<!-- DAFTAR OBAT -->
<section id="obat" class="section bg-white p-8 rounded-2xl shadow-md">
<h3 class="text-2xl font-bold text-green-700 mb-6 flex items-center gap-2">
  <i class="fas fa-list"></i> Daftar Obat
</h3>
<div class="overflow-x-auto">
<table class="w-full">
<thead class="bg-gradient-to-r from-green-500 to-green-600 text-white">
<tr>
  <th class="p-4 text-left font-semibold">Nama Obat</th>
  <th class="p-4 text-left font-semibold">Kategori</th>
  <th class="p-4 text-left font-semibold">Harga</th>
  <th class="p-4 text-center font-semibold">Aksi</th>
</tr>
</thead>
<tbody>
<?php
$q=mysqli_query($conn,"SELECT * FROM obat ORDER BY id DESC");
while($o=mysqli_fetch_assoc($q)):
?>
<tr class="border-b hover:bg-gray-50 transition">
<td class="p-4"><?= htmlspecialchars($o['nama']) ?></td>
<td class="p-4 text-gray-600"><?= htmlspecialchars($o['kategori']) ?></td>
<td class="p-4 text-green-600 font-bold">Rp<?= number_format($o['harga']) ?></td>
<td class="p-4 text-center">
  <div class="flex gap-3 justify-center">
    <a href="edit_obat.php?id=<?= $o['id'] ?>" class="bg-blue-100 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-200 transition font-medium text-sm flex items-center gap-1">
      <i class="fas fa-edit"></i> Edit
    </a>
    <a href="hapus_obat.php?id=<?= $o['id'] ?>" class="bg-red-100 text-red-600 px-4 py-2 rounded-lg hover:bg-red-200 transition font-medium text-sm flex items-center gap-1">
      <i class="fas fa-trash-alt"></i> Hapus
    </a>
  </div>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>
</section>

<!-- PESANAN -->
<section id="pesanan" class="section bg-white p-8 rounded-2xl shadow-md">
<h3 class="text-2xl font-bold text-green-700 mb-6 flex items-center gap-2">
  <i class="fas fa-shopping-bag"></i> Pesanan Pelanggan
</h3>
<div class="overflow-x-auto">
<table class="w-full">
<thead class="bg-gradient-to-r from-orange-500 to-orange-600 text-white">
<tr>
  <th class="p-4 text-left font-semibold">Pembeli</th>
  <th class="p-4 text-left font-semibold">Keluhan</th>
  <th class="p-4 text-center font-semibold">Status</th>
  <th class="p-4 text-center font-semibold">Aksi</th>
</tr>
</thead>
<tbody id="tabelPesanan"></tbody>
</table>
</div>
</section>

</main>
</div>
</div>

<script>
function showSection(id){
  document.querySelectorAll('.section').forEach(s=>s.classList.remove('active'));
  document.getElementById(id).classList.add('active');
}

/* ===== PESANAN REALTIME ===== */
let pesananList=[];

async function loadPesanan(){
  const res = await fetch("api/get_pesanan.php");
  pesananList = await res.json();
  renderPesanan();
}

function renderPesanan(){
  const tbody=document.getElementById("tabelPesanan");
  if(pesananList.length===0){
    tbody.innerHTML="<tr><td colspan='4' class='p-6 text-center text-gray-500'><i class='fas fa-inbox'></i> Tidak ada pesanan</td></tr>";
    return;
  }

  tbody.innerHTML=pesananList.map(p=>`
    <tr class="border-b hover:bg-gray-50 transition">
      <td class="p-4"><i class="fas fa-user-circle text-gray-500 mr-2"></i>${p.nama_pembeli}</td>
      <td class="p-4 text-gray-700">${p.keluhan}</td>
      <td class="p-4 text-center">
        ${p.status=='selesai'
          ? '<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold"><i class="fas fa-check-circle mr-1"></i>Selesai</span>'
          : '<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold"><i class="fas fa-hourglass-half mr-1"></i>Diproses</span>'}
      </td>
      <td class="p-4 text-center">
        <button onclick="selesaikan(${p.id})" class="bg-green-100 text-green-700 px-4 py-2 rounded-lg hover:bg-green-200 transition font-medium text-sm"><i class="fas fa-check"></i> Selesaikan</button>
      </td>
    </tr>
  `).join("");
}

async function selesaikan(id){
  const fd=new FormData();
  fd.append("pesanan_id",id);
  await fetch("admin_pesanan_update.php",{method:"POST",body:fd});
  loadPesanan();
}

setInterval(loadPesanan,10000);
loadPesanan();
</script>

</body>
</html>