<?php
session_start();
require "config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
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

.medical-bg{
  position:fixed;
  inset:0;
  z-index:-1;
  overflow:hidden;
  pointer-events:none;
}

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

.plus{
  position:absolute;
  bottom:-40px;
  font-size:28px;
  color:#4caf50;
  opacity:.18;
  animation:floatUpRotate 24s linear infinite;
}

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

<main class="max-w-7xl mx-auto px-4 py-10 space-y-16">

<!-- HEADER -->
<header class="relative flex items-center justify-center gap-6 py-8">
  <div class="absolute inset-0 bg-gradient-to-r from-blue-400 via-green-500 to-purple-600 opacity-20 blur-3xl rounded-full animate-pulse"></div>
  <div class="relative w-20 h-20 rounded-full bg-gradient-to-br from-blue-400 via-green-500 to-green-600 text-white flex items-center justify-center shadow-2xl animate-bounce hover:animate-spin transition-all duration-500">
    <i class="fas fa-cogs text-3xl"></i>
  </div>
  <div class="relative">
    <h1 class="text-3xl sm:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-green-600 to-purple-600 tracking-wider animate-pulse">
      Admin Dashboard
    </h1>
    <p class="text-center text-green-600 font-medium mt-2 animate-fade-in">Kelola Apotek Dengan Efisien</p>
  </div>
  <a href="auth/logout.php" class="absolute top-4 right-4 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-full shadow-lg transition-all duration-300 hover:scale-105">
    <i class="fas fa-sign-out-alt mr-2"></i>Logout
  </a>
</header>

<!-- ================= TAMBAH OBAT ================= -->
<section class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition-all duration-500">
  <h2 class="text-2xl font-bold text-green-700 mb-6 flex justify-center gap-3 items-center">
    <i class="fas fa-plus-circle text-2xl animate-pulse"></i> Tambah Obat Baru
  </h2>
  <form action="admin_obat_tambah.php" method="POST" class="max-w-2xl mx-auto space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Obat</label>
        <input type="text" name="nama" placeholder="Nama Obat" required
               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300 hover:shadow-md">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
        <input type="text" name="kategori" placeholder="Kategori" required
               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300 hover:shadow-md">
      </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
        <input type="number" name="harga" placeholder="Harga" required
               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300 hover:shadow-md">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">URL Gambar</label>
        <input type="text" name="gambar" placeholder="URL Gambar" required
               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300 hover:shadow-md">
      </div>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
      <textarea name="deskripsi" placeholder="Deskripsi" rows="4"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300 hover:shadow-md resize-none"></textarea>
    </div>
    <div class="text-center">
      <button type="submit" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
        <i class="fas fa-plus mr-2"></i>Tambah Obat
      </button>
    </div>
  </form>
</section>

<!-- ================= DAFTAR OBAT ================= -->
<section class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition-all duration-500">
  <h2 class="text-2xl font-bold text-green-700 mb-6 flex justify-center gap-3 items-center">
    <i class="fas fa-pills text-2xl animate-pulse"></i> Daftar Obat
  </h2>

  <div class="overflow-x-auto">
    <table class="w-full table-auto border-collapse">
      <thead>
        <tr class="bg-gradient-to-r from-green-500 to-green-600 text-white">
          <th class="px-6 py-4 text-left font-semibold rounded-tl-xl">Nama</th>
          <th class="px-6 py-4 text-left font-semibold">Kategori</th>
          <th class="px-6 py-4 text-left font-semibold">Harga</th>
          <th class="px-6 py-4 text-center font-semibold">Gambar</th>
          <th class="px-6 py-4 text-center font-semibold rounded-tr-xl">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $obat = mysqli_query($conn, "SELECT * FROM obat ORDER BY id DESC");
        while ($o = mysqli_fetch_assoc($obat)) :
        ?>
        <tr class="hover:bg-green-50 transition-colors duration-300 border-b border-gray-200">
          <td class="px-6 py-4 font-medium text-gray-800"><?= htmlspecialchars($o['nama']) ?></td>
          <td class="px-6 py-4">
            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
              <?= htmlspecialchars($o['kategori']) ?>
            </span>
          </td>
          <td class="px-6 py-4 font-bold text-green-600">Rp<?= number_format($o['harga']) ?></td>
          <td class="px-6 py-4 text-center">
            <img src="<?= htmlspecialchars($o['gambar']) ?>" class="w-16 h-16 object-cover rounded-xl shadow-md mx-auto hover:scale-110 transition-transform duration-300">
          </td>
          <td class="px-6 py-4 text-center space-x-2">
            <a href="edit_obat.php?id=<?= $o['id'] ?>"
               class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105">
              <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="hapus_obat.php?id=<?= $o['id'] ?>"
               onclick="return confirm('Yakin hapus obat ini?')"
               class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105">
              <i class="fas fa-trash mr-2"></i>Hapus
            </a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</section>

