<?php
require_once 'functions.php';

$nama = isset($_GET['nama']) ? trim($_GET['nama']) : 'Peserta';
$nim = isset($_GET['nim']) ? trim($_GET['nim']) : '';
$kegiatan = isset($_GET['kegiatan']) ? trim($_GET['kegiatan']) : '';
?>
<?php include 'components/header.php'; ?>

<h1>✅ Pendaftaran Berhasil!</h1>
<p>Halo <strong><?php echo e($nama); ?></strong> (NIM: <?php echo e($nim); ?>)</p>
<p>Terima kasih telah mendaftar kegiatan: <strong><?php echo e($kegiatan); ?></strong></p>
<p>📧 Konfirmasi akan dikirim ke email kamu.</p>

<p><a href="form.php">← Kembali ke Form</a></p>

<?php include 'components/footer.php'; ?>