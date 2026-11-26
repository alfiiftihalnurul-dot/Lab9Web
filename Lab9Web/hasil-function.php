
<?php
require_once __DIR__ . '/views/header.php';
require_once __DIR__ . '/helpers/functions.php';
?>

<section class="content">
    <h2>Perhitungan Total Belanja</h2>

    <?php
    $harga = 15000;
    $jumlah = 4;

    $total = hitungTotal($harga, $jumlah);
    ?>

    <p>Harga barang: Rp <?php echo number_format($harga, 0, ',', '.'); ?></p>

    <p>Jumlah barang: <?php echo $jumlah; ?></p>

    <p>Total belanja:
    <strong>Rp <?php echo number_format($total, 0, ',', '.'); ?></strong>
    </p>
</section>

<?php
require_once __DIR__ . '/views/footer.php';
?>
