<?php
#Panggil kandungan fail:
include('inc_settings.php');
?>
<html>
<head>
    <title><?php echo $portal_name; ?></title>
    <link rel='stylesheet' href='style.css'>
    <style>
        /* style khas untuk kawal saiz teks pilihan pengguna */
        *{font-size: <?php echo $fontsize; ?>%;}
    </style>
</head>
<body background='gambar/Pink.png'>

<table width='100%' align='center' style='height: 100%;' cellpading='10' cellspacing='0' border='1' background=''>
<tr background=''>
    <td align='center' valign='middle' colspan='2' style='height: 100px;'>
        <h1 style='font-size:40px'><?php echo $portal_name; ?></h1>
    </td>
</tr>

<tr>
<!-- menu --> 
<td width='15%' valign='top' align='center'>
    <?php
    # Semak jika ada item dalam session senarai banding, paparkan kiraan item
    if(!empty($_SESSION['compare'])){?>
    <a class='button' href='banding.php'>Banding (<?php echo count($_SESSION['compare'])."/".$compare_limit;?>)</a>
    <hr>
    <?php } ?>

    <!-- menu ini dipaparkan kepada semua pengguna -->
    <br><a class='mainmenu' href='index.php'>Laman Utama</a><br>
    <a class='mainmenu' href='senarai_item.php'>Senarai item</a><br>
    <a class='mainmenu' href='banding.php'>Senarai Banding</a><br>
    <a class='mainmenu' href='minat.php'>Senarai Minat</a><br>
    <?php
    if($_SESSION['level']=='visitor'){
    ?>
        <!-- menu ini dipaparkan kepada pengguna yang belum log masuk akaun -->
        <a class='mainmenu' href='login.php' style='background: pink;'>Log Masuk</a><br>
        <a class='mainmenu' href='daftar.php' style='background: pink;'>Daftar</a><br>
        <?php
        }else{
        ?>
        <!--menu ini dipaparkan kepada pengguna yang sudah log masuk akaun-->
            <a class='mainmenu' href='logout.php' style='background:pink;'>Log Keluar</a><br>
        <?php
        }
        if($_SESSION['level']=='admin'){?>
            <!--menu ini dipaparkan kepada admin sahaja-->
            <h3>Menu Admin</h3>
            <a class='mainmenu' href='admin_senarai_item.php'>Urus Item</a><br>
            <a class='mainmenu' href='admin_borang_item.php'>Tambah Item</a><br>
            <a class='mainmenu' href='admin_senarai_kategori.php'>Urus</a><br>
            <a class='mainmenu' href='admin_borang_kategori.php'>Tambah <?php echo $label_cat;?></a><br>
    <?php } ?>
 <hr>
<!--hantar parameter kawal saiz teks (nilai diterima oleh kod dalam inc_function.php)-->
Saiz Teks:<br>
<a class='button' href='?font=plus'>+</a>|<a class='button' href='?font=minus'>-</a>
<a href='font=reset'>Reset</a>
<hr>
<a href='javascript:void(0);'onclick='window.print()'>Cetak Halaman</a><br>
<a href='javascript:void(0);'onclick='printcontent("printcontent")'>Cetak Kandungan</a>
</td>
        
<td width='80%' valign='top'id='printcontent'>