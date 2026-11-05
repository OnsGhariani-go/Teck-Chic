<?php
include "db.php";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    // On stocke le mot de passe (vous pouvez choisir de le hacher ici ou lors de l'acceptation)
    $password = md5($_POST['password']); 
    $role = $_POST['role'];

    $sql = "INSERT INTO demandes(username,password,role,statut) VALUES('$username','$password','$role','en_attente')";
    if($conn->query($sql)) {
        $success = "Demande envoyée avec succès ! ✔️";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="sty.css">
</head>
<body>
<div class="container">
    <h1>Inscription</h1>

    <!-- Affichage du message de succès -->
    <?php if($success): ?>
        <div class="alert success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form action="inscription.php" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <select name="role">
            <option value="chef">Chef</option>
            <option value="caissier">Caissier</option>
        </select>
        <button>S'inscrire</button>
    </form>
    <a href="login.php">← Retour à la connexion</a>
</div>
</body>
</html>