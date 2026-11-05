<?php
include "db.php";

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM demandes WHERE id=$id");
    header("Location: gestion_demandes.php?status=refused");
    exit();
}
header("Location: gestion_demandes.php");
?>