<?php
include('db.php');

if (isset($_GET['encaisser'])) {
    $id_cmd = intval($_GET['encaisser']);
    
    // 1. Récupérer le numéro de table associé à cette commande avant de l'archiver
    $res_cmd = mysqli_query($conn, "SELECT num_table, type_service FROM commandes WHERE id = $id_cmd");
    $data_cmd = mysqli_fetch_assoc($res_cmd);
    $num_table = $data_cmd['num_table'];

    // 2. Mettre à jour le statut de la commande
    $sql_pay = "UPDATE commandes SET statut = 'payee' WHERE id = $id_cmd";
    
    if (mysqli_query($conn, $sql_pay)) {
        // 3. SI c'était "sur place", on libère la table dans la base de données
        if ($data_cmd['type_service'] == 'sur place' && $num_table > 0) {
            mysqli_query($conn, "UPDATE tables_restaurant SET statut = 'libre' WHERE id = $num_table");
        }
        
        header("Location: caissier.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Interface Caissier - Teck&Chic</title>
    <meta http-equiv="refresh" content="10"> <style>
        :root {
            --bleu-nuit: #0e2b5e;
            --orange-chic: #ff6b35;
            --vert-argent: #0c9545f0;
            --blanc: #ffffff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 40px;
            min-height: 100vh;
            background: linear-gradient(rgba(0, 0, 0,0.95), rgba(0, 0, 0, 0.32)), 
                        url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            color: var(--blanc);
        }

        h1 {
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: var(--orange-chic);
            margin-bottom: 50px;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            justify-content: center;
        }

        .card-caissier {
            background: rgba(255, 255, 255, 0.15); /* Légèrement plus opaque pour la lisibilité */
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            width: 320px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            transition: 0.3s;
            color: white;
        }

        .card-caissier:hover {
            transform: translateY(-5px);
            border-color: var(--vert-argent);
        }

        .header-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 15px;
            font-weight: bold;
        }

        .info-service {
            color: var(--orange-chic);
            font-size: 0.9em;
            text-transform: uppercase;
        }

        .montant-container {
            margin: 30px 0;
        }

        .label-total {
            font-size: 0.8em;
            text-transform: uppercase;
            opacity: 0.7;
            display: block;
            margin-bottom: 5px;
        }

        .prix-valeur {
            font-size: 2.5em;
            font-weight: 800;
        }

        .devise {
            font-size: 0.4em;
            color: var(--orange-chic);
            margin-left: 5px;
        }

        .btn-encaisser {
            background: var(--vert-argent);
            color: white;
            border: none;
            width: 100%;
            padding: 15px;
            border-radius: 50px;
            font-weight: bold;
            font-size: 1em;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(5, 90, 40, 0.9);
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-encaisser:hover {
            background: #0ea850;
            box-shadow: 0 6px 20px rgba(5, 90, 40, 0.9);
            letter-spacing: 1px;
        }

        .details-small {
            margin-top: 15px;
            font-size: 0.8em;
            color: #ddd;
        }
    </style>
</head>
<body>

    <h1>Espace Encaissement</h1>

    <div class="container">
        <?php
        // On récupère les commandes qui ne sont pas encore payées
        $sql = "SELECT * FROM commandes WHERE statut != 'payee' ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $type = $row['type_service'];
                $table = ($type == 'sur place') ? "TABLE " . $row['num_table'] : "EMPORTÉ";
                $color_status = ($row['statut'] == 'pret') ? 'style="color:#2ecc71; font-weight:bold;"' : '';
        ?>
            <div class="card-caissier">
                <div class="header-card">
                    <span class="info-service"><?php echo $table; ?></span>
                    <span>#<?php echo $row['id']; ?></span>
                </div>
                
                <div class="montant-container">
                    <span class="label-total">Total à payer</span>
                    <span class="prix-valeur"><?php echo number_format($row['prix_total'], 3, '.', ''); ?><span class="devise">TND</span></span>
                </div>

                <a href="caissier.php?encaisser=<?php echo $row['id']; ?>" class="btn-encaisser" onclick="return confirm('Confirmer le paiement de la commande #<?php echo $row['id']; ?> ?')">
                    Valider le paiement
                </a>
                
                <div class="details-small">
                    Statut : <span <?php echo $color_status; ?>><?php echo ($row['statut'] == 'pret') ? 'Prêt en cuisine' : 'En préparation'; ?></span>
                </div>
            </div>
        <?php 
            } 
        } else {
            echo "<p style='text-align:center;'>Aucune commande en attente d'encaissement.</p>";
        }
        ?>
    </div>

</body>
</html>