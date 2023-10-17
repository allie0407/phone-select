<?php
#Panggil kandungan fail:
include('inc_header.php');
checklogin('admin'); # Boleh diakses oleh admin sahaja

# Tentukan mode kegunaan borang, Tambah kategori/ Edit kategori
$edit_data=0; # Jika 0 ialah Tambah, selain 0 ialah Edit
# Nilai awal pembolehubah untuk 'value' dalam borang
$name="";
# Semak jika ada parameter 'id' di URL. Dan nilai id itu mestilah nombor
if(isset($_GET['id'])&& is_numeric($_GET['id'])){

    $id=(int)$_GET['id'];
    $sql="SELECT*FROM kategori WHERE idkategori=$id LIMIT 1";
    $result=mysqli_query($db,$sql)OR die("Ralat:<pre>$sql</pre>".mysqli_error($db));

    # Jika kategori ada dalam pangkalan data, set nilai $edit_data
    if(mysqli_num_rows($result)>0){
        # Nilai $edit_data bukan lagi 0, bermakna mode borang akan digunakan untuk edit
        $edit_data=mysqli_fetch_array($result,MYSQLI_ASSOC);
        $name=$edit_data['namakategori'];
    }else{
        echo"<script>alert('ID tidak ditemui.');</script>";
    }
}
# Semak nilai POST daripada borang
if(isset($_POST['name'])&& !empty($_POST['name'])){

    $name=mysqli_real_escape_string($db,$_POST['name']);
    if($edit_data){
        # Jika mode edit, laksana UPDATE rekod sedia ada
        $sql="UPDATE IGNORE kategori SET namakategori='$name' WHERE idkategori=$id";
    }else{
        # Jika bukan mode edit, laksana INSERT rekod baru
        $sql="INSERT IGNORE INTO kategori(namakategori) VALUES('$name')";
    }
    $result=mysqli_query($db,$sql)OR die("Ralat:<pre>$sql</pre>".mysqli_error($db));
    echo"<script>
    alert('$label_cat berjaya disimpan.');
    window.location.replace('admin_senarai_kategori.php');
    </script>";
}
# Terima fail import senarai kategori
if(isset($_FILES["import"])){
    # Kiraan baris yang selesai diproses
    $counter=0;
    $file=fopen($_FILES["import"]["tmp_name"],'rb');
    # Proses setiap baris teks
    while(($line=fgets($file))!==false){
        $name=trim($line); # Trim untuk buang jika ada space di depan dan belakang teks
        # Jika baris mengandungi teks
        if(!empty($name)){
            # Masukkan teks tersebut ke pangkalan data
            $sql="INSERT IGNORE INTO kategori(namakategori) VALUES('$name')";
            $result=mysqli_query($db,$sql)OR die("Ralat:<pre>$sql</pre>".mysqli_error($db));
            $counter+=1; # Tambah 1 ke nilai counter
        }
    }
    echo"<script>
    alert('$counter $label_cat berjaya diproses. Jika ada $label_cat yang sama, ia telah diabaikan.');
    window.location.replace('admin_senarai_kategori.php');
    </script>";
}
?>
<form method="POST" action="">
    <p style='margin-top: 18px'>
        <label for='name'>Tambah <?php echo $label_cat;?></label><br>
        <input type='text' name='name' id='name' value='<?php echo $name;?>' autocomplete="off"><br>
</p>
<p><input type="submit" value="Simpan"></p>
</form>
<hr>
<?php
# JIKA: Papar borang import jika mode borang adalah Tambah kategori
if(!$edit_data){
    ?>
    <h3>Import Senarai <?php echo $label_cat;?></h3>
    <p>
        Cipta satu fail txt atau csv yang mengandungi senarai <?php echo $label_cat;?> sahaja.<br>
        Setiap <?php echo $label_cat;?> diletakkan di baris beasingan.
</p>
<p>
    Contoh fail: <?php echo $label_cat;?>.csv<br>
    <code>
    <?php echo $label_cat;?> 1<br>
    <?php echo $label_cat;?> 2<br>
    <?php echo $label_cat;?> 3<br>
</code>
</p>
<form method="POST" action="" enctype="multipart/form-data">
    <p>
        <label for='import'>Pilih fail senarai <?php echo $label_cat;?></label><br>
        <input type="file" name='import' id='import'>
</p>
<p><input type="submit" value="Simpan"></p>
</form>
<?php
} # TAMAT_JIKA

 # Panggil kandungan fail:
 include('inc_footer.php');
 ?>