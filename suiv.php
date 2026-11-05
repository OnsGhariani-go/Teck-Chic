<?php
session_start();
include('db.php');

// On vérifie si le panier n'est pas vide
if (!empty($_SESSION['panier']) && isset($_POST['total'])) {
    
    $total_final = $_POST['total'];
    $type_service = $_SESSION['service'];
    $num_table = isset($_SESSION['table']) ? $_SESSION['table'] : NULL;
    
    // 1. Préparation de la chaîne "details" (ex: "1x pizza, 2x spagetti")
    $details_array = array();
    
    foreach ($_SESSION['panier'] as $id => $quantite) {
        // On récupère le nom du plat pour l'historique
        $res = mysqli_query($conn, "SELECT nom FROM bd_menu WHERE id=$id");
        $plat = mysqli_fetch_assoc($res);
        $nom_plat = $plat['nom'];
        
        $details_array[] = $quantite . "x " . $nom_plat;
    }
    
    // On transforme le tableau en une seule phrase séparée par des virgules
    $details_string = implode(', ', $details_array);
    $statut = 'en attente';

    // 2. Insertion dans la table 'commandes' (selon ta structure d'image)
    // Note: Utilisation de mysqli_real_escape_string pour la sécurité sur EasyPHP
    $details_sql = mysqli_real_escape_string($conn, $details_string);
    
    $sql = "INSERT INTO commandes (details, prix_total, type_service, num_table, statut) 
            VALUES ('$details_sql', '$total_final', '$type_service', '$num_table', '$statut')";

    if (mysqli_query($conn, $sql)) {
        // 3. Succès : On vide le panier
        unset($_SESSION['panier']);
        
        // On peut rediriger vers une page de succès ou réafficher le dashboard
        echo "<script>
                alert('Commande validée avec succès !');
                window.location.href='menu_client.php';
              </script>";
    } else {
        echo "Erreur lors de la commande : " . mysqli_error($conn);
    }

} else {
    // Si on arrive ici sans données, on repart au menu
    header("Location: menu_client.php");
    exit();
}
?>