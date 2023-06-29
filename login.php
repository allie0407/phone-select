<?php
#Panggil kandungan fail:
include('inc_header.php');

if(isset($_POST['username'])&& isset($_POST['password'])){
    $username=trim(strtolower($_POST['username']));
    $password=trim($_POST['password']);

    $sql="SELECT*FROM pengguna WHERE username='$username' AND password='$password' LIMIT 1";
    $result=mysqli_query($db,$sql)OR die("Ralat:<pre>$sql</pre>".mysqli_error($db));
    if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

            $_SESSION['idpengguna']=$row['idpengguna'];
            $_SESSION['namapengguna']=$row['namapengguna'];
            if($row['level']=='admin'){
                $_SESSION['level']='admin';
            }else{
                $_SESSION['level']='user';
            }
            echo"<script>alert('Log masuk berjaya.');
            window.location.replace('index.php');
            </script>";
            die();
        }
    }else{
        echo"<script>alert('Log masuk tidak berjaya. Kesalahan username/katalaluan.');</script>";
    }
}
?>
<table width='400' height='100%' align='center'>
    <tr><td align='center'>
        <h2>Log Masuk</h2>
        <p>Jika anda belum mempunyai akaun, klik <a href='daftar.php'>Daftar</a>.</p>
        <form method="POST" action=''>
            <label>Username</label><br>
            <input type="text" name="username" required><br><br>
            <label>Password</label><br>
            <input type="password" name="password" required><br><br>
            <input type="submit" name="" value="Log Masuk">
</form>
</td><tr>
</table>
<?php

# Panggil kandungan fail:
include('inc_footer.php');
?>