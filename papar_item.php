<?php
#Panggil kandungan fail:
include('inc_header.php');

# Semak jika ada paramater 'id' di URL. Dan nilainya mestilah nombor
if(isset($_GET['id'])&& is_numeric($_GET['id'])){
    $id=$_GET['id'];
}else{
    echo"<script>
    alert('ID item diperlukan.');
    window.location.replace('senarai_item.php');
    </script>";
    die();
}

$sql="SELECT item.*,kategori.namakategori as kategori FROM item
LEFT JOIN kategori on item.idkategori=kategori.idkategori WHERE iditem=$id LIMIT 1";
$result=mysqli_query($db,$sql)OR die("Ralat<pre>$sql</pre>".mysqli_error($db));
# Jika item ditemui, paparkan maklumat item
if(mysqli_num_rows($result)>0){

    while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
    
        $id= $row['iditem'];
        $name = $row['namaitem'];
        $detail = $row['detail'];
        $kategori = $row['kategori'];
        $harga = $row['harga'];
        $gambar = $row['gambar']; 
        $banding1 = $row['banding1'];
        $banding2 = $row['banding2'];
        $banding3= $row['banding3'];
        
        if(!empty($gambar)){
            $img="<img src='gambar/item/$gambar' width='200' height='255'>";
        }else{
            $img="Tiada imej.";
        }
    echo "<table width='100%' border='1' cellspacing='0' cellpadding='10'>
    <tr>
        <td align='center' valign='middle' width='30%'>$img<br>RM$harga</td>
    <td>
        <h2><u>$kategori - $name</u></h2>
        <p style='white-space: pre-line;' >$detail</p>
        <h5><u>Maklumat</u></h5>
        <ul>
        <li>$label_b1: $banding1</li>
        <li>$label_b2: $banding2</li>
        <li>$label_b3: $banding3</li>
        </ul>
    </td>
    </tr>
    <tr>
    <td colspan='2' align='center'>Masukkan ke :
        <a class='button' href='banding.php?id=$id&action=add'>Senarai Banding</a>
        <a class='button' href='minat.php?id=$id&action=add'>Senarai Minat</a>
    </td>
    </tr>
    </table>";
    }  
}else{
    echo "Item tidak ditemui.";
}
?>

<?php
#Panggil kandungan fail:
include('inc_footer.php');
?>