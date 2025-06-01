<?php
include '../includes/auth.php';
include '../includes/db.php';
redirect_if_not_logged_in();

if (!is_dosen()) {
    header("Location: ../index.php");
    exit;
}

$dosen = $_SESSION['user'];
?>

<?php include '../includes/header.php'; ?>

<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Dashboard Dosen</h1>
    <p>Selamat datang, <strong><?= htmlspecialchars($dosen['nama']) ?></strong></p>

    <div class="mt-6">
        <a href="../actions/logout.php"
           class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Logout</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
