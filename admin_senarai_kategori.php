<?php
#Panggil kandungan fail:
include('inc_header.php');
checklogin('admin'); # Boleh diakses oleh admin sahaja
# Kod untuk DELETE
# Semak jika ada parameter 'delete' di URL. Dan nilainya mestilah nombor.
if(isset($_GET['delete'])&& is_numeric($_GET['delete'])){
    $idkategori=$_GET['delete'];
    # Laksana query DELETE rekod tersebut dari pangkalan data
    $sql="DELETE FROM kategori WHERE idkategori=$idkategori";
    $result=mysqli_query($db,$sql)OR die("Ralat:<pre>$sql</pre>".mysqli_error($db));
    echo"<script>
    alert($label_cat berjaya dibuang.');
    window.location.replace('admin_senarai_kategori.php');
    </script>";
    die();
}
?>
<br><a class='button' href="admin_borang_kategori.php">Tambah <?php echo $label_cat;?> Baru &#10133</a><br><br>
<?php
# Query senaraikan kategori dan bilangan item yang ada dalam kategori tersebut
$sql="SELECT kategori.*,COUNT(item.iditem) as jumlahitem FROM kategori
LEFT JOIN item ON kategori.idkategori=item.idkategori GROUP BY kategori.namakategori ORDER BY kategori.namakategori";
$result=mysqli_query($db,$sql)OR die("Ralat:<pre>$sql</pre>".mysqli_error($db));
$total=mysqli_num_rows($result);

if($total>0){
    echo"Jumlah:$total<br>";
    echo"<table width='100%' align='center' border='1' cellpadding='4' cellspacing='0'>
    <tr>
    <th>$label_cat</td>
    <th width='20%' align='right'></td>
    </tr>";

    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
        $id=$row['idkategori'];
        $name=$row['namakategori'];
        $jumlahitem=$row['jumlahitem'];
        echo"<tr>
        <td>$name($jumlahitem item)</td>
        <td align='right'>
        <a href='admin_borang_kategori.php?id=$id'>Edit</a>-
        <a href='javascript:void(0);'onclick='deletethis($id)'>Buang</a>
        </td>
        </tr>";
    }
    echo"</table>";
}else{
    echo"Belum ada data";
}
?>
<script>
    //Kod skrip tanya pengesahan kepada pengguna sebelum buang rekod
    function deletethis(val){
        if(confirm("Anda pasti?")==true){
            window.location.replace('admin_senarai_kategori.php?delete='+val);
        }
    }
</script>

<?php
# Panggil kandungan fail:
include('inc_footer.php');
?>