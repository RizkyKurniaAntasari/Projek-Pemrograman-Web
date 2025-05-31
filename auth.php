<?php
session_start();
require_once 'koneksi/db.php';

function check_login() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . BASE_URL . '?page=login');
        exit();
    }
}

function check_role($allowed_roles) {
    if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $allowed_roles)) {
        header('Location: ' . BASE_URL . '?page=unauthorized'); 
        exit();
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset();
    session_destroy();
    header('Location: ' . BASE_URL . '?page=login');
    exit();
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password, role, nama_lengkap, angkatan FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            $_SESSION['angkatan'] = $user['angkatan']; 

            if ($user['role'] == 'dosen') {
                header('Location: ' . BASE_URL . '?page=dosen_dashboard');
            } else if ($user['role'] == 'mahasiswa') {
                header('Location: ' . BASE_URL . '?page=mahasiswa_dashboard');
            }
            exit();
        } else {
            $_SESSION['error_message'] = "Username atau password salah.";
        }
    } else {
        $_SESSION['error_message'] = "Username atau password salah.";
    }
    header('Location: ' . BASE_URL . '?page=login'); 
    exit();
}
?>