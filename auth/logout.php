<?php
session_start();
session_unset();
session_destroy();

// Pastikan path-nya bener balik ke folder root (index.php)
header("location: ../index.php");
exit();
?>