<?php
# Panggil kandungan fail;
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
        $q="harga<=$max_harga AND";
    }
    if(!empty($_POST['idkategori']) && is_numeric($_POST['idkategori'])){
        $item_kategori = $_POST['idkategori'];
        $q="item.idkategori = $item_kategori AND ";
    if(!empty($q)){
    $q="WHERE $q iditem >0";
    }
}
#Semak jika ada parameter 'layout' di URL, untuk tentukan jenis susun atur item.
if(isset($_GET['layout']) && $_GET['layout'] == 'table'){
    $layout='table';
}else{
    $layout = 'grid';
}
?>
<h2>Semua Item</h2>
<p>Susunan mengikut item terkini yang dimasukkan ke dalam portal ini didahulukan.</p>
<div align='center'>
<form method='POST' action=''>
<select name='idkategori'>
<option value=''selected>Kategori</option>
<?php
$sql = "SELECT * FROM kategori ORDER BY namakategori";
$result = mysqli_query($db,$sql);

while ($kategori = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $kategori_id = $kategori['idkategori'];
    $kategori_name = $kategori['namakategori'];
    
    if($kategori_id=$item_kategori){
        $selected="selected";
    }else{
        $selected = "";
    }
    echo "<option $selected value='$kategori_id'>$kategori_name</option>";
}
?>
</select>
<input type='text' name='item_name' value='<?php echo $item_name; ?>' placeholder='Nama item'><br>
<input type='number' name='min_harga' value='<?php echo $min_harga; ?>' placeholder='Harga minima'>
<input type='number' name='max_harga' value='<?php echo $max_harga; ?>'placeholder='Harga maksima' size='8'>
<br>
<input type='submit' name='search' value='Cari'> <input type='submit' name='reset' value='Reset'>
</form>
</div>
Paparan: <a href='?layout=grid'>Grid</a>-<a href='?layout=table'>Jadual</a>
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
        <tr><td width='40'></td><td>Item</td><td>Harga</td>
        <td>$label_b1</td><td>$label_b2</td><td>$label_b3</td>
        <td></td></tr>";

        foreach($items as $row){
        $id = $row['iditem'];
        $name = $row['namaltem'];
        $gambar = $row['gambar'];
        $harga = $row['harga'];
        $banding1 = $row['banding 1'];
        $banding2 = $row['banding2'];
        $banding3 = $row['banding3'];

        if(!empty($gambar)){
            $img="<img src='gambar/item/$gambar' width='100%'>";
        }else{
            $img = "";
        }

        echo "<tr><td>$img</td><td>$name</td><td>RM$harga</td>
        <td>$banding1</td><td>$banding2</td><td>$banding3</td>
        <td width='50'><a class='button' href='papar_item.php?id=$id'>Lihat</a></td>
        </tr>";
    }
    echo "</table>";

    }elseif($layout=='grid'){
        # Paparan senarai item dalam bentuk grid foreach($items as $row){
        $id= $row['iditem'];
        $name = $row['namaitem'];
        $gambar = $row['gambar'];
        $harga = $row['harga'];

        if(!empty($gambar)){
            $img="<img src='gambar/item/$gambar' width='100%'>";
        }else{
            $img="Tiada gambar.";
        }
        echo "<table class='column' width='31%' border='1' cellspacing='0' cellpadding='4'>
        <tr><td align='center' valign='top'>
            <h5>$name</h5>$img<br>RM$harga<br><a class='button' href='papar_item.php?id=$id>Lihat</a>
        </td></tr>
        </table>";
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