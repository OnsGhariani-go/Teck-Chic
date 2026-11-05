<?php
include('db.php');

// Création du dossier uploads s'il n'existe pas
if (!file_exists("uploads")) { mkdir("uploads", 0777, true); }

// 1. AJOUTER
// 1. AJOUTER
if (isset($_POST['ajouter'])) {

    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prix = floatval($_POST['prix']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);

    $filename = $_FILES['image']['name'];

    // nettoyage nom image
    $filename = str_replace(' ', '_', $filename);
    $filename = preg_replace('/[^A-Za-z0-9.\-_]/', '', $filename);

    $img = time() . "_" . $filename;

    if (move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $img)) {

        $sql = "INSERT INTO bd_menu (nom, description, prix, image_path, disponibilite) 
                VALUES ('$nom', '$desc', '$prix', '$img', 1)";

        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die("Erreur SQL: " . mysqli_error($conn));
        }

    } else {
        die("Erreur upload image");
    }

    header("Location: menudy.php");
    exit();
}

// 2. TOGGLE
if (isset($_GET['toggle'])) {
    $id = $_GET['toggle'];
    $new_status = $_GET['status'] == 1 ? 0 : 1;

    mysqli_query($conn, "UPDATE bd_menu SET disponibilite=$new_status WHERE id=$id");

    header("Location: menudy.php");
    exit();
}

// 3. DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    mysqli_query($conn, "DELETE FROM bd_menu WHERE id=$id");

    header("Location: menudy.php");
    exit();
}

// 4. MODIFIER
if (isset($_POST['modifier'])) {
    $id = $_POST['id'];
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prix = $_POST['prix'];
    $desc = mysqli_real_escape_string($conn, $_POST['description']);

    if (!empty($_FILES['image']['name'])) {
        $img = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $img);
        $sql = "UPDATE bd_menu SET nom='$nom', prix='$prix', description='$desc', image_path='$img' WHERE id=$id";
    } else {
        $sql = "UPDATE bd_menu SET nom='$nom', prix='$prix', description='$desc' WHERE id=$id";
    }
    header("Location: menudy.php");
    exit();
    mysqli_query($conn, $sql);
}
?>