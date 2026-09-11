<?php
function e($nilai) {
    return htmlspecialchars($nilai, ENT_QUOTES, 'UTF-8');
}

function validasiNIM($nim) {
    return preg_match('/^[0-9]{8,15}$/', $nim);
}

function bersihkanInput($data) {
    return trim(stripslashes($data));
}
?>