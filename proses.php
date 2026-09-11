<?php
require_once 'functions.php';

// Inisialisasi variabel
$nama = $nim = $email = $prodi = $kegiatan = '';
$jumlah = 1;
$setuju = 0;
$errors = array();

// Daftar pilihan yang diizinkan
$daftarProdi = array('D3 Manajemen Informatika', 'D3 Teknik Komputer', 'D4 Teknik Informatika');
$daftarKegiatan = array('Seminar', 'Workshop', 'Pelatihan', 'Pengabdian Masyarakat');

// Proses hanya jika metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil dan bersihkan input
    $nama = bersihkanInput($_POST['nama']);
    $nim = bersihkanInput($_POST['nim']);
    $email = bersihkanInput($_POST['email']);
    $prodi = isset($_POST['prodi']) ? $_POST['prodi'] : '';
    $kegiatan = isset($_POST['kegiatan']) ? $_POST['kegiatan'] : '';
    $jumlah = isset($_POST['jumlah']) ? intval($_POST['jumlah']) : 1;
    $setuju = isset($_POST['setuju']) ? 1 : 0;

    // Validasi setiap field
    if (empty($nama)) {
        $errors['nama'] = 'Nama wajib diisi.';
    } elseif (strlen($nama) < 3) {
        $errors['nama'] = 'Nama minimal 3 karakter.';
    }

    if (empty($nim)) {
        $errors['nim'] = 'NIM wajib diisi.';
    } elseif (!preg_match('/^[0-9]{8,15}$/', $nim)) {
        $errors['nim'] = 'NIM harus berupa 8-15 digit angka.';
    }

    if (empty($email)) {
        $errors['email'] = 'Email wajib diisi.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Format email tidak valid.';
    }

    if (empty($prodi)) {
        $errors['prodi'] = 'Program studi wajib dipilih.';
    } elseif (!in_array($prodi, $daftarProdi)) {
        $errors['prodi'] = 'Pilih program studi dari daftar yang tersedia.';
    }

    if (empty($kegiatan)) {
        $errors['kegiatan'] = 'Kegiatan wajib dipilih.';
    } elseif (!in_array($kegiatan, $daftarKegiatan)) {
        $errors['kegiatan'] = 'Pilih kegiatan dari daftar yang tersedia.';
    }

    if ($jumlah < 1 || $jumlah > 3) {
        $errors['jumlah'] = 'Jumlah peserta harus antara 1 dan 3.';
    }

    if (!$setuju) {
        $errors['setuju'] = 'Wajib menyetujui persyaratan kegiatan.';
    }

    // Jika tidak ada error → arahkan ke halaman sukses (Pola PRG)
    if (empty($errors)) {
        header('Location: sukses.php?nama=' . urlencode($nama) . '&nim=' . urlencode($nim) . '&kegiatan=' . urlencode($kegiatan));
        exit;
    }

    // Jika ada error → kembalikan ke form dengan pesan error
    else {
        session_start();
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $_POST;
        header('Location: form.php');
        exit;
    }
}
?>