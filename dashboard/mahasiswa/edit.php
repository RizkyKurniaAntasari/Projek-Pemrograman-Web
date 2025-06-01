<?php
include '../../includes/auth.php';
include '../../includes/db.php';
redirect_if_not_logged_in();

if (!is_dosen()) {
    header("Location: ../mahasiswa.php");
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ? AND role = 'mahasiswa'");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$mhs = $result->fetch_assoc();

if (!$mhs) {
    header("Location: index.php");
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $npm = trim($_POST['npm']);
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);

    if (empty($npm) || empty($nama) || empty($email)) {
        $errors[] = "Semua field wajib diisi.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE users SET npm = ?, nama = ?, email = ? WHERE id = ?");
        $stmt->bind_param("sssi", $npm, $nama, $email, $id);
        $stmt->execute();
        header("Location: index.php");
        exit;
    }
}
?>

<?php include '../../includes/header.php'; ?>

<div class="p-6 max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Edit Mahasiswa</h1>

    <?php if (!empty($errors)): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <?= implode('<br>', $errors) ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
        <div>
            <label class="block mb-1">NPM</label>
            <input type="text" name="npm" value="<?= htmlspecialchars($mhs['npm']) ?>" class="w-full border p-2 rounded" required>
        </div>
        <div>
            <label class="block mb-1">Nama</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($mhs['nama']) ?>" class="w-full border p-2 rounded" required>
        </div>
        <div>
            <label class="block mb-1">Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($mhs['email']) ?>" class="w-full border p-2 rounded" required>
        </div>
        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
            <a href="index.php" class="ml-2 text-gray-600">Kembali</a>
        </div>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
