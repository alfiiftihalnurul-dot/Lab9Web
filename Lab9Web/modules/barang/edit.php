
<?php
require_once __DIR__ . '/../../config/database.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id <= 0) {
    echo "<p>ID barang tidak valid.</p>";
    return;
}

// Mengambil data barang berdasarkan ID
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
    echo "<p>Data barang tidak ditemukan.</p>";
    return;
}

$error = '';
$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama = trim($_POST['nama'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $harga_beli = $_POST['harga_beli'] ?? '';
    $harga_jual = $_POST['harga_jual'] ?? '';
    $stok = $_POST['stok'] ?? '';

    if (
        $nama === '' ||
        $kategori === '' ||
        !is_numeric($harga_beli) ||
        !is_numeric($harga_jual) ||
        !ctype_digit((string)$stok) ||
        (float)$harga_beli < 0 ||
        (float)$harga_jual < 0
    ) {
        $error = 'Periksa kembali data yang dimasukkan.';
    } else {

        $nama_gambar = $barang['gambar'];
        $gambar_baru = '';

        if (
            isset($_FILES['gambar']) &&
            $_FILES['gambar']['error'] !== UPLOAD_ERR_NO_FILE
        ) {
            $file = $_FILES['gambar'];

            if (
                $file['error'] !== UPLOAD_ERR_OK ||
                $file['size'] > 2 * 1024 * 1024
            ) {
                $error = 'Upload gagal atau ukuran gambar melebihi 2 MB.';
            } else {
                $info = @getimagesize($file['tmp_name']);

                $ekstensi = [
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/gif' => 'gif',
                    'image/webp' => 'webp'
                ];

                if (
                    $info === false ||
                    !isset($ekstensi[$info['mime']])
                ) {
                    $error = 'Format gambar tidak valid.';
                } else {
                    $gambar_baru = uniqid('barang_', true)
                        . '.' . $ekstensi[$info['mime']];

                    $folder = __DIR__ . '/../../gambar/';

                    if (!move_uploaded_file(
                        $file['tmp_name'],
                        $folder . $gambar_baru
                    )) {
                        $error = 'Gagal menyimpan gambar baru.';
                        $gambar_baru = '';
                    } else {
                        $nama_gambar = $gambar_baru;
                    }
                }
            }
        }

        if ($error === '') {

            $harga_beli = (float)$harga_beli;
            $harga_jual = (float)$harga_jual;
            $stok = (int)$stok;

            $stmt = mysqli_prepare(
                $conn,
                "UPDATE data_barang
                 SET kategori = ?, nama = ?, gambar = ?,
                 harga_beli = ?, harga_jual = ?, stok = ?
                 WHERE id_barang = ?"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "sssddii",
                $kategori,
                $nama,
                $nama_gambar,
                $harga_beli,
                $harga_jual,
                $stok,
                $id
            );

            if (mysqli_stmt_execute($stmt)) {

                if ($gambar_baru !== '' && $barang['gambar'] !== '') {
                    @unlink(
                        __DIR__ . '/../../gambar/' . basename($barang['gambar'])
                    );
                }

                $pesan = 'Data barang berhasil diperbarui!';

                $barang['nama'] = $nama;
                $barang['kategori'] = $kategori;
                $barang['harga_beli'] = $harga_beli;
                $barang['harga_jual'] = $harga_jual;
                $barang['stok'] = $stok;
                $barang['gambar'] = $nama_gambar;

            } else {
                $error = 'Gagal memperbarui data barang.';

                if ($gambar_baru !== '') {
                    @unlink(__DIR__ . '/../../gambar/' . $gambar_baru);
                }
            }

            mysqli_stmt_close($stmt);
        }
    }
}
?>

<section class="content">

    <h2>Ubah Data Barang</h2>

    <?php if ($pesan !== ''): ?>
        <p style="color:green;">
            <?= htmlspecialchars($pesan); ?>
        </p>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <p style="color:red;">
            <?= htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">

        <label>Nama Barang</label><br>
        <input type="text" name="nama"
        value="<?= htmlspecialchars($barang['nama']); ?>" required>
        <br><br>

        <label>Kategori</label><br>
        <input type="text" name="kategori"
        value="<?= htmlspecialchars($barang['kategori']); ?>" required>
        <br><br>

        <label>Harga Beli</label><br>
        <input type="number" name="harga_beli"
        value="<?= htmlspecialchars((string)$barang['harga_beli']); ?>" min="0" required>
        <br><br>

        <label>Harga Jual</label><br>
        <input type="number" name="harga_jual"
        value="<?= htmlspecialchars((string)$barang['harga_jual']); ?>" min="0" required>
        <br><br>

        <label>Stok</label><br>
        <input type="number" name="stok"
        value="<?= htmlspecialchars((string)$barang['stok']); ?>" min="0" required>
        <br><br>

        <label>Gambar Saat Ini</label><br>

        <?php if (!empty($barang['gambar'])): ?>
            <img src="gambar/<?= htmlspecialchars(basename($barang['gambar'])); ?>"
            width="100" alt="Gambar barang">
        <?php else: ?>
            Tidak ada gambar.
        <?php endif; ?>

        <br><br>

        <label>Ganti Gambar (Opsional)</label><br>
        <input type="file" name="gambar"
        accept="image/jpeg,image/png,image/gif,image/webp">
        <br><br>

        <button type="submit">Simpan Perubahan</button>

    </form>

    <br>

    <a href="index.php?page=barang/list">
        Kembali ke Data Barang
    </a>

</section>
