<?php
include '../includes/auth.php';
include '../includes/db.php';
redirect_if_not_logged_in();

if (!is_mahasiswa()) {
    header("Location: ../index.php");
    exit;
}

$mahasiswa = $_SESSION['user'];
?>

<?php include '../includes/header.php'; ?>

<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Dashboard Mahasiswa</h1>
    <p>Selamat datang, <strong><?= htmlspecialchars($mahasiswa['nama']) ?></strong></p>
    <h2 class="text-xl font-semibold mt-6 mb-2">Daftar Mata Kuliah & Dosen Pengampu</h2>

    <div class="bg-white shadow rounded p-4">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr>
                    <th class="border-b p-2">Mata Kuliah</th>
                    <th class="border-b p-2">Dosen Pengampu</th>
                    <th class="border-b p-2">Email Dosen</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT matkul.nama_matkul, users.nama AS dosen_nama, users.email FROM matkul JOIN users ON matkul.dosen_id = users.id WHERE users.role = 'dosen'";
                $result = $conn->query($query);
                while ($row = $result->fetch_assoc()):
                ?>
                    <tr>
                        <td class="border-b p-2"><?= htmlspecialchars($row['nama_matkul']) ?></td>
                        <td class="border-b p-2"><?= htmlspecialchars($row['dosen_nama']) ?></td>
                        <td class="border-b p-2"><?= htmlspecialchars($row['email']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="../actions/logout.php"
            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Logout</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>