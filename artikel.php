<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Artikel</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; margin: 0; padding: 1rem; background-color: transparent; color: #e2e8f0; }
        h1 { padding-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.2); color: #fff; }
        .artikel { border-bottom: 1px solid rgba(255,255,255,0.2); padding-bottom: 15px; margin-bottom: 15px; overflow: hidden; }
        .artikel img { max-width: 200px; float: left; margin-right: 15px; border-radius: 8px; }
        .artikel h2 a { text-decoration: none; color: #f1f5f9; transition: color 0.3s; }
        .artikel h2 a:hover { color: #38bdf8; }
        .artikel small { color: #94a3b8; }
        .artikel a { color: #38bdf8; }
        .artikel p { color: #cbd5e1; }
    </style>
</head>
<body>

    <h1>Daftar Artikel</h1>

    <?php
    $sql = "SELECT id, judul, konten, gambar, tanggal_publikasi FROM articles ORDER BY tanggal_publikasi DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<div class='artikel'>";
            if (!empty($row["gambar"])) {
                echo "<img src='uploads/" . htmlspecialchars($row["gambar"]) . "' alt='Gambar Artikel'>";
            }
            echo "<h2><a href='baca_artikel.php?id=" . $row["id"] . "'>" . htmlspecialchars($row["judul"]) . "</a></h2>";
            echo "<small>Dipublikasikan pada: " . $row["tanggal_publikasi"] . "</small>";
            // Tampilkan ringkasan konten
            $ringkasan = substr(strip_tags($row["konten"]), 0, 200);
            echo "<p>" . htmlspecialchars($ringkasan) . "... <a href='baca_artikel.php?id=" . $row["id"] . "'>Baca selengkapnya</a></p>";
            echo "</div>";
        }
    } else {
        echo "<p>Belum ada artikel.</p>";
    }
    $conn->close();
    ?>

</body>
</html>