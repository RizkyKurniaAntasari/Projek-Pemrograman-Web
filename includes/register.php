<!-- register.php -->
<?php include 'includes/header.php'; ?>

<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-xl p-8 rounded-xl w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Registrasi Mahasiswa</h2>
        <form action="actions/register.php" method="POST" class="space-y-4">
            <input type="text" name="npm" placeholder="NPM" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            <input type="text" name="nama" placeholder="Nama Lengkap" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            <input type="email" name="email" placeholder="Email Gmail" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            <input type="password" name="password" placeholder="Password" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            <button type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg">
                Daftar
            </button>
        </form>
        <p class="mt-4 text-center">
            Sudah punya akun? <a href="index.php" class="text-blue-500">Login disini</a>
        </p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
