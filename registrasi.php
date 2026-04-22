<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Haul Out .Co</title>
    <link rel="stylesheet" href="config/style.css">
    <link rel="icon" type="image/x-icon" href="HaulOut.ico">
</head>
<body class="page-shell">
    <div class="panel-card">
        <div class="panel-body">
            <div class="section-header">
                <div>
                    <span class="eyebrow">Bergabung Sekarang</span>
                    <h1 class="page-title">Buat Akun Peminjam</h1>
                    <p class="page-subtitle">Daftar dengan cepat sebagai peminjam dan temukan truk yang sesuai kebutuhanmu.</p>
                </div>
            </div>

            <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'gagal'): ?>
                <div class="alert alert-danger">Gagal mendaftar. Username mungkin sudah ada.</div>
            <?php endif; ?>

            <form action="auth/proses_registrasi.php" method="POST">
                <label>Username</label>
                <input type="text" name="username" placeholder="Pilih Username" required>
                <label>Password</label>
                <input type="password" name="password" placeholder="Pilih Password" required>
                <input type="hidden" name="role" value="Peminjam">
                <button type="submit" name="register" class="btn btn-primary">Daftar Sekarang</button>
            </form>

            <div class="auth-footer">
                Sudah punya akun? <a href="login.php">Login di sini</a><br>
                <a href="index.php">← Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>