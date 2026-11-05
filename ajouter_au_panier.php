<?php
session_start();
if(isset($_POST['id']) && isset($_POST['qty'])) {
    $id = $_POST['id'];
    $qty = intval($_POST['qty']);

    if(!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
    }

    // On incrémente si déjà présent, sinon on crée
    if(isset($_SESSION['panier'][$id])) {
        $_SESSION['panier'][$id] += $qty;
    } else {
        $_SESSION['panier'][$id] = $qty;
    }
}
header('Location: menu_client.php');
exit();
?>