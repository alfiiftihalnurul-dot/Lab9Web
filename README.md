# Praktikum 9: PHP Modularisasi

## Identitas Project
- **Nama Project:** Lab9Web
- **Bahasa Pemrograman:** PHP
- **Database:** MySQL
- **Web Server:** XAMPP
- **Folder Project:** `htdocs/Lab9Web`
- **Nama:** Alfi Ifthal Nurul Afiat
-**Nim:** 312510041
- **kelas:** 312510041

## Deskripsi Project
Project Lab9Web merupakan aplikasi pengelolaan data barang berbasis PHP. Project ini menerapkan konsep modularisasi agar kode program lebih terstruktur dan mudah dikelola.

Aplikasi ini memiliki fitur CRUD (Create, Read, Update, Delete) untuk mengelola data barang yang tersimpan di database MySQL.

Fitur utama:
- Menampilkan daftar barang.
- Menambahkan data barang.
- Mengubah data barang.
- Menghapus data barang.
- Mengelola halaman menggunakan sistem routing.
- Menggunakan helper functions untuk fungsi tambahan.

## Struktur Folder Project

```text
Lab9Web/
├── assets/
│   └── css/
│       └── style.css
├── config/
│   └── database.php
├── helpers/
│   └── functions.php
├── modules/
│   └── barang/
│       ├── add.php
│       ├── delete.php
│       ├── edit.php
│       └── list.php
├── views/
│   ├── 404.php
│   ├── dashboard.php
│   ├── footer.php
│   └── header.php
├── index.php
├── home.php
├── profil.php
├── kontak.php
├── pesan.php
├── latihan-function.php
├── hasil-function.php
├── test-database.php
├── uji-include.php
└── uji-require.php
```

## Persiapan dan Menjalankan Project

1. Pastikan XAMPP sudah terpasang.
2. Salin folder `Lab9Web` ke dalam folder `C:\xampp\htdocs\`.
3. Buka XAMPP Control Panel.
4. Jalankan Apache dan MySQL.
5. Buat database MySQL dengan nama `latihan1`.
6. Pastikan tabel `data_barang` sudah tersedia.
7. Periksa konfigurasi database pada file `config/database.php`.
8. Buka browser dan akses alamat:

```text
http://localhost/Lab9Web/
```

## Konfigurasi Database

File konfigurasi database berada di:

`config/database.php`

File ini digunakan untuk menghubungkan aplikasi PHP dengan database MySQL menggunakan fungsi `mysqli_connect()`.

Konfigurasi yang digunakan dalam project:

- Host: `localhost`
- Username: `root`
- Password: kosong
- Database: `latihan1`

Jika koneksi database gagal, program akan menampilkan pesan bahwa koneksi database gagal.

## Struktur Modular

Project ini menggunakan konsep modularisasi dengan memisahkan beberapa bagian program ke dalam folder berbeda.

Penjelasan folder:

- **config:** menyimpan konfigurasi database.
- **helpers:** menyimpan fungsi-fungsi bantuan.
- **modules:** menyimpan modul pengelolaan data barang.
- **views:** menyimpan tampilan halaman, header, footer, dashboard, dan halaman 404.
- **assets:** menyimpan file pendukung seperti CSS.

Pemisahan ini membuat kode lebih terorganisir dan mudah dikembangkan.

## Sistem Routing

Routing digunakan untuk mengatur halaman yang akan ditampilkan berdasarkan parameter URL.

File utama yang mengatur routing adalah `index.php`.

Daftar halaman yang tersedia:

- `dashboard`
- `barang/list`
- `barang/add`
- `barang/edit`
- `barang/delete`

Contoh akses halaman:

```text
http://localhost/Lab9Web/index.php?page=dashboard
http://localhost/Lab9Web/index.php?page=barang/list
http://localhost/Lab9Web/index.php?page=barang/add
```

Jika halaman yang diminta tidak tersedia, aplikasi akan menampilkan halaman 404.

## Helper Functions

File helper berada di:

`helpers/functions.php`

File tersebut berisi tiga fungsi:

1. `konversiCelciusKeFahrenheit($c)` untuk mengubah suhu Celsius menjadi Fahrenheit.
2. `tentukanStatusNilai($nilai)` untuk menentukan kategori nilai A sampai E.
3. `hitungTotal($harga, $jumlah)` untuk menghitung total belanja.

## Fitur CRUD Data Barang

### 1. READ (Menampilkan Data)

File: `modules/barang/list.php`

READ digunakan untuk mengambil dan menampilkan seluruh data barang dari database.

Data ditampilkan dalam bentuk tabel yang berisi:
- Nomor
- Gambar
- Nama barang
- Kategori
- Harga beli
- Harga jual
- Stok
- Aksi ubah dan hapus

![gambar](ss/SS16.png)

### 2. CREATE (Menambahkan Data)

File: `modules/barang/add.php`

CREATE digunakan untuk menambahkan data barang baru ke database.

Form tambah barang berisi:
- Nama barang
- Kategori
- Harga beli
- Harga jual
- Stok
- Gambar barang

Program melakukan validasi input sebelum menyimpan data.

![gambar](ss/SS17.png)
![gambar](ss/SS18.png)


### 3. UPDATE (Mengubah Data)

File: `modules/barang/edit.php`

UPDATE digunakan untuk mengubah data barang yang sudah tersimpan di database.

Program mengambil data berdasarkan ID barang, kemudian menampilkan data lama pada form edit. Pengguna dapat mengubah informasi barang dan menyimpan perubahan.

![gambar](ss/SS19.png)

### 4. DELETE (Menghapus Data)

File: `modules/barang/delete.php`

DELETE digunakan untuk menghapus data barang dari database.

Sebelum data dihapus, aplikasi menampilkan konfirmasi penghapusan. Jika proses berhasil, data barang akan dihapus dari database.

![gambar](ss/SS20.png)
, dan menghapus data barang yang tersimpan di database MySQL.
