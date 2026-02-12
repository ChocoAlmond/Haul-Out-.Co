<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Haul Out .Co</title>
    <link rel="stylesheet" href="config/style.css">
    <link rel="icon" type="image/x-icon" href="HaulOut.ico">
</head>
<body>
    <div class="auth-container">
        <h2>Haul Out .Co</h2>
        <p>Silakan login untuk masuk ke sistem</p>
        
        <form action="auth/proses_login.php" method="POST">
            <div style="text-align: left;">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username" required>
            </div>
            <div style="text-align: left;">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>
            <button type="submit" name="login" class="btn-auth">Login</button>
        </form>
        
        <div class="auth-footer">
            Belum punya akun? <a href="registrasi.php">Daftar di sini</a><br>
            <a href="index.php" style="color: gray; font-size: 12px;">← Kembali ke awal</a>
        </div>
    </div>
</body>
</html>