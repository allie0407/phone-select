<?php
#Panggil kandungan fail:
include('inc_header.php');
#Pembolehubah untuk menyimpan input pengguna
$name='';
$username = '';
$password='';

#String untuk simpan semua senarai ralat. Nilai awal ialah empty $error = '';
$error='';

if(isset($_POST['signup'])){


    $raw_username= trim($_POST['username']);
    $username= preg_replace("/[^a-zA-Z0-9]+/", "", strtolower($raw_username));
    $password=trim($_POST['password']);
    $name = trim($_POST['name']);

    #Semak supaya semua maklumat sudah diisi (tidak empty) 
    if(empty($name)||empty($username)||empty($password)){ 
        $error.= "Sila isi semua ruang di borang pendaftaran.";
    }

    #Dapatkan bilangan aksara username
    $username_lenght= strlen($username);

    #Had atas untuk panjang username
    if($username_lenght>15){
        $error.="Username terlalu panjang. Maksima 15 aksara.";
    }
    #Had bawah untuk panjang username 
    if($username_lenght<4){
        $error.= "Username terlalu pendek. Minima 4 aksara.";
    }
    #Had bawah untuk password
    $password_lenght = strlen($password);
    if($password_lenght<6){
        $error.="Katalaluan terlalu pendek. Password mesti 6 aksara.";
    }
    #Had atas untuk password
    if($password_lenght>6){
        $error.="Katalaluan terlalu panjang. Password mesti 6 aksara.";
    }

    #Semak jika username sudah wujud dalam database
    $sql = "SELECT * FROM pengguna WHERE username='$username' LIMIT 1";
    $result = mysqli_query($db, $sql) OR die("Ralat <pre>$sql</pre>". mysqli_error($db));

    if(mysqli_num_rows($result) > 0){
        $error.="Username ($username) sudah digunakan, sila pilih username berbeza.";
    }

    #Jika tiada error, teruskan pendaftaran
    if(empty($error)){
        $sql = "INSERT INTO pengguna (namapengguna, username, password, level)
        VALUES ('$name', '$username', '$password', 'user')";
        $result = mysqli_query($db, $sql) OR die("Ralat:<pre>$sql</pre>".mysqli_error($db));
        
        echo "<script>
        alert('Pendaftaran berjaya. Sila Log Masuk menggunakan ID Login ($username).');
        window.location.replace('login.php');
    </script>"; 
    die();
    }else{
    echo "<script>alert('$error');</script>";
    }
}
?>

<table width='500' height='100%' align='center'>
    <tr>
    <td align='center'>
    <h2>Daftar Akaun</h2>
    <p>Jika anda sudah mempunyai akaun, klik <a href='login.php'>Log Masuk</a></p>
    <form method='POST' action=''>
    <label>Nama</label><br>
    <input type="text" name="name" value='<?php echo $name; ?>' required autocomplete="off"><br><br> <label>Username</label><br>
    <input type="text" name="username" value='<?php echo $username; ?>' required autocomplete="off"><br><br>
    <label>Password</label><br> <input type="password" name="password" value='<?php echo $password; ?>' required autocomplete="off"> <br><br>
    <input type="submit" name='signup' value="Daftar">
    </form>
    </td>
    </tr>
</table>

<?php

#Panggil kandungan fail
include('inc_footer.php');
?>