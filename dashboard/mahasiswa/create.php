<?php
include '../../includes/auth.php';
include '../../includes/db.php';
redirect_if_not_logged_in();

if (!is_dosen()) {
    header("Location: ../mahasiswa.php");
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $npm = trim($_POST['npm']);
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (empty($npm) || empty($nama) || empty($email) || empty($_POST['password'])) {
        $errors[] = "Semua field wajib diisi.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO users (npm, nama, email, password, role) VALUES (?, ?, ?, ?, 'mahasiswa')");
        $stmt->bind_param("ssss", $npm, $nama, $email, $password);
        $stmt->execute();
        header("Location: index.php");
        exit;
    }
}
?>

<?php include '../../includes/header.php'; ?>

<div class="p-6 max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Tambah Mahasiswa</h1>

    <?php if (!empty($errors)): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <?= implode('<br>', $errors) ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
        <div>
            <label class="block mb-1">NPM</label>
            <input type="text" name="npm" class="w-full border p-2 rounded" required>
        </div>
        <div>
            <label class="block mb-1">Nama</label>
            <input type="text" name="nama" class="w-full border p-2 rounded" required>
        </div>
        <div>
            <label class="block mb-1">Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded" required>
        </div>
        <div>
            <label class="block mb-1">Password</label>
            <input type="password" name="password" class="w-full border p-2 rounded" required>
        </div>
        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
            <a href="index.php" class="ml-2 text-gray-600">Batal</a>
        </div>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
