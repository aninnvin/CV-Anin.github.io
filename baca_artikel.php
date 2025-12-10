<?php
include 'koneksi.php';

// Cek apakah ID ada di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: artikel.php');
    exit;
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT judul, konten, gambar, tanggal_publikasi FROM articles WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $artikel = $result->fetch_assoc();
} else {
    // Jika artikel tidak ditemukan, kembali ke halaman daftar artikel
    header('Location: artikel.php');
    exit;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($artikel['judul']); ?></title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; margin: 0; padding: 1rem; background-color: transparent; color: #e2e8f0; }
        .featured-img { width: 100%; max-height: 400px; object-fit: cover; margin-bottom: 20px; border-radius: 8px; }
        h1 { color: #fff; }
        small { color: #94a3b8; }
        .konten { margin-top: 20px; }
        .konten p, .konten li, .konten span { color: #e2e8f0 !important; } /* Memaksa warna teks di dalam konten */
        .konten strong { color: #fff !important; }
        a { color: #38bdf8; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <h1><?php echo htmlspecialchars($artikel['judul']); ?></h1>
    <small>Dipublikasikan pada: <?php echo $artikel['tanggal_publikasi']; ?></small>
    
    <?php if (!empty($artikel['gambar'])): ?>
        <img src="uploads/<?php echo htmlspecialchars($artikel['gambar']); ?>" alt="Gambar Artikel" class="featured-img">
    <?php endif; ?>

    <div class="konten">
        <?php echo $artikel['konten']; // Konten dari TinyMCE sudah berupa HTML ?>
    </div>
    <br>
    <a href="artikel.php">Kembali ke Daftar Artikel</a>

</body>
</html>