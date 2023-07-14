<?php
# Panggil kandungan fail:
include('inc_header.php');
?>

<h2>Pengguna Bijak Faedahnya Banyak!</h2>
Bandingkan telefon pintar di portal ini sebelum anda membeli.
<hr>
<h2>Item Terkini di Portal Ini</h2>
<div class='row'>
    <?php
    # Dapatkan item terkini untuk dipaparkan
    $sql="SELECT item.*,kategori.namakategori as kategori FROM item 
    LEFT JOIN kategori on item.idkategori=kategori.idkategori ORDER BY iditem DESC LIMIT 6";

    $result=mysqli_query($db,$sql)OR die("Ralat:<pre>$sql</pre>".mysqli_error($db));

    if(mysqli_num_rows($result)>0){

        echo"<table class='column' width=30%' border='1' cellspacing='0' cellpadding='4'>";

        while($row=mysqli_fetch_array($result)){
            $iditem=$row['iditem'];
            $name=$row['namaitem'];
            $kategori=$row['kategori'];
            $gambar=$row['gambar'];

            if(!empty($gambar)){
                $img="<img src='gambar/item/$gambar' width='100'>";
            }else{
                $img="";
            }
            
            echo "<tr><td align='center'>
            <strong>$name</strong><br>$img<br><a class='button' href='papar_item.php?id=$iditem'>Lihat</a>
            </td></tr>";
        }

        echo "</table>";
    }else{
        echo"Item belum dimasukkan.";
    }
    ?>
    </div>
    <hr>
    Lihat semua item <a href='senarai_item.php'>di sini.</a>
    <?php
    
    # Panggil kandungan fail:
    include('inc_footer.php');
    ?>