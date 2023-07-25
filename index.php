<?php
# Panggil kandungan fail:
include('inc_header.php');
?>

<h2>Pengguna Bijak Faedahnya Banyak!</h2>
<p>Bandingkan telefon pintar di portal ini sebelum anda membeli.</p>
<hr>
<h2>Item Terkini di Portal Ini</h2>
<p>Lihat semua item <a href='senarai_item.php'>di sini.</a></p>
<hr>

    <?php
    # Dapatkan item terkini untuk dipaparkan
    $sql="SELECT item.*,kategori.namakategori as kategori FROM item 
    LEFT JOIN kategori on item.idkategori=kategori.idkategori ORDER BY iditem DESC LIMIT 6";

    $result=mysqli_query($db,$sql)OR die("Ralat:<pre>$sql</pre>".mysqli_error($db));

    if(mysqli_num_rows($result)>0){

        echo"<table class='column' width='fit' border='1' cellspacing='0' cellpadding='20'>";

        while($row=mysqli_fetch_array($result)){
            $iditem=$row['iditem'];
            $name=$row['namaitem'];
            $kategori=$row['kategori'];
            $gambar=$row['gambar'];

            if(!empty($gambar)){
                $img="<img src='gambar/item/$gambar' width='160' height='200'>";
            }else{
                $img="";
            }
            
            echo "<td align='center'>
            <strong>$kategori $name</strong><br><br>$img<br><br><a class='button' href='papar_item.php?id=$iditem'>Lihat</a>
            </td>";
        }

        echo "</table>";
    }else{
        echo"Item belum dimasukkan.";
    }
    ?>

    <?php
    
    # Panggil kandungan fail:
    include('inc_footer.php');
    ?>