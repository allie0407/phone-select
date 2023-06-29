<?php
# Sambung akses session pengguna semasa
session_start();
# Hapuskan semua pembolehubah dalam session
session_unset();
# Hapuskan keseluruhan session pengguna
session_destroy();
# Paparkan mesej berjaya dan bawa pengguna ke halaman utama
echo"<script>
alert('Log Keluar berjaya.');
window.location.replace('index.php');
</script>";
?>