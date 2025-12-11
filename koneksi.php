<?php
$servername = "localhost";
$username   = "root";      // User MySQL Byethost
$password   = ""; // Password MySQL Byethost
$dbname     = "psas_db"; // Database harus dibuat via cPanel

// Koneksi langsung ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk membuat tabel users
$sql_create_table_users = "
CREATE TABLE IF NOT EXISTS users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";

// Query untuk membuat tabel articles
$sql_create_table_articles = "
CREATE TABLE IF NOT EXISTS articles (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    konten TEXT NOT NULL,
    gambar VARCHAR(255) NULL,
    tanggal_publikasi TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

// Eksekusi query
if (!$conn->query($sql_create_table_users) || !$conn->query($sql_create_table_articles)) {
    die("Error creating table: " . $conn->error);
}

// Cek apakah user admin sudah ada
$result = $conn->query("SELECT id FROM users WHERE username = 'admin'");
if ($result && $result->num_rows == 0) {
    $admin_password = password_hash("admin123", PASSWORD_DEFAULT);
    $sql_insert_admin = "INSERT INTO users (username, password) VALUES ('admin', '$admin_password')";
    $conn->query($sql_insert_admin);
}
?>