<!-- ================= PESANAN ================= -->
<section class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition-all duration-500">
  <h2 class="text-2xl font-bold text-green-700 mb-6 flex justify-center gap-3 items-center">
    <i class="fas fa-clipboard-list text-2xl animate-pulse"></i> Pesanan Masuk (Realtime)
  </h2>

  <!-- FILTER OBAT -->
  <div class="flex flex-col sm:flex-row gap-4 mb-6">
    <div class="flex-1">
      <input type="text" id="searchObat" placeholder="Cari nama obat..."
             class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300 hover:shadow-md">
    </div>
    <div class="sm:w-64">
      <select id="filterKategori"
              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300 hover:shadow-md">
        <option value="">Semua Kategori</option>
      </select>
    </div>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full table-auto border-collapse">
      <thead>
        <tr class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
          <th class="px-6 py-4 text-left font-semibold rounded-tl-xl">Nama Pembeli</th>
          <th class="px-6 py-4 text-left font-semibold">Keluhan</th>
          <th class="px-6 py-4 text-left font-semibold">Pilih Obat</th>
          <th class="px-6 py-4 text-center font-semibold">Status</th>
          <th class="px-6 py-4 text-center font-semibold rounded-tr-xl">Aksi</th>
        </tr>
      </thead>
      <tbody id="tabelPesanan">
        <tr>
          <td colspan="5" class="px-6 py-8 text-center text-gray-500">
            <i class="fas fa-spinner fa-spin text-2xl mb-2"></i>
            <br>Loading...
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</section>

<!-- FOOTER -->
<footer class="bg-white rounded-3xl shadow-lg p-6 text-center space-y-2">
  <h3 class="font-bold text-green-700">Admin Panel Apotek Kelompok Satu</h3>
  <p><i class="fas fa-shield-alt"></i> Sistem Manajemen Apotek</p>
  <p><i class="fas fa-clock"></i> Real-time Monitoring</p>
</footer>

</main>

<script>
let obatList = [];
let pesananList = [];
let selectedObat = {};


// ===== LOAD OBAT =====
async function loadObat(){
  const res = await fetch("api/get_obat.php");
  obatList = await res.json();
  renderKategori();
}

// ===== LOAD PESANAN =====
async function loadPesanan(){
  const res = await fetch("api/get_pesanan.php");
  pesananList = await res.json();
}

// ===== RENDER KATEGORI =====
function renderKategori(){
  const select = document.getElementById("filterKategori");
  const kategoriUnik = [...new Set(obatList.map(o => o.kategori))];

  select.innerHTML = `<option value="">Semua Kategori</option>`;
  kategoriUnik.forEach(k => {
    select.innerHTML += `<option value="${k}">${k}</option>`;
  });
}

// ===== FILTER OBAT =====
function getFilteredObat(){
  const searchInput = document.getElementById("searchObat");
  const kategoriInput = document.getElementById("filterKategori");

  const search = searchInput ? searchInput.value.toLowerCase() : "";
  const kategori = kategoriInput ? kategoriInput.value : "";

  let filtered = obatList.filter(o => {
    const nama = (o.nama || "").toLowerCase();
    const kat  = o.kategori || "";

    const cocokNama = nama.includes(search);
    const cocokKategori = kategori === "" || kat === kategori;

    return cocokNama && cocokKategori;
  });

  // 🔥 FALLBACK FIX
  if(filtered.length === 0 && obatList.length > 0){
    return obatList;
  }

  return filtered;
}


