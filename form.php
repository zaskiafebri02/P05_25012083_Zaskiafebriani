<?php
require_once 'functions.php';

$nama = $nim = $email = $prodi = $kegiatan = '';
$jumlah = 1;
$setuju = 0;
$errors = array();

$daftarProdi = array('D3 Manajemen Informatika', 'D3 Teknik Komputer', 'D4 Teknik Informatika');
$daftarKegiatan = array('Seminar', 'Workshop', 'Pelatihan', 'Pengabdian Masyarakat');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = bersihkanInput($_POST['nama']);
    $nim = bersihkanInput($_POST['nim']);
    $email = bersihkanInput($_POST['email']);
    $prodi = $_POST['prodi'];
    $kegiatan = $_POST['kegiatan'];
    $jumlah = intval($_POST['jumlah']);
    $setuju = isset($_POST['setuju']) ? 1 : 0;

    // Validasi
    if (empty($nama)) $errors['nama'] = 'Nama wajib diisi.';
    elseif (strlen($nama) < 3) $errors['nama'] = 'Nama minimal 3 karakter.';

    if (empty($nim)) $errors['nim'] = 'NIM wajib diisi.';
    elseif (!validasiNIM($nim)) $errors['nim'] = 'NIM harus 8-15 digit angka.';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Format email tidak valid.';

    if (!in_array($prodi, $daftarProdi)) $errors['prodi'] = 'Pilih program studi yang valid.';
    if (!in_array($kegiatan, $daftarKegiatan)) $errors['kegiatan'] = 'Pilih kegiatan yang valid.';

    if ($jumlah < 1 || $jumlah > 3) $errors['jumlah'] = 'Jumlah peserta harus 1-3.';
    if (!$setuju) $errors['setuju'] = 'Wajib menyetujui persyaratan.';

    // Jika valid → pindah ke halaman sukses
    if (empty($errors)) {
        header('Location: sukses.php?nama=' . urlencode($nama) . '&nim=' . urlencode($nim) . '&kegiatan=' . urlencode($kegiatan));
        exit;
    }
}
?>
<?php include 'components/header.php'; ?>

<h1>📝 Form Pendaftaran Kegiatan Mahasiswa</h1>
<form method="post" novalidate>
    <label>Nama Lengkap:</label>
    <input type="text" name="nama" value="<?php echo e($nama); ?>">
    <small><?php echo isset($errors['nama']) ? e($errors['nama']) : ''; ?></small>

    <label>NIM:</label>
    <input type="text" name="nim" value="<?php echo e($nim); ?>">
    <small><?php echo isset($errors['nim']) ? e($errors['nim']) : ''; ?></small>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo e($email); ?>">
    <small><?php echo isset($errors['email']) ? e($errors['email']) : ''; ?></small>

    <label>Program Studi:</label>
    <select name="prodi">
        <option value="">-- Pilih Prodi --</option>
        <?php foreach ($daftarProdi as $p): ?>
            <option value="<?php echo $p; ?>" <?php echo $prodi === $p ? 'selected' : ''; ?>>
                <?php echo e($p); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <small><?php echo isset($errors['prodi']) ? e($errors['prodi']) : ''; ?></small>

    <label>Kegiatan:</label>
    <select name="kegiatan">
        <option value="">-- Pilih Kegiatan --</option>
        <?php foreach ($daftarKegiatan as $k): ?>
            <option value="<?php echo $k; ?>" <?php echo $kegiatan === $k ? 'selected' : ''; ?>>
                <?php echo e($k); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <small><?php echo isset($errors['kegiatan']) ? e($errors['kegiatan']) : ''; ?></small>

    <label>Jumlah Peserta (1-3):</label>
    <input type="number" name="jumlah" min="1" max="3" value="<?php echo e($jumlah); ?>">
    <small><?php echo isset($errors['jumlah']) ? e($errors['jumlah']) : ''; ?></small>

    <label>
        <input type="checkbox" name="setuju" <?php echo $setuju ? 'checked' : ''; ?>>
        Saya menyetujui persyaratan kegiatan
    </label>
    <small><?php echo isset($errors['setuju']) ? e($errors['setuju']) : ''; ?></small>

    <button type="submit">Daftar Sekarang</button>
</form>

<?php include 'components/footer.php'; ?>