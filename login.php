<?php
session_start();
include "db.php";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    $res = $conn->query("SELECT * FROM users WHERE username='$username'");
    $user = $res->fetch_assoc();

    if($user && md5($password) == $user['password']){
        $_SESSION['role'] = $user['role'];
        if($user['role'] == "chef") header("Location: chef.php");
        if($user['role'] == "caissier") header("Location: caissier.php");
        if($user['role'] == "admin") header("Location: admin.php");
        exit();
    } else {
        $error = "compte introuvable ! ";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="sty.css">
</head>
<body>
<div class="container">
    <h1>Login</h1>
    
    <!-- Affichage du message d'erreur -->
    <?php if($error): ?>
        <div class="alert danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="login.php" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button>Se connecter</button>
    </form>
    <a href="inscription.php">← Inscription</a>
</div>
</body>
</html>