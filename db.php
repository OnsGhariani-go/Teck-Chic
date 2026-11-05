<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "tech";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connexion échouée : " . mysqli_connect_error());
}
?>


