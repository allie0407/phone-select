<?php
# Panggil kandungan fail:
include('inc_header.php');

# Berikan nilai awal untuk borang carian
$item_kategori = $item_name = $min_harga = $max_harga='';
# $q adalah pembolehubah penyataan SQL tambahan jika pengguna buat carian
$q = '';
# Tambah kriteria carian ke dalam query sql jika ada nilai dari borang carian
if(isset($_POST['search'])){
    if(!empty($_POST['item_name'])){
        $item_name=$_POST['item_name'];
        $q.="item.namaitem LIKE '%$item_name%' AND ";
    }
    if(!empty($_POST['min_harga']) && is_numeric($_POST['min_harga'])){
        $min_harga=$_POST['min_harga'];
        $q.="harga>=$min_harga AND ";
    } 
    if(!empty($_POST['max_harga']) && is_numeric($_POST['max_harga'])){
        $max_harga = $_POST['max_harga'];
        $q.="harga<=$max_harga AND ";
    }
    if(!empty($_POST['idkategori']) && is_numeric($_POST['idkategori'])){
        $item_kategori = $_POST['idkategori'];
        $q.="item.idkategori = $item_kategori AND ";
    }
        if(!empty($q)){
    $q="WHERE $q iditem > 0";
    }
}
#Semak jika ada parameter 'layout' di URL, untuk tentukan jenis susun atur item.
if(isset($_GET['layout']) && $_GET['layout'] == 'table'){
    $layout = 'table';
}else{
    $layout = 'grid';
}
?>
<h2><u>Semua Item</u></h2>
<p>Susunan mengikut item terkini yang dimasukkan ke dalam portal ini didahulukan.</p>
<div align='center'>
<form method='POST' action=''>
<select name='idkategori'>
<option value=''selected>Jenama</option>
<?php
$sql = "SELECT * FROM kategori ORDER BY namakategori";
$result = mysqli_query($db,$sql);

while ($kategori = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $kategori_id = $kategori['idkategori'];
    $kategori_name = $kategori['namakategori'];
    
    if($kategori_id==$item_kategori){
        $selected="selected";
    }else{
        $selected = "";
    }
    echo "<option $selected value='$kategori_id'>$kategori_name</option>";
}
?>
</select>
<input type='text' name='item_name' value='<?php echo $item_name; ?>' placeholder='Nama Item' autocomplete='off'>
<input type='number' name='min_harga' value='<?php echo $min_harga; ?>' placeholder='Harga Minima'>
<input type='number' name='max_harga' value='<?php echo $max_harga; ?>'placeholder='Harga Maksima' size='8'>
<pre><input type='submit' name='search' value='Cari'> <input type='submit' name='reset' value='Reset'></pre>
</form>
</div>
Paparan: <a href='?layout=grid'>Grid</a> / <a href='?layout=table'>Jadual</a>
<hr>
<div class='row'>
<?php
# Dapatkan semua item ATAU dapatkan berdasarkan kriteria dalam pembolehubah $q sahaja
$sql = "SELECT item.*, kategori.namakategori as kategori FROM item 
LEFT JOIN kategori on item.idkategori = kategori.idkategori
$q ORDER BY iditem DESC";
$result = mysqli_query($db, $sql) OR die("Ralat:<pre>$sql</pre>".mysqli_error($db));

if(mysqli_num_rows($result)>0){
    #Kumpulkan item ke dalam array baru
    $items = array();
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $items[] = $row;
    }

    if($layout=='table'){
        #Paparan senarai item dalam bentuk jadual
        echo "<table width='100%' border='1' cellspacing='0' cellpadding='2'>
        <tr><td width='150'>Gambar</td><td>Item</td><td>Harga</td>
        <td>$label_b1</td><td>$label_b2</td><td>$label_b3</td>
        </tr>";

        foreach($items as $row){
        $id = $row['iditem'];
        $kategori = $row['kategori'];
        $name = $row['namaitem'];
        $gambar = $row['gambar'];
        $harga = $row['harga'];
        $banding1 = $row['banding1'];
        $banding2 = $row['banding2'];
        $banding3 = $row['banding3'];

        if(!empty($gambar)){
            $img="<img src='gambar/item/$gambar' width='100' height='125'>";
        }else{
            $img = "";
        }

        echo "<tr><td align='center'><br>$img<br><a class='button' href='papar_item.php?id=$id'>Lihat</a></td>
        <td>$kategori $name</td><td>RM$harga</td>
        <td>$banding1</td><td>$banding2</td><td>$banding3</td>
        </tr>";
    }
    echo "</table>";

    }elseif($layout=='grid'){
        # Paparan senarai item dalam bentuk grid
        ?>
        <div class='grid'>
            <?php
        foreach($items as $row){
        $id= $row['iditem'];
        $kategori = $row['kategori'];
        $name = $row['namaitem'];
        $gambar = $row['gambar'];
        $harga = $row['harga'];

        if(!empty($gambar)){
            $img="<img src='gambar/item/$gambar' width='140' height='180'>";
        }else{
            $img="Tiada gambar.";
        }
        
        echo
            "<div class='phone-container'><b>$kategori</b><br><strong>$name</strong><pre>$img</pre>RM$harga<br>
            <a class='button' href='papar_item.php?id=$id'>Lihat</a></div>";
        }
    }
}else{
    echo "Tiada item ditemui.";
} 
?>
</div>

<?php
# Panggil kandungan fail:
include('inc_footer.php');
?>