// ===== RENDER PESANAN =====
function renderPesanan(){
  const tbody = document.getElementById("tabelPesanan");
  let html = "";

  if(pesananList.length === 0){
    tbody.innerHTML = `<tr><td colspan="5">Tidak ada pesanan</td></tr>`;
    return;
  }

  const filteredObat = getFilteredObat();

  pesananList.forEach(p => {

    let obatHTML = "";

    if(filteredObat.length > 0){
      obatHTML = filteredObat.map(o => `
        <label style="border:1px solid #ddd;padding:6px;border-radius:8px;margin-bottom:6px;">
          <input type="checkbox" class="obat-${p.id}" value="${o.id}">
          <img src="${o.gambar}" width="40" style="vertical-align:middle">
          <strong>${o.nama}</strong>
          <small>(${o.kategori})</small><br>
          <small style="color:#555">
            ${o.deskripsi ? o.deskripsi : "Tidak ada deskripsi"}
          </small>
        </label>
      `).join("");
    } else {
      obatHTML = `<em>Obat belum tersedia</em>`;
    }

    html += `
<tr style="background:#ffffff;border-bottom:12px solid #f3f4f6">
  <td style="padding:16px">
    <div style="font-weight:600;color:#065f46">
      ${p.nama_pembeli}
    </div>
    <div style="font-size:12px;color:#6b7280">
      Pembeli
    </div>
  </td>

  <td style="padding:16px;max-width:220px">
    <div style="
      background:#f0fdf4;
      padding:10px 12px;
      border-radius:12px;
      font-size:13px;
      color:#064e3b;
      line-height:1.5;
    ">
      ${p.keluhan}
    </div>
  </td>

  <td style="padding:16px">
    <div style="display:flex;flex-direction:column;gap:10px">
      ${obatHTML}
    </div>
  </td>

  <td style="padding:16px;text-align:center">
    <span style="
      padding:6px 14px;
      border-radius:999px;
      font-size:12px;
      font-weight:600;
      background:${p.status === 'selesai' ? '#dcfce7' : '#fef3c7'};
      color:${p.status === 'selesai' ? '#166534' : '#92400e'};
    ">
      ${p.status}
    </span>
  </td>

  <td style="padding:16px;text-align:center">
    <button onclick="selesaikanPesanan(${p.id})"
      style="
        padding:10px 18px;
        border:none;
        border-radius:12px;
        background:#22c55e;
        color:white;
        font-weight:600;
        cursor:pointer;
        box-shadow:0 6px 14px rgba(34,197,94,.25);
        transition:.2s;
      "
      onmouseover="this.style.transform='scale(1.05)'"
      onmouseout="this.style.transform='scale(1)'"
    >
      ✔ Selesaikan
    </button>
  </td>
</tr>
`;

  });

  tbody.innerHTML = html;
}
// ===== SELESAIKAN PESANAN =====
async function selesaikanPesanan(id){
  const checked = document.querySelectorAll(`.obat-${id}:checked`);

  if(checked.length === 0){
    alert("Pilih minimal 1 obat");
    return;
  }

  const formData = new FormData();
  formData.append("pesanan_id", id);
  checked.forEach(c => formData.append("obat_id[]", c.value));

  const res = await fetch("admin_pesanan_update.php", {
    method: "POST",
    body: formData
  });

  alert(await res.text());
  realtime();
}

// ===== REALTIME =====
async function realtime(){
  await loadObat();
  await loadPesanan();
  renderPesanan();
}

// EVENT FILTER
document.getElementById("searchObat").addEventListener("input", renderPesanan);
document.getElementById("filterKategori").addEventListener("change", renderPesanan);

setInterval(realtime, 15000);
realtime();
</script>

</body>
</html>
