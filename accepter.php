<?php
include "db.php";

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupération des données de la demande
    $res = $conn->query("SELECT * FROM demandes WHERE id=$id");
    $data = $res->fetch_assoc();

    if($data) {
        $user = $data['username'];
        $pass = $data['password']; // Mot de passe saisi manuellement (déjà haché ou prêt à l'être)
        $role = $data['role'];

        // Insertion dans la table users
        $conn->query("INSERT INTO users(username, password, role) VALUES('$user', '$pass', '$role')");

        // Mise à jour du statut
        $conn->query("UPDATE demandes SET statut='accepte' WHERE id=$id");
        
        // Redirection avec message de succès
        header("Location: gestion_demandes.php?status=accepted");
        exit();
    }
}
header("Location: gestion_demandes.php");
?>