<?php

// Daftar halaman yang diizinkan
$routes = [
    'dashboard'  => __DIR__ . '/views/dashboard.php',
    'barang/list' => __DIR__ . '/modules/barang/list.php',
    'barang/add'  => __DIR__ . '/modules/barang/add.php',
    'barang/edit' => __DIR__ . '/modules/barang/edit.php',
    'barang/delete' => __DIR__ . '/modules/barang/delete.php',
];

// Mengambil parameter page dari URL
$page = $_GET['page'] ?? 'dashboard';

// Validasi halaman menggunakan whitelist
if (!is_string($page) || !array_key_exists($page, $routes)) {
    http_response_code(404);
    $contentFile = __DIR__ . '/views/404.php';
} else {
    $contentFile = $routes[$page];
}

// Memanggil template dan konten
require_once __DIR__ . '/views/header.php';

require $contentFile;

require_once __DIR__ . '/views/footer.php';

?>
