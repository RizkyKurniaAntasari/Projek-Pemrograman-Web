<?php
session_start();

function is_logged_in() {
    return isset($_SESSION['user']);
}

function is_dosen() {
    return is_logged_in() && $_SESSION['user']['role'] === 'dosen';
}

function is_mahasiswa() {
    return is_logged_in() && $_SESSION['user']['role'] === 'mahasiswa';
}

function redirect_if_not_logged_in() {
    if (!is_logged_in()) {
        header("Location: ../index.php");
        exit;
    }
}
