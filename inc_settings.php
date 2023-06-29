<?php
# Nama sistem, dipaparkan di header dan title pelayar web
$portal_name='- Choose Your Phone -';

# Maklumat pangkalan data
$dbname='phoneselect';
$dbuser='root';
$dbpass='';
$dbhost='localhost';
# Buka sambungan ke pangkalan data
$db = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)OR die("Ralat:".mysqli_connect_error());

# Kriteria perbandingan:
$label_b1='Memori';
$label_b2='Kamera';
$label_b3='Bateri';

# Kategori item:
$label_cat='Jenama';
# Had maksima item dalam senarai banding
$compare_limit= 6;

# FUNCTION:Semak tahap pengguna dan tahap kebenaran akses
function checklogin($status){
    $level=$_SESSION['level'];
    $error='';
    if($level=='user'&& $status=='admin'){
        $error='Hanya admin boleh mengakses halaman ini.';
    }
    if($level=='visitor'&&($status=='admin'||$status=='user')){
        $error='Anda perlu log masuk untuk akses halaman ini.';
    }
    if(!empty($error)){
        echo"<script>
        alert('$error');
        window.location.replace('index.php');
        </script>";
        die();
        }
}

# Session dimulakan
session_start();
# Session untuk simpan dan baca saiz teks
if(isset($_SESSION['fontsize'])){
    $fontsize=$_SESSION['fontsize'];
}else{
    $fontsize=100;
}
if(isset($_GET['font'])){
    if($_GET['font']=='plus'){
        $fontsize+=1;
    }elseif($_GET['font']=='minus'){
        $fontsize-=1;
    }else{
        $fontsize=100;
    }
    $_SESSION['fontsize']=$fontsize;
}
if(isset($_SESSION['fontsize'])){
    $fontsize=$_SESSION['fontsize'];
}

# Session untuk simpan senarai banding
if(!isset($_SESSION['compare'])){
    $_SESSION['compare']=array();
}
$compare=$_SESSION['compare'];

# Session untuk simpan tahap pengguna, untuk tentukan akses halaman
if(!isset($_SESSION['idpengguna'])||!isset($_SESSION['namapengguna'])){
    $_SESSION['level']='visitor';
}
?>