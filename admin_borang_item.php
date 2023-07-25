<?php
# Panggil kandungan fail:
include('inc_header.php');
checklogin('admin'); # Boleh diakses oleh admin sahaja

# Berikan nilai awal pembolehubah, untuk kegunaan nilai 'value' borang di bawah
$name= $gambar = $detail = $harga = $idkategori = $banding1 = $banding2 = $banding3 ="";
$edit_data = 0; # 0 mewakili false/empty
# Jika 0 bermakna mode borang untuk data baru,
# Jika selain 0 bermakna mode borang untuk edit data

$id = 0;
# Semak jika ada parameter 'id' di URL Dan nilai id itu mestilah nombor.
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id= (int)$_GET['id'];
    $sql = "SELECT * FROM item WHERE iditem = $id LIMIT 1";
    $result = mysqli_query($db, $sql) OR die("Ralat:<pre>$sql</pre>". mysqli_error($db));
    # Jika item ada dalam pangkalan data, set nilai Sedit data
    if(mysqli_num_rows($result)>0){
        # Nilai $edit data bukan lagi 0, bermakna mode borang akan digunakan untuk edit data
        $edit_data = mysqli_fetch_array($result, MYSQLI_ASSOC);
        # Isi semua 'value' untuk borang
        $name=$edit_data['namaitem'];
        $detail=$edit_data['detail'];
        $harga=$edit_data['harga'];
        $idkategori=$edit_data['idkategori'];
        $banding1=$edit_data['banding1'];
        $banding2=$edit_data['banding2'];
        $banding3=$edit_data['banding3'];
        # Jika item ada gambar, sediakan kod untuk paparkan gambar
        if(!empty($edit_data['gambar'])){
            $img=$edit_data['gambar'];
            $img = "<img src='gambar/item/$gambar' alt='Gambar item' width='100%'>";
        }
    }else{

echo "<script>alert('ID tidak ditemui.');</script>";
    }
}
# Semak nilai POST daripada borang
if(isset($_POST['name']) && !empty($_POST['name'])){

    $name = mysqli_real_escape_string($db, $_POST['name']);
    $detail = mysqli_real_escape_string($db, $_POST['detail']);
    $harga = $_POST['harga'];
    $idkategori = $_POST['idkategori'];
    $banding1 = $_POST['banding1'];
    $banding2 = $_POST['banding2'];
    $banding3 = $_POST['banding3'];

    # Proses data mengikut mode borang, Edit atau Tambah rekod
    if($edit_data){

        $sql = "UPDATE item SET namaitem='$name', detail='$detail',
        banding1='$banding1', banding2='$banding2', banding3='$banding3',
        idkategori='$idkategori', harga='$harga' WHERE iditem=$id";

    }else{

        $sql = "INSERT INTO item (namaitem, detail, banding1, banding2, banding3, harga, idkategori)
        VALUES ('$name', '$detail', '$banding1', '$banding2', '$banding3', '$harga', '$idkategori')";
    }
    $result = mysqli_query($db, $sql) OR die("Ralat:<pre>$sql</pre>". mysqli_error($db));
    echo "<script>alert('Item berjaya disimpan.');
    window.location.replace('admin_senarai_item.php');
    </script>";
}
# Terima fail upload gambar item
if(isset($_FILES['gambar']) && $edit_data){
$i=$_FILES['gambar']; 
$file_size=$i['size'];
$file_tmp = $i['tmp_name'];
$file_name = explode('.', $i['name']);
$file_ext = strtolower(end($file_name));

# Berikan nilai empty string sebagai nilai awal
$error = "";
# Terima format fail yang dinyatakan sahaja
$ext= array('jpeg','jpg','png','bmp','gif');
 if(!in_array($file_ext, $ext)){
    $error.="Format fail tidak dibenarkan. Sila gunakan JPG atau PNG sahaja.";
 }
# Jika tiada error
if(empty($error)){
    # Set lokasi fall gambar
    $location=__DIR__.'/gambar/item/';
    # Semak jika ada gambar lama, delete dulu
    $oldname=$edit_data['gambar'];

if(!empty($oldname)){
    unlink($location.$oldname);
}
# Berikan nama baru untuk gambar, supaya kemas dan standardize
$newname='item_'.$id.'.'.$file_ext;
move_uploaded_file($file_tmp, $location.$newname);
# Simpan nama gambar baru ke pangkalan data
$sql = "UPDATE item SET gambar='$newname' WHERE iditem=$id";
$result = mysqli_query($db, $sql) OR die("Ralat:<pre>$sql</pre>". mysqli_error($db));
    echo "<script>
    alert('Imej item berjaya disimpan.');
    window.location.replace('admin_senarai_item.php');
    </script>";
}else{
    # Papar ralat jika $error tidak empty
    echo "<script>alert('Ralat: $error');</script>";
    }
}
?>
<br><a class='button' href="admin_senarai_item.php">Ke Senarai Item &#10145</a> <br><br>
<table align='center' width='100%' border='1' cellspacing='0' cellpadding='5'>
    <tr>
        <td valign='top'>
        <form method='POST' action=''>
        <p>
            <label>Nama Item</label><br>
            <input type='text' name='name' value='<?php echo $name; ?>' required autocomplete="off">
        </p>
        <p>
            <label>Maklumat Detail</label><br>
            <textarea type='text' name='detail' rows="6" cols="30" autocomplete="off"><?php echo $detail; ?></textarea>
        </p>
        <p>
            <label>Harga</label><br>
            <input type='number' name='harga' value='<?php echo $harga; ?>' step="0.01" min="0.01" max="50000" autocomplete="off">
        </p>
        <p>
            <label><?php echo $label_cat; ?> item</label><br>
            <select name='idkategori' required>
            <option value=''disabled selected>Sila pilih <?php echo $label_cat; ?></option>
        <?php
        # Dapatkan senarai kategori untuk dijadikan dropdown

        $sql="SELECT*FROM kategori ORDER BY namakategori";
        $result = mysqli_query($db,$sql);
        while ($kategori = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $kategori_id=$kategori['idkategori'];
            $kategori_name=$kategori['namakategori'];
            
            if($kategori_id==$idkategori){
                $selected="selected";
            }else{
                $selected="";
            }  
            echo "<option $selected value='$kategori_id'>$kategori_name</option>";
        }
        ?>
        </select>
        </p>
        <h3>Kriteria Perbandingan</h3>
        <p>
            <label><?php echo $label_b1; ?></label><br>
            <input type='text' name='banding1' value='<?php echo $banding1;  ?>' autocomplete="off"><br>
        </p>
        <p>
            <label><?php echo $label_b2; ?></label><br>
            <input type='text' name='banding2' value='<?php echo $banding2; ?>' autocomplete="off"><br>
        </p>
        <p>
            <label><?php echo $label_b3; ?></label><br>
            <input type='text' name='banding3' value='<?php echo $banding3; ?>' autocomplete="off"><br>
        </p>
        <p>
            <input type="submit" value="Simpan">
        </p>
    </form>
</td>
<td valign='top' align='center'>
<h3>Gambar Item</h3>
<?php
# Paparkan gambar jika ada semasa edit item
if($edit_data){
echo $gambar;
?>
<form method='POST' action='' enctype='multipart/form-data'>
    <p>
        <label for='gambar'>Muat-naik Gambar</label><br>
        <input type="file" name='gambar' id='gambar'>
    </p>
    <p>
        <input type='submit' value='Upload'>
    </p>
</form>
<?php
}else{
    echo "Gambar boleh dimuat-naik selepas maklumat disimpan.";
}
?>
</td>
</tr>
</table>

<?php
# Panggil kandungan fail:
include('inc_footer.php');
?>