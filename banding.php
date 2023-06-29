<?php
include('inc_header.php');

# Semak jika ada parameter 'action' dan 'id' di URL.
if(isset($_GET['id']) && is_numeric($_GET['id']) && isset($_GET['action'])){
    $id = $_GET['id'];
    $action = $_GET['action']; # Dapatkan tindakan yang diklik pengguna
    # Jika tindakan adalah 'add'
    if($action == 'add'){
        # Semak jika senarai banding penuh, limit-1 kerana array bermula dengan 0
        if(count($compare) >= $compare_limit-1){
            echo "<script>alert('Senarai Banding sudah penuh.');
            history.go(-1); </script>";
            die();
        }
        # Semak untuk pastikan item wujud dalam database
        $sql = "SELECT iditem FROM item WHERE iditem = $id LIMIT 1";
        $result = mysqli_query($db, $sql) OR die("Ralat:<pre>$sql</pre>". mysqli_error($db));
        # Jika item ditemui dalam database
        if(mysqli_num_rows($result) > 0){
        # Semak pula pastikan item belum ada dalam session senarai banding
        if(!in_array($id, $compare)){
        # Masukkan iditem tersebut ke session senarai banding
        array_push($_SESSION['compare'], $id);
        echo "<script>
        alert('Item telah dimasukkan ke Senarai Banding.');
        history.go(-1);
        </script>";
        die();
        }
    }
    # Jika tindakan adalah 'remove'
    }elseif($action == 'remove'){
        #Cari id item dalam session senarai banding
        $key = array_search($id, $compare);
        # Jika jumpa
        if (($key) !== false) {
            #Buang id tersebut dari array
            unset($_SESSION['compare'][$key]);
            #Dan assign Scompare dengan nilai array terbaru
            $compare=$_SESSION['compare'];
            echo "<script>alert('Item telah keluarkan daripada Senarai Banding.');</script>";
        }
    }
}
?>
<h2>Senarai Banding</h2>
<?php
# Kira item dalam senarai banding. Jika tiada item paparkan mesej masih kosong
if(count($compare) == 0){
    echo "<h5>Senarai Banding masih kosong. <br> Pilih beberapa item dan masukkan ke Senarai Banding untuk buat perbandingan.</h5>";
}else{
    # Jika sudah ada item. Gabungkan semua iditem menjadi string (untuk kegunaan dalam sql query'in')
    $idlist = implode(',',$compare);
    $sql = "SELECT item.*, kategori.namakategori as kategori FROM item
    LEFT JOIN kategori on item.idkategori = kategori.idkategori WHERE iditem IN ($idlist)";
    
    $result = mysqli_query($db, $sql) OR die("Ralat:<pre>$sql</pre>". mysqli_error($db));
    if(mysqli_num_rows($result)>0){
        echo "<table width='100%' align='center' border='1' cellspacing='0' cellpadding='3'>
    <tr>
        <th width='200'>Item</th>
        <th>$label_b1</th><th>$label_b2</th><th>$label_b3</th>
        <th width='200'>Detail</th>
    </tr>";
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $id = $row['iditem'];
    $name = $row['namaitem']; $name_for_url = urlencode($name);
    $detail = $row['detail'];
    $kategori = $row['kategori'];
    $harga = $row['harga'];
    $banding1 = $row['banding1'];
    $banding2= $row['banding2'];
    $banding3= $row['banding3'];
    $gambar = $row['gambar'];
    if(!empty($gambar)){
        $img="<img src='gambar/item/$gambar' width='100'>";
    }else{
        $img = "Tiada.";
    }
    echo "<tr><td align='center'>
    $name<br>$img<br>RM $harga<br>
    <a class='button' href='papar_item.php?id=$id'>Lihat Detail</a><br><br>
    <a class='button' href='https://www.google.com/search?q=buy+$name_for_url'target='_blank'>Beli Online</a>
    <br><br>
    <a class='button' href='banding.php?id=$id&action=remove'>Buang Dari Senarai</a>
    </td>
    <td>$banding1</td><td>$banding2</td><td>$banding3</td>
    <td>$detail</td>
    </tr>";
    }
echo "</table>";
    }
}

# Panggil kandungan fail:
include('inc_footer.php');
?>