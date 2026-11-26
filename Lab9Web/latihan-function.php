
<?php
require_once __DIR__ . '/views/header.php';
require_once __DIR__ . '/helpers/functions.php';
?>

<section class="content">
    <h2>Pengujian Function PHP</h2>

    <h3>1. Konversi Suhu</h3>
    <?php
    $celcius = 30;
    $fahrenheit = konversiCelciusKeFahrenheit($celcius);

    echo "Suhu Celcius: " . $celcius . "°C<br>";
    echo "Hasil Fahrenheit: " . $fahrenheit . "°F";
    ?>

    <h3>2. Menentukan Status Nilai</h3>
    <?php
    $nilai = 90;
    $status = tentukanStatusNilai($nilai);

    echo "Nilai: " . $nilai . "<br>";
    echo "Predikat: " . $status;
    ?>
</section>

<?php
require_once __DIR__ . '/views/footer.php';
?>
