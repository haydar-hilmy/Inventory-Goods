<?php
session_start(); // Mulai sesi

// Hapus semua data sesi
session_unset();

// Hancurkan sesi
session_destroy();

header('Location: index.php');
exit();
?>
