<?php
# Panggil kandungan fail:
include('inc_header.php');
?>
    <h2>Pengguna Bijak Faedahnya Banyak!</h2>
    <p>Anda boleh membandingkan telefon pintar di portal ini sebelum membeli.</p>
    <hr>
    <h2>Item Terkini di Portal Ini &#10024</h2>
    <p>Lihat semua item <a href='senarai_item.php'>di sini.</a></p>
    
</div>

    <?php
    # Dapatkan item terkini untuk dipaparkan
    $sql="SELECT item.*,kategori.namakategori as kategori FROM item 
    LEFT JOIN kategori on item.idkategori=kategori.idkategori
    ORDER BY iditem DESC LIMIT 4";

    $result=mysqli_query($db,$sql)OR die("Ralat:<pre>$sql</pre>".mysqli_error($db));

    if(mysqli_num_rows($result)>0){
        ?> <div class='grid'> <?php

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
            
            echo "<div class='phone-container'><b>$kategori</b><br><strong>$name</strong><pre>$img</pre>
            <a class='button' href='papar_item.php?id=$iditem'>Detail</a></div>";
        }
        ?> </div><br> <?php
    }else{
        echo"Item belum dimasukkan.";
    }
    ?>

    <?php
    
    # Panggil kandungan fail:
    include('inc_footer.php');
    ?>