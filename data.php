<?php
// Koneksi ke database
require 'config/connection.php';

// Data yang ingin ditambahkan
$username = 'newuser'; // Ganti dengan username yang ingin ditambahkan
$password = '111'; // Ganti dengan password yang ingin ditambahkan
$role = 'admin'; // Ganti dengan role yang ingin ditambahkan

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    // Buat query SQL untuk menambahkan data
    $sql = "INSERT INTO users (username, password, role) VALUES (:username, :password, :role)";
    $stmt = $pdo->prepare($sql);
    // Bind parameter
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':role', $role);

    // Eksekusi query
    if ($stmt->execute()) {
        $message = "Data berhasil ditambahkan.";
    } else {
        $message = "Gagal menambahkan data.";
    }
} catch (PDOException $e) {
    $message = "Terjadi kesalahan: " . $e->getMessage();
}

// Tampilkan pesan status
echo $message;
?>
