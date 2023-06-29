<?php
include('inc_header.php');
checklogin('user'); # Boleh diakses oleh user yang log masuk sahaja

# Dapatkan id user daripada session
$idpengguna = $_SESSION['idpengguna'];
# Semak jika ada parameter 'action' dan 'id' di URL
if(isset($_GET['id']) && is_numeric($_GET['id']) && isset($_GET['action'])){

    $iditem = $_GET['id'];
    $action = $_GET['action']; # Dapatkan tindakan yang diklik pengguna
    #Jika tindakan adalah 'add'
    if($action == 'add'){
        #Semak jika item sudah ada dalam senarai minat
        $sql = "SELECT FROM minat WHERE idpengguna = $idpengguna AND iditem = $iditem LIMIT 1";
        $result = mysqli_query($db, $sql) OR die("Ralat:<pre>$sql</pre>".mysqli_error($db));

        # Jika item ditemui dalam database
        if(mysqli_num_rows($result)==0){
            # Masukkan iditem tersebut ke database table minat senarai minat
            $sql = "INSERT INTO minat (idpengguna, iditem) VALUES ('$idpengguna', '$iditem')";
            $result = mysqli_query($db, $sql) OR die("Ralat:<pre>$sql</pre>".mysqli_error($db));
            echo "<script>
            alert('Item telah dimasukkan ke Senarai Minat.');
            history.go(-1);
            </script>";
            die();
        }else{
            echo "<script>
            alert('Item telah ada dalam Senarai Minat anda.');
            history.go(-1);
            </script>";
            die();
        }
        # Jika tindakan adalah 'remove
    }elseif($action == 'remove'){
        # Buang item daripada senarai minat
        $sql = "DELETE FROM minat WHERE idpengguna = $idpengguna AND iditem=$iditem";
        $result = mysqli_query($db, $sql) OR die("Ralat:<pre>$sql</pre>".mysqli_error($db));
        echo "<script>
        alert('Item telah dikeluarkan daripada Senarai Minat.');
        window.location.replace('minat.php');
        </script>";
        die();
    }
}
?>
<h2>Senarai Minat</h2>
<p>Simpan item yang anda minat di sini untuk mudah rujuk dan beli di masa hadapan.<br>
Senarai Minat akan kekal di dalam akaun anda walaupun sudah Log Keluar daripada portal ini.</p>
<?php

# Dapatkan semua rekod minat, data item dan kategori yang berkaitan
$sql = "SELECT item.*, kategori.namakategori as kategori FROM item
LEFT JOIN kategori on item.idkategori=kategori.idkategori INNER JOIN minat on minat.iditem = item.iditem
WHERE idpengguna = $idpengguna";
$result = mysqli_query($db, $sql) OR die("Ralat:<pre>$sql</pre>".mysqli_error($db));

if(mysqli_num_rows($result)>0){
    echo "<table width='100%' align='center' border='1' cellspacing='0' cellpadding='3' >
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
    $banding2 = $row['banding2'];
    $banding3 = $row['banding3'];
    $gambar = $row['gambar'];

    if(!empty($gambar)){
        $img="<img src='gambar/item/$gambar' width='100'>";
    }else{
        $img = "Tiada.";
    }
    echo "<tr>
    <td align='center'>
    $name<br>$img<br>RM $harga<br>
    <a class='button' href='papar_item.php?id=$id'>Lihat Detail</a><br><br>
    <a class='button' href='https://www.google.com/search?q=buy+$name_for_url' target='_blank'>Beli Online</a><br><br>
    <a class='button' href='minat.php?id=$id&action=remove'>Buang Dari Senarai</a>
    </td>
    <td>$banding1</td><td>$banding2</td><td>$banding3</td>
    <td>$detail</td>
    </tr>";
}
    echo "</table>";
}else{
    echo "<h5>Senarai Minat masih kosong. <br>Pilih beberapa item dan masukkan ke Senarai Banding untuk buat perbandingan.</h5>";
}

# Panggil kandungan fail:
include('inc_footer.php');
?>