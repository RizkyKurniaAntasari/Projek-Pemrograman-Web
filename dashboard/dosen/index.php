<?php
include '../../includes/auth.php';
include '../../includes/db.php';
redirect_if_not_logged_in();

if (!is_dosen()) {
    header("Location: ../mahasiswa.php");
    exit;
}

$result = $conn->query("SELECT * FROM users WHERE role = 'dosen'");
?>

<?php include '../../includes/header.php'; ?>

<div class="p-6 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Daftar Dosen</h1>
        <a href="create.php" class="bg-blue-600 text-white px-4 py-2 rounded">+ Tambah Dosen</a>
    </div>

    <table class="w-full border rounded">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">NIP</th>
                <th class="p-2 border">Nama</th>
                <th class="p-2 border">Email</th>
                <th class="p-2 border">Matkul</th>
                <th class="p-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($dosen = $result->fetch_assoc()): ?>
                <tr class="hover:bg-gray-100">
                    <td class="p-2 border"><?= htmlspecialchars($dosen['nip']) ?></td>
                    <td class="p-2 border"><?= htmlspecialchars($dosen['nama']) ?></td>
                    <td class="p-2 border"><?= htmlspecialchars($dosen['email']) ?></td>
                    <td class="p-2 border"><?= htmlspecialchars($dosen['matkul'] ?? '-') ?></td>
                    <td class="p-2 border">
                        <a href="edit.php?id=<?= $dosen['id'] ?>" class="text-blue-600 hover:underline">Edit</a> |
                        <a href="delete.php?id=<?= $dosen['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
