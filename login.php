<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login Apotek</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> <!-- Tambahkan Font Awesome untuk ikon -->

<style>
body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Font lebih modern */
  background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 50%, #a5d6a7 100%); /* Gradien hijau lebih kaya */
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
  position: relative;
  overflow-x: hidden; /* Mencegah scroll horizontal */
}

/* Elemen latar belakang untuk efek realistik dengan partikel */
body::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: 
    radial-gradient(circle at 20% 80%, rgba(76, 175, 80, 0.1) 0%, transparent 50%),
    radial-gradient(circle at 80% 20%, rgba(46, 125, 50, 0.1) 0%, transparent 50%),
    radial-gradient(circle at 40% 40%, rgba(129, 199, 132, 0.1) 0%, transparent 50%);
  z-index: -1;
}

body::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8ZGVmcz4KICAgIDxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIiB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPgogICAgICA8Y2lyY2xlIGN4PSIzMCIgY3k9IjMwIiByPSIyIiBmaWxsPSIjNGNhZjUwIiBvcGFjaXR5PSIwLjA1Ii8+CiAgICA8L3BhdHRlcm4+CiAgPC9kZWZzPgogIDxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjcGF0dGVybikiLz4KPC9zdmc+'); /* Pola pil kecil */
  opacity: 0.05;
  z-index: -1;
  animation: drift 20s linear infinite; /* Animasi pelan mengalir */
}

@keyframes drift {
  0% { transform: translateX(0) translateY(0); }
  100% { transform: translateX(-100px) translateY(-100px); }
}

/* Ikon mengambang untuk mengisi ruang */
.floating-icons {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
  z-index: -1;
}

.floating-icons i {
  position: absolute;
  color: rgba(76, 175, 80, 0.2);
  font-size: 2rem;
  animation: floatRandom 6s ease-in-out infinite;
}

.floating-icons i:nth-child(1) { top: 10%; left: 10%; animation-delay: 0s; }
.floating-icons i:nth-child(2) { top: 20%; right: 15%; animation-delay: 1s; }
.floating-icons i:nth-child(3) { bottom: 30%; left: 20%; animation-delay: 2s; }
.floating-icons i:nth-child(4) { bottom: 20%; right: 10%; animation-delay: 3s; }
.floating-icons i:nth-child(5) { top: 50%; left: 50%; animation-delay: 4s; }

@keyframes floatRandom {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-20px) rotate(10deg); }
}

.box {
  background: rgba(255, 255, 255, 0.98); /* Lebih opaque untuk kontras */
  padding: 40px;
  width: 400px; /* Sedikit lebih lebar untuk mengisi ruang */
  max-width: 90%;
  border-radius: 25px;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15), 0 10px 20px rgba(0, 0, 0, 0.1); /* Shadow lebih dramatis */
  backdrop-filter: blur(15px); /* Blur lebih kuat */
  animation: slideIn 1s ease-out; /* Animasi masuk yang lebih smooth */
  position: relative;
  overflow: hidden;
  z-index: 1;
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateY(50px) scale(0.9);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

.box::before {
  content: '';
  position: absolute;
  top: -60px;
  left: -60px;
  width: 120px;
  height: 120px;
  background: radial-gradient(circle, rgba(46, 125, 50, 0.15) 0%, transparent 70%);
  border-radius: 50%;
  animation: pulse 4s ease-in-out infinite; /* Pulse untuk hidup */
}

.box::after {
  content: '';
  position: absolute;
  bottom: -60px;
  right: -60px;
  width: 100px;
  height: 100px;
  background: radial-gradient(circle, rgba(76, 175, 80, 0.15) 0%, transparent 70%);
  border-radius: 50%;
  animation: pulse 5s ease-in-out infinite reverse;
}

@keyframes pulse {
  0%, 100% { transform: scale(1); opacity: 0.5; }
  50% { transform: scale(1.1); opacity: 1; }
}

