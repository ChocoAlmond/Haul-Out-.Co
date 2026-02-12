<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi - Haul Out .Co</title>
    <link rel="stylesheet" href="config/style.css">
    <link rel="icon" type="image/x-icon" href="HaulOut.ico">
</head>
<body>
    <div class="auth-container">
        <p>Haul Out .Co</p>
        <h2>Buat Akun Baru</h2>
        <p>Daftar sebagai Peminjam di Haul Out .Co</p>

        <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'gagal'): ?>
            <p style="color: red; font-size: 13px;">Gagal mendaftar. Username mungkin sudah ada.</p>
        <?php endif; ?>

        <form action="auth/proses_registrasi.php" method="POST">
            <input type="text" name="username" placeholder="Pilih Username" required>
            <input type="password" name="password" placeholder="Pilih Password" required>
            
            <input type="hidden" name="role" value="Peminjam">
            
            <button type="submit" name="register" class="btn-auth">DAFTAR SEKARANG</button>
        </form>

        <div class="auth-footer">
            Sudah punya akun? <a href="login.php">Login di sini</a><br>
            <a href="index.php" style="color: gray; font-size: 12px; text-decoration: none;">← Kembali</a>
        </div>
    </div>
</body>
</html>