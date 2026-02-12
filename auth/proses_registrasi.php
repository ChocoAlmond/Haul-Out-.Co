<?php
include '../config/db.php';

echo"<h2>Memprosess Registrasi...</h2>";

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role     = mysqli_real_escape_string($conn, $_POST['role']);

    // 1. Cek apakah username sudah ada biar nggak duplikat
    $cek_user = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    
    if (mysqli_num_rows($cek_user) > 0) {
        // Kalau sudah ada, balikkan ke halaman regis dengan pesan error
        header("location:../registrasi.php?pesan=gagal");
    } else {
        // 2. Masukkan data ke database
        $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
        
        if (mysqli_query($conn, $query)) {
            // Kalau berhasil, arahkan ke login
            echo "<script>alert('Registrasi Berhasil! Silakan Login.'); window.location='../login.php';</script>";
        } else {
            // Kalau error database
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    header("location:../registrasi.php");
}
?>