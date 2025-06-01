<?php
include '../../includes/auth.php';
include '../../includes/db.php';
redirect_if_not_logged_in();

if (!is_dosen()) {
    header("Location: ../mahasiswa.php");
    exit;
}

$mahasiswa = $conn->query("SELECT * FROM users WHERE role = 'mahasiswa'");
?>

<?php include '../../includes/header.php'; ?>

<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Mahasiswa</h1>

    <a href="create.php" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">+ Tambah Mahasiswa</a>

    <table class="w-full bg-white rounded shadow mt-4">
        <thead>
            <tr>
                <th class="border p-2">NPM</th>
                <th class="border p-2">Nama</th>
                <th class="border p-2">Email</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($mhs = $mahasiswa->fetch_assoc()): ?>
                <tr>
                    <td class="border p-2"><?= htmlspecialchars($mhs['npm']) ?></td>
                    <td class="border p-2"><?= htmlspecialchars($mhs['nama']) ?></td>
                    <td class="border p-2"><?= htmlspecialchars($mhs['email']) ?></td>
                    <td class="border p-2">
                        <a href="edit.php?id=<?= $mhs['id'] ?>" class="text-blue-500">Edit</a> |
                        <a href="delete.php?id=<?= $mhs['id'] ?>" class="text-red-500"
                           onclick="return confirm('Yakin hapus mahasiswa ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
