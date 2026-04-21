<?php
include '../config/db.php';

$id = intval($_GET['id'] ?? 0);
$status = trim($_GET['status'] ?? '');
$allowedStatuses = ['Pending', 'Disetujui', 'Ditolak', 'Selesai'];

if ($id <= 0 || !in_array($status, $allowedStatuses, true)) {
    header("location:dashboard.php");
    exit;
}

$stmt = mysqli_prepare($conn, "UPDATE peminjaman SET status_approval = ? WHERE id_pinjam = ?");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "si", $status, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

header("location:dashboard.php");