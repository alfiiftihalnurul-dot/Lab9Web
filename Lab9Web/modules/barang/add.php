
<?php
require_once __DIR__ . '/../../config/database.php';

$pesan = '';
$error = '';

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

        $nama_gambar = '';

        if (
            isset($_FILES['gambar']) &&
            $_FILES['gambar']['error'] !== UPLOAD_ERR_NO_FILE
        ) {
            $file = $_FILES['gambar'];

            if ($file['error'] !== UPLOAD_ERR_OK) {
                $error = 'Upload gambar gagal.';
            } elseif ($file['size'] > 2 * 1024 * 1024) {
                $error = 'Ukuran gambar maksimal 2 MB.';
            } else {
                $info = @getimagesize($file['tmp_name']);

                if ($info === false) {
                    $error = 'File harus berupa gambar yang valid.';
                } else {
                    $mime = $info['mime'];

                    $ekstensi = [
                        'image/jpeg' => 'jpg',
                        'image/png' => 'png',
                        'image/gif' => 'gif',
                        'image/webp' => 'webp'
                    ];

                    if (!isset($ekstensi[$mime])) {
                        $error = 'Format gambar tidak didukung.';
                    } else {
                        $nama_gambar = uniqid('barang_', true)
                            . '.' . $ekstensi[$mime];

                        $folder = __DIR__ . '/../../gambar/';

                        if (!is_dir($folder)) {
                            mkdir($folder, 0755, true);
                        }

                        if (!move_uploaded_file(
                            $file['tmp_name'],
                            $folder . $nama_gambar
                        )) {
                            $error = 'Gagal menyimpan gambar.';
                        }
                    }
                }
            }
        }

        if ($error === '') {

            $stmt = mysqli_prepare(
                $conn,
                "INSERT INTO data_barang
                (kategori, nama, gambar, harga_beli, harga_jual, stok)
                VALUES (?, ?, ?, ?, ?, ?)"
            );

            if ($stmt) {
                $harga_beli = (float)$harga_beli;
                $harga_jual = (float)$harga_jual;
                $stok = (int)$stok;

                mysqli_stmt_bind_param(
                    $stmt,
                    "sssddi",
                    $kategori,
                    $nama,
                    $nama_gambar,
                    $harga_beli,
                    $harga_jual,
                    $stok
                );

                if (mysqli_stmt_execute($stmt)) {
                    $pesan = 'Data barang berhasil ditambahkan!';
                } else {
                    $error = 'Gagal menyimpan data barang.';
                    if ($nama_gambar !== '') {
                        @unlink(__DIR__ . '/../../gambar/' . $nama_gambar);
                    }
                }

                mysqli_stmt_close($stmt);
            } else {
                $error = 'Query database gagal disiapkan.';
            }
        }
    }
}
?>

<section class="content">

    <h2>Tambah Barang</h2>

    <?php if ($pesan !== ''): ?>
        <p style="color:green;">
            <?= htmlspecialchars($pesan); ?>
        </p>
        <a href="index.php?page=barang/list">
            Lihat Data Barang
        </a>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <p style="color:red;">
            <?= htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">

        <label>Nama Barang</label><br>
        <input type="text" name="nama" required>
        <br><br>

        <label>Kategori</label><br>
        <input type="text" name="kategori" required>
        <br><br>

        <label>Harga Beli</label><br>
        <input type="number" name="harga_beli" min="0" required>
        <br><br>

        <label>Harga Jual</label><br>
        <input type="number" name="harga_jual" min="0" required>
        <br><br>

        <label>Stok</label><br>
        <input type="number" name="stok" min="0" required>
        <br><br>

        <label>Gambar Barang</label><br>
        <input type="file" name="gambar" accept="image/jpeg,image/png,image/gif,image/webp">
        <br><br>

        <button type="submit">Simpan Barang</button>

    </form>

    <br>

    <a href="index.php?page=barang/list">
        Kembali ke Data Barang
    </a>

</section>

