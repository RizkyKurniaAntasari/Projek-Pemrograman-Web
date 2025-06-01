<!-- index.php -->
<?php include 'includes/header.php'; ?>

<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-xl p-8 rounded-xl w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
        <form action="actions/login.php" method="POST" class="space-y-4">
            <input type="email" name="email" placeholder="Email" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            <input type="password" name="password" placeholder="Password" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg">
                Login
            </button>
        </form>
        <p class="mt-4 text-center">
            Belum punya akun? <a href="register.php" class="text-blue-500">Daftar disini</a>
        </p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>