/* Sambutan dengan animasi fade in */
.welcome {
  text-align: center;
  margin-bottom: 15px;
  color: #2e7d32;
  font-size: 18px;
  font-weight: 500;
  line-height: 1.4;
  animation: fadeIn 2s ease-out; /* Fade in sederhana */
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

h2 {
  text-align: center;
  margin-bottom: 25px;
  color: #2e7d32;
  font-size: 32px;
  font-weight: 700;
  position: relative;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

h2::before {
  content: '\f46b';
  font-family: 'Font Awesome 6 Free';
  font-weight: 900;
  position: absolute;
  left: -50px;
  top: 50%;
  transform: translateY(-50%);
  color: #4caf50;
  font-size: 28px;
  animation: spin 6s linear infinite;
}

@keyframes spin {
  from { transform: translateY(-50%) rotate(0deg); }
  to { transform: translateY(-50%) rotate(360deg); }
}

input {
  width: 100%;
  padding: 18px;
  margin-top: 15px;
  border: 2px solid #ddd;
  border-radius: 12px;
  font-size: 16px;
  transition: all 0.3s ease;
  box-sizing: border-box;
  background: #f9f9f9;
}

input:focus {
  border-color: #4caf50;
  box-shadow: 0 0 15px rgba(76, 175, 80, 0.4);
  outline: none;
  background: #fff;
}

input::placeholder {
  color: #aaa;
  font-style: italic;
}

button {
  width: 100%;
  padding: 18px;
  margin-top: 25px;
  background: linear-gradient(135deg, #2e7d32 0%, #4caf50 100%);
  color: white;
  border: none;
  border-radius: 12px;
  cursor: pointer;
  font-size: 18px;
  font-weight: 600;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(46, 125, 50, 0.3);
}

button::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
  transition: left 0.6s;
}

button:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 25px rgba(46, 125, 50, 0.4);
}

button:hover::before {
  left: 100%;
}

button:active {
  transform: translateY(0);
}

.role {
  margin-top: 20px;
  display: flex;
  justify-content: space-around;
  align-items: center;
}

.role label {
  display: flex;
  align-items: center;
  cursor: pointer;
  font-size: 16px;
  color: #555;
  transition: color 0.3s ease;
  padding: 10px;
  border-radius: 8px;
  background: rgba(76, 175, 80, 0.05);
}

.role label:hover {
  color: #2e7d32;
  background: rgba(76, 175, 80, 0.1);
}

.role input[type="radio"] {
  margin-right: 8px;
  accent-color: #4caf50;
}

#msg {
  color: #d32f2f;
  margin-top: 15px;
  text-align: center;
  font-weight: 500;
  animation: shake 0.5s ease-in-out;
}

@keyframes shake {
  0%, 100% { transform: translateX(0); }
  25% { transform: translateX(-5px); }
  75% { transform: translateX(5px); }
}

/* Footer untuk mengisi ruang bawah */
.footer {
  margin-top: 50px;
  text-align: center;
  color: #2e7d32;
  font-size: 14px;
  opacity: 0.8;
  animation: fadeIn 2s ease-out 1s both; /* Muncul setelah box */
}

.footer p {
  margin: 5px 0;
}

.footer .icons {
  margin-top: 10px;
}

.footer .icons i {
  margin: 0 10px;
  font-size: 20px;
  color: #4caf50;
  transition: color 0.3s ease;
}

.footer .icons i:hover {
  color: #2e7d32;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Responsivitas */
@media (max-width: 768px) {
  .box {
    padding: 30px;
    width: 90%;
  }
  h2 {
    font-size: 28px;
  }
  h2::before {
    left: -40px;
    font-size: 24px;
  }
  .welcome {
    font-size: 16px;
  }
  .footer {
    margin-top: 30px;
    font-size: 12px;
  }
  .floating-icons i {
    font-size: 1.5rem;
  }
}

@media (max-width: 480px) {
  .box {
    padding: 25px;
  }
  h2 {
    font-size: 24px;
  }
  h2::before {
    left: -30px;
    font-size: 20px;
  }
  .welcome {
    font-size: 14px;
  }
  .footer {
    margin-top: 20px;
  }
}
</style>
</head>

<body>
  <!-- Ikon mengambang untuk mengisi ruang -->
  <div class="floating-icons">
    <i class="fas fa-pills"></i>
    <i class="fas fa-heartbeat"></i>
    <i class="fas fa-stethoscope"></i>
    <i class="fas fa-medkit"></i>
    <i class="fas fa-flask"></i>
  </div>

  <div class="box">
    <div class="welcome">
      Selamat datang di Apotek Kelompok Satu,<br>
      silahkan login terlebih dahulu
    </div>
    <h2>Login Apotek</h2>

    <form id="loginForm">
      <input type="text" name="username" id="username" placeholder="Masukkan Username" required>
      <input type="password" name="password" id="password" placeholder="Masukkan Password" required>

      <div class="role">
        <label>
          <input type="radio" name="role" value="pembeli" checked> Pembeli
        </label>
        <label>
          <input type="radio" name="role" value="admin"> Admin
        </label>
      </div>

      <button type="submit">Login</button>
    </form>

    <p id="msg" style="color:red;margin-top:10px;"></p>
  </div>

  <!-- Footer untuk mengisi ruang bawah -->
  <div class="footer">
    <p><i class="fas fa-map-marker-alt"></i> Alamat: Jl. Kesehatan No. 123, Kota Sehat</p>
    <p><i class="fas fa-clock"></i> Jam Operasional: Senin - Minggu, 08:00 - 22:00</p>
    <p><i class="fas fa-phone"></i> Kontak: (021) 123-4567</p>
    <div class="icons">
      <i class="fab fa-facebook"></i>
      <i class="fab fa-instagram"></i>
      <i class="fab fa-twitter"></i>
    </div>
  </div>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const formData = new FormData(this);

  fetch('auth/login.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(res => {
    if (res.status === 'success') {
      window.location.href = res.redirect;
    } else {
      document.getElementById('msg').innerText =
        'Username, password, atau role salah';
    }
  })
  .catch(() => {
    document.getElementById('msg').innerText =
      'Server error';
  });
});
</script>

</body>
</html>