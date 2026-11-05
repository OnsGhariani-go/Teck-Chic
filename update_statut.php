<?php
include('db.php'); // Vérifiez que ce fichier contient bien la connexion $conn

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // On force le statut à 'prêt' (vérifiez bien l'orthographe avec l'accent en base)
    $sql = "UPDATE commandes SET statut = 'pret' WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        // Succès : on retourne au dashboard
        header("Location: demande_cmd.php");
        exit();
    } else {
        // Si ça échoue, ce message s'affichera
        echo "Erreur MySQL : " . mysqli_error($conn);
    }
} else {
    echo "ID manquant dans l'URL";
}
?>