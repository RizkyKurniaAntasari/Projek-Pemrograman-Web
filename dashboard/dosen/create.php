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
    $nip = trim($_POST['nip']);
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $matkul = trim($_POST['matkul']);

    if (empty($nip) || empty($nama) || empty($email) || empty($_POST['password'])) {
        $errors[] = "Semua field wajib diisi.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO users (npm, nama, email, password, role, matkul) VALUES (?, ?, ?, ?, 'dosen', ?)");
        $stmt->bind_param("sssss", $nip, $nama, $email, $password, $matkul);
        $stmt->execute();
        header("Location: index.php");
        exit;
    }
}
?>

<?php include '../../includes/header.php'; ?>

<div class="p-6 max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Tambah Dosen</h1>

    <?php if (!empty($errors)): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <?= implode('<br>', $errors) ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
        <div>
            <label class="block mb-1">NIP</label>
            <input type="text" name="nip" class="w-full border p-2 rounded" required>
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
            <label class="block mb-1">Mata Kuliah yang Diampu</label>
            <input type="text" name="matkul" class="w-full border p-2 rounded">
        </div>
        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
            <a href="index.php" class="ml-2 text-gray-600">Batal</a>
        </div>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
