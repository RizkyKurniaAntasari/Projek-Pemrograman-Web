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

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ? AND role = 'dosen'");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$dosen = $result->fetch_assoc();

if (!$dosen) {
    echo "Dosen tidak ditemukan.";
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nip = trim($_POST['nip']);
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $matkul = trim($_POST['matkul']);

    if (empty($nip) || empty($nama) || empty($email)) {
        $errors[] = "Field tidak boleh kosong.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE users SET npm = ?, nama = ?, email = ?, matkul = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $nip, $nama, $email, $matkul, $id);
        $stmt->execute();
        header("Location: index.php");
        exit;
    }
}
?>

<?php include '../../includes/header.php'; ?>

<div class="p-6 max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Edit Data Dosen</h1>

    <?php if (!empty($errors)): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <?= implode('<br>', $errors) ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
        <div>
            <label class="block mb-1">NIP</label>
            <input type="text" name="nip" value="<?= htmlspecialchars($dosen['npm']) ?>" class="w-full border p-2 rounded" required>
        </div>
        <div>
            <label class="block mb-1">Nama</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($dosen['nama']) ?>" class="w-full border p-2 rounded" required>
        </div>
        <div>
            <label class="block mb-1">Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($dosen['email']) ?>" class="w-full border p-2 rounded" required>
        </div>
        <div>
            <label class="block mb-1">Mata Kuliah yang Diampu</label>
            <input type="text" name="matkul" value="<?= htmlspecialchars($dosen['matkul']) ?>" class="w-full border p-2 rounded">
        </div>
        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
            <a href="index.php" class="ml-2 text-gray-600">Batal</a>
        </div>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
