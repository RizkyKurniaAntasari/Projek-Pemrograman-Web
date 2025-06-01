<?php
include '../../includes/auth.php';
include '../../includes/db.php';
redirect_if_not_logged_in();

if (!is_mahasiswa()) {
    header("Location: ../dosen/index.php");
    exit;
}

$result = $conn->query("SELECT u.nama, u.email, m.nama_matkul AS matkul
FROM users AS u
JOIN matkul AS m ON u.id = m.dosen_id
WHERE u.role = 'dosen';");
?>

<?php include '../../includes/header.php'; ?>

<div class="p-6 max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Daftar Dosen & Mata Kuliah</h1>

    <table class="w-full table-auto border border-gray-300">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 border">No</th>
                <th class="px-4 py-2 border">Nama Dosen</th>
                <th class="px-4 py-2 border">Email</th>
                <th class="px-4 py-2 border">Mata Kuliah</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border"><?= $no++ ?></td>
                <td class="px-4 py-2 border"><?= htmlspecialchars($row['nama']) ?></td>
                <td class="px-4 py-2 border"><?= htmlspecialchars($row['email']) ?></td>
                <td class="px-4 py-2 border"><?= htmlspecialchars($row['matkul']) ?: '-' ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
