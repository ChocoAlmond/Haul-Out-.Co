<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Haul Out .Co</title>
    <link rel="stylesheet" href="config/style.css">
    <link rel="icon" type="image/x-icon" href="HaulOut.ico">
</head>
<body class="page-shell">
    <div class="panel-card">
        <div class="panel-body">
            <div class="section-header">
                <div>
                    <span class="eyebrow">Akses Sistem</span>
                    <h1 class="page-title">Login ke Haul Out .Co</h1>
                    <p class="page-subtitle">Masuk untuk mengelola armada, pengajuan peminjaman, dan proses approval.</p>
                </div>
            </div>
        
        <form action="auth/proses_login.php" method="POST">
            <div>
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username" required>
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary">Login</button>
        </form>
        
        <div class="auth-footer">
            Belum punya akun? <a href="registrasi.php">Daftar di sini</a><br>
            <a href="index.php">← Kembali ke awal</a>
        </div>
        </div>
    </div>
</body>
</html>