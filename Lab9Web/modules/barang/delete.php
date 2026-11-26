
<?php
require_once __DIR__ . '/../../config/database.php';

// Mengambil ID barang dari URL
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id <= 0) {
    echo "<section class='content'>";
    echo "<h2>ID barang tidak valid.</h2>";
    echo "<a href='index.php?page=barang/list'>Kembali</a>";
    echo "</section>";
    return;
}

// Mengambil data barang
$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM data_barang WHERE id_barang = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$barang = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$barang) {
    echo "<section class='content'>";
    echo "<h2>Data barang tidak ditemukan.</h2>";
    echo "<a href='index.php?page=barang/list'>Kembali</a>";
    echo "</section>";
    return;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = mysqli_prepare(
        $conn,
        "DELETE FROM data_barang WHERE id_barang = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {

        // Hapus gambar jika data berhasil dihapus
        if (!empty($barang['gambar'])) {
            $fileGambar = __DIR__ . '/../../gambar/'
                . basename($barang['gambar']);

            if (is_file($fileGambar)) {
                unlink($fileGambar);
            }
        }

        mysqli_stmt_close($stmt);

        echo "<section class='content'>";
        echo "<h2>Data barang berhasil dihapus!</h2>";
        echo "<a href='index.php?page=barang/list'>";
        echo "Kembali ke Data Barang";
        echo "</a>";
        echo "</section>";

        return;

    } else {
        $error = 'Gagal menghapus data barang.';
    }

    mysqli_stmt_close($stmt);
}
?>

<section class="content">

    <h2>Konfirmasi Hapus Barang</h2>

    <?php if ($error !== ''): ?>
        <p style="color:red;">
            <?= htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <p>Apakah kamu yakin ingin menghapus barang berikut?</p>

    <p>
        <strong>
            <?= htmlspecialchars($barang['nama']); ?>
        </strong>
    </p>

    <form method="POST">
        <button type="submit"
                onclick="return confirm('Yakin ingin menghapus barang ini?')">
            Ya, Hapus Barang
        </button>
    </form>

    <br>

    <a href="index.php?page=barang/list">
        Batal
    </a>

</section>
