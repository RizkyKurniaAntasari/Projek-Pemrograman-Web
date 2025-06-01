<?php
include '../../includes/auth.php';
include '../../includes/db.php';
redirect_if_not_logged_in();

if (!is_dosen()) {
    header("Location: ../mahasiswa.php");
    exit;
}

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role = 'mahasiswa'");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: index.php");
exit;
