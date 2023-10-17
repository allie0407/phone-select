<?php
#Panggil kandungan fail:
include('inc_settings.php');
?>
<html>
<head>
    <title><?php echo $portal_name; ?></title>
    <!-- <h1 class='glow'>Choose Your Phone</h1> -->
    <link rel='stylesheet' href='style.css'>
    <style>
        /* style khas untuk kawal saiz teks pilihan pengguna */
        *{font-size: <?php echo $fontsize; ?>%;}
    </style>
</head>
<body>

<table width='100%' align='center' style='height: 100%; background: #F4F2DE;' cellpading='10' cellspacing='0' border='1' >
<tr style='background-image: url(gambar/Banner.png); background-position: center; background-size: cover;'>
    <td align='center' colspan='2' style='height: 100px;'>
    </td>
</tr>

<tr>
<!-- menu --> 
<td width='14%' align='center' 
style='background-image: url(gambar/Menu.png); background-repeat: no-repeat; background-attachment: fixed'>
    <?php
    # Semak jika ada item dalam session senarai banding, paparkan kiraan item
    if(!empty($_SESSION['compare'])){?>
    <a class='button' href='banding.php' style=margin-top:12px;>Banding (<?php echo count($_SESSION['compare'])."/".$compare_limit;?>)</a>
    <hr>
    <?php } ?>

    <!-- menu ini dipaparkan kepada semua pengguna -->
    <a class='mainmenu' href='index.php' style=margin-top:12px;>Laman Utama</a><br>
    <a class='mainmenu' href='senarai_item.php'>Senarai item</a><br>
    <a class='mainmenu' href='banding.php'>Senarai Banding</a><br>
    <a class='mainmenu' href='minat.php'>Senarai Minat</a><br>
    <?php
    if($_SESSION['level']=='visitor'){
    ?>
        <!-- menu ini dipaparkan kepada pengguna yang belum log masuk akaun -->
        <a class='mainmenu' href='login.php'>Log Masuk</a><br>
        <a class='mainmenu' href='daftar.php'>Daftar</a><br>

        <?php
        }else{
        ?>
        <!--menu ini dipaparkan kepada pengguna yang sudah log masuk akaun-->
            <a class='mainmenu' href='logout.php'>Log Keluar</a><br>
        <?php
        }
        if($_SESSION['level']=='admin'){?>
            <!--menu ini dipaparkan kepada admin sahaja-->
            <hr><h3 style='color:#2a2a2a;'><u>Menu Admin</u></h3>
            <a class='mainmenu-admin' href='admin_senarai_item.php'>Urus Item</a><br>
            <a class='mainmenu-admin' href='admin_borang_item.php'>Tambah Item</a><br>
            <a class='mainmenu-admin' href='admin_senarai_kategori.php'>Urus Jenama</a><br>
            <a class='mainmenu-admin' href='admin_borang_kategori.php'>Tambah <?php echo $label_cat;?></a><br>
    <?php } ?>
 <hr>
<!--hantar parameter kawal saiz teks (nilai diterima oleh kod dalam inc_function.php)-->
<p style='color:2a2a2a;'>Saiz Teks:</p>
<a class='button' href='?font=plus'>+</a>|<a class='button' href='?font=minus'>-</a>
<a href='?font=reset'>Reset</a>
<hr>
<pre><a href='javascript:void(0);' onclick='window.print()'>Cetak Halaman</a><br>
<a href='javascript:void(0);' onclick='printcontent("printcontent")'>Cetak Kandungan</a><br>
</td></pre>

<td width='100%' id='printcontent'>
<div>
<div style='margin-left: 15px; margin-right: 15px; margin-top: 15px; margin-bottom: 15px;'>