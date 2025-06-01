<?php
session_start();
include '../includes/db.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Gunakan prepared statement untuk keamanan
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    // Jika kamu pakai password_hash:
    // if (password_verify($password, $user['password'])) { ... }

    // Kalau masih pakai MD5:
    if ($user['password'] === md5($password)) {
        $_SESSION['user'] = $user;

        // Redirect berdasarkan role
        if ($user['role'] === 'dosen') {
            header("Location: ../dashboard/dosen.php");
        } else {
            header("Location: ../dashboard/mahasiswa.php");
        }
        exit;
    }
}

$_SESSION['error'] = "Email atau Password salah!";
header("Location: ../index.php");
exit;
