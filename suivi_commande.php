<?php
session_start();
include('db.php');

$id_commande = isset($_SESSION['last_order_id']) ? $_SESSION['last_order_id'] : null;
if (!$id_commande) {
    $res_last = mysqli_query($conn, "SELECT id FROM commandes ORDER BY id DESC LIMIT 1");
    $data_last = mysqli_fetch_assoc($res_last);
    $id_commande = $data_last['id'];
}

$res = mysqli_query($conn, "SELECT statut FROM commandes WHERE id = $id_commande");
$data = mysqli_fetch_assoc($res);
$status = $data['statut'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suivi - Teck Chic</title>
    <link rel="stylesheet" href="style2.css">
    <meta http-equiv="refresh" content="5">
    <style>
        /* Timeline simplifiée */
        .timeline { display: flex; justify-content: space-around; margin-top: 50px; }
        .step { text-align: center; opacity: 0.3; transition: 0.5s; }
        .step.active { opacity: 1; transform: scale(1.1); }
        .circle { 
            width: 70px; height: 70px; border-radius: 50%; background: #555; 
            display: flex; align-items: center; justify-content: center; font-size: 30px; margin: 0 auto 10px;
        }
        .active .circle { background: #ff6b35; box-shadow: 0 0 20px rgba(255,107,53,0.6); }
        .ready .circle { background: #2ecc71; box-shadow: 0 0 20px rgba(46,204,113,0.6); }
    </style>
</head>
<body>

<div class="tracking">
    <h2>Commande #<?php echo $id_commande; ?></h2>

    <div class="timeline">
        <div class="step <?php echo ($status != 'pret') ? 'active' : ''; ?>">
            <div class="circle">👨‍🍳</div>
            <p>En préparation...</p>
        </div>

        <div class="step <?php echo ($status == 'pret') ? 'active ready' : ''; ?>">
            <div class="circle">✅</div>
            <p>Votre plat est prêt !</p>
        </div>
    </div>

    <?php if($status == 'pret'): ?>
        <div style="margin-top:40px;">
            <p>Bon appétit ! Merci d'avoir choisi Tech Chic.</p>
            <button class="btn-eval enabled" onclick="window.location.href='evaluation.php'">Évaluer</button>
        </div>
    <?php endif; ?>
</div>

</body>
</html>