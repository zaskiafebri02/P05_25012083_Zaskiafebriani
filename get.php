<?php
require_once 'functions.php';

if (isset($_GET['q'])) {
    $kataKunci = trim($_GET['q']);
} else {
    $kataKunci = '';
}

if (isset($_GET['kategori'])) {
    $kategori = $_GET['kategori'];
} else {
    $kategori = 'semua';
}

$kategoriValid = array('semua', 'minuman', 'makanan', 'alat-tulis');

if (!in_array($kategori, $kategoriValid, true)) {
    $kategori = 'semua';
}
?>
<?php include 'components/header.php'; ?>

<h1>🔍 Pencarian Produk</h1>
<form method="get">
    <label>Kata Kunci:</label>
    <input type="text" name="q" value="<?php echo e($kataKunci); ?>">

    <label>Kategori:</label>
    <select name="kategori">
        <?php foreach ($kategoriValid as $item): ?>
            <option value="<?php echo $item; ?>" <?php echo ($kategori === $item) ? 'selected' : ''; ?>>
                <?php echo e(ucwords(str_replace('-', ' ', $item))); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Cari</button>
</form>

<?php if ($kataKunci !== ''): ?>
    <p>✅ Mencari: <strong><?php echo e($kataKunci); ?></strong> (Kategori: <?php echo e(ucwords(str_replace('-', ' ', $kategori))); ?>)</p>
<?php endif; ?>

<?php include 'components/footer.php'; ?>