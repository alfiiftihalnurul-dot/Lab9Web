
<?php
require_once __DIR__ . '/../../config/database.php';

$sql = "SELECT * FROM data_barang ORDER BY id_barang ASC";
$result = mysqli_query($conn, $sql);
?>

<section class="content">

    <h2>Data Barang</h2>

    <p>Daftar barang yang tersimpan dalam database.</p>

    <p>
        <a href="index.php?page=barang/add">
            + Tambah Barang
        </a>
    </p>

    <table border="1" cellpadding="10"
           cellspacing="0" width="100%">

        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

        <?php if ($result && mysqli_num_rows($result) > 0): ?>

            <?php $no = 1; ?>

            <?php while ($row = mysqli_fetch_assoc($result)): ?>

                <tr>
                    <td><?= $no++; ?></td>

                    <td>
                        <?php if (!empty($row['gambar'])): ?>
                            <img
                                src="gambar/<?= htmlspecialchars($row['gambar']); ?>"
                                width="60"
                                alt="Gambar barang"
                            >
                        <?php else: ?>
                            Tidak ada gambar
                        <?php endif; ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['nama']); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['kategori']); ?>
                    </td>

                    <td>
                        Rp <?= number_format($row['harga_beli'], 0, ',', '.'); ?>
                    </td>

                    <td>
                        Rp <?= number_format($row['harga_jual'], 0, ',', '.'); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars((string)$row['stok']); ?>
                    </td>

                    <td>
                        <a href="index.php?page=barang/edit&id=<?= (int)$row['id_barang']; ?>">
                            Ubah
                        </a>
                        |
                        <a href="index.php?page=barang/delete&id=<?= (int)$row['id_barang']; ?>">
                            Hapus
                        </a>
                    </td>
                </tr>

            <?php endwhile; ?>

        <?php else: ?>

            <tr>
                <td colspan="8">Belum ada data barang.</td>
            </tr>

        <?php endif; ?>

        </tbody>
    </table>

</section>

