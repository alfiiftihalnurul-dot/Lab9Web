
<?php

// Function konversi Celcius ke Fahrenheit
function konversiCelciusKeFahrenheit($c) {
    return ($c * 9/5) + 32;
}

// Function menentukan status nilai
function tentukanStatusNilai($nilai) {
    if ($nilai >= 85) {
        return "A (Sangat Baik)";
    } elseif ($nilai >= 75) {
        return "B (Baik)";
    } elseif ($nilai >= 60) {
        return "C (Cukup)";
    } elseif ($nilai >= 50) {
        return "D (Kurang)";
    } else {
        return "E (Sangat Kurang)";
    }
}

// Function menghitung total belanja
function hitungTotal($harga, $jumlah) {
    return $harga * $jumlah;
}

?>
