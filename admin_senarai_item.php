<?php
#Panggil kandungan fail:
include('inc_header.php');
checklogin('admin'); # Boleh diakses oleh admin sahaja

# Semak jika ada parameter 'delete' di URL. Dan nilainya mestilah nombor
if(isset($_GET['delete'])&& is_numeric($_GET['delete'])){
    $iditem=$_GET['delete'];

    # Semak rekod item
    $sql="SELECT iditem, gambar FROM item WHERE iditem=$iditem LIMIT 1";
    $result=mysqli_query($db,$sql)OR die("Ralat:<pre>$sql</pre>".mysqli_error($db));

    # Jika item ditemui
    if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

            # Semak jika gambar item ada, delete gambar dulu
            $gambar=$row['gambar'];
            $file=__DIR__.'/gambar/item/'.$gambar;
            if(!empty($gambar)&& file_exists($file)){
                unlink($file);
            }
        }
        # Delete item dari pangkalan data
        $sql="DELETE FROM item WHERE iditem=$iditem";
        $result=mysqli_query($db,$sql)OR die("Ralat:<pre>$sql</pre>".mysqli_error($db));
        echo"<script>
        alert('Item berjaya dibuang.');
        window.location.replace('admin_senarai_item.php');
        </script>";
        die();
    }
}
?>
<a class='button' href="admin_borang_item.php">Tambah Item</a><br><br>
<?php
$sql="SELECT item.*,kategori.namakategori as namakategori FROM item
LEFT JOIN kategori on item.idkategori=kategori.idkategori ORDER BY iditem DESC";

$result=mysqli_query($db,$sql)OR die("Ralat:<pre>$sql</pre>".mysqli_error($db));
# Dapatkan jumlah bilangan item
$total=mysqli_num_rows($result);
# Counter untuk nombor bilangan di table
$counter=1;
if($total>0){
    echo"Jumlah:$total<br>";
    echo"<table width='100%' align='center' border='1' cellpadding='4' cellspacing='0'>
    <tr>
    <td width='50'>No.</td>
    <td width='200'>Nama</td>
    <td width='100'>$label_cat</td>
    <td width='200'>Gambar</td>
    <td width='100'>Edit</td>
    </tr>";

    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

        $id=$row['iditem'];
        $name=$row['namaitem'];
        $kategori=$row['namakategori'];
        $gambar=$row['gambar'];

        # Jika imej ada nilai, paparkan imej, jika tidak, paparkan 'Tiada'
        if(!empty($gambar)){
            $img="<img src='gambar/item/$gambar' width='100'>";
        }else{
            $img="Tiada.";
        }
        echo"<tr>
        <td>$counter</td>
        <td>$name</td>
        <td>$kategori</td>
        <td>$img</td>
        <td>
        <a href='admin_borang_item.php?id=$id'>Edit</a> -
        <a href='javascript:void(0);' onclick='deletethis($id)'>Buang</a>
        </td>
        </tr>";
        # Tambah counter untuk nombor baris berikutnya
        $counter=$counter+1;
    }
    echo"</table>";
}else{
    echo"Belum ada data.";
}
?>
<script>
    //kod skrip fungsi tanya pengesahan kepada pengguna sebelum buang rekod
    function deletethis(val){
        if(confirm("Anda pasti?")==true){
            window.location.replace('admin_senarai_item.php?delete='+val);
        }
    }
</script>

<?php
# Panggil kandungan fail:
include('inc_footer.php');
?>