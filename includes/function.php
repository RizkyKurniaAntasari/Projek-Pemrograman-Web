<?php
function format_date($date_string) {
    return date('d M Y H:i', strtotime($date_string));
}

function get_dosen_matakuliah($dosen_id, $conn) {
    $sql = "SELECT mk.id, mk.nama_mk
            FROM mata_kuliah mk
            JOIN dosen_mengajar_mk dmmk ON mk.id = dmmk.id_mata_kuliah
            WHERE dmmk.id_dosen = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $dosen_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function get_mahasiswa_by_matkul_dosen($id_mk, $dosen_id, $conn) {
    $sql = "SELECT u.id, u.nama_lengkap, u.angkatan
            FROM users u
            JOIN mahasiswa_mengambil_mk mmmk ON u.id = mmmk.id_mahasiswa
            JOIN dosen_mengajar_mk dmmk ON mmmk.id_mata_kuliah = dmmk.id_mata_kuliah
            WHERE mmmk.id_mata_kuliah = ? AND dmmk.id_dosen = ? AND u.role = 'mahasiswa'
            ORDER BY u.angkatan DESC, u.nama_lengkap ASC
            LIMIT 10"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_mk, $dosen_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function get_mahasiswa_matakuliah($mahasiswa_id, $conn) {
    $sql = "SELECT mk.id, mk.nama_mk, u_dosen.nama_lengkap AS nama_dosen
            FROM mata_kuliah mk
            JOIN mahasiswa_mengambil_mk mmmk ON mk.id = mmmk.id_mata_kuliah
            JOIN dosen_mengajar_mk dmmk ON mk.id = dmmk.id_mata_kuliah
            JOIN users u_dosen ON dmmk.id_dosen = u_dosen.id
            WHERE mmmk.id_mahasiswa = ?
            GROUP BY mk.id, mk.nama_mk, u_dosen.nama_lengkap"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $mahasiswa_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function get_materi_by_matkul($id_mk, $conn) {
    $sql = "SELECT id, judul, deskripsi, file_path, tanggal_upload FROM materi_perkuliahan WHERE id_mata_kuliah = ? ORDER BY tanggal_upload DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_mk);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function get_tugas_by_matkul($id_mk, $conn) {
    $sql = "SELECT id, judul_tugas, deskripsi_tugas, deadline FROM tugas WHERE id_mata_kuliah = ? ORDER BY deadline DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_mk);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function get_nilai_tugas_mahasiswa($id_tugas, $id_mahasiswa, $conn) {
    $sql = "SELECT nilai FROM submission_tugas WHERE id_tugas = ? AND id_mahasiswa = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_tugas, $id_mahasiswa);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
?>