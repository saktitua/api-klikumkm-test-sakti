<?php 
$servername ="localhost";
$database   ="klik-umkm-test";
$username   ="root";
$password   ="";

$conn = mysqli_connect($servername, $username, $password, $database);

if(!$conn){
    die("connection failed ".mysqli_connect_error());
}
echo "Connected";
?>


