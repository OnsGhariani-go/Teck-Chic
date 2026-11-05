<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Chic - Teck&Chic</title>
    <style>
        :root {
            --orange-chic: #ff6b35;
            --blanc-pur: #ffffff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 40px;
            min-height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)), 
                        url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            color: var(--blanc-pur);
        }

        h1 {
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 4px;
            color: var(--orange-chic);
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            margin-bottom: 50px;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
        }

        .capsule {
            background: rgba(255, 255, 255, 0.2); 
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-top: 1px solid rgba(255, 107, 53, 0.5);
            border-radius: 35px;
            width: 350px;
            padding: 25px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.6);
            transition: all 0.3s ease;
        }

        .header-capsule {
            display: flex;
            justify-content: space-between;
            border-bottom: 2px solid var(--orange-chic);
            padding-bottom: 15px;
            font-weight: bold;
            font-size: 1.1em;
        }

        .plats-area {
            margin: 25px 0;
        }

        .plat-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255, 255, 255, 0.05);
            margin-bottom: 12px;
            padding: 12px 18px;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .quantite-badge {
            background-color: var(--orange-chic);
            padding: 3px 12px;
            border-radius: 12px;
            font-weight: bold;
        }

        .footer-btns {
            display: flex;
            justify-content: space-between;
            gap: 12px;
        }

        .btn-chef {
            flex: 1;
            background: rgba(255, 255, 255, 0.1);
            border: 1.5px solid var(--blanc-pur);
            color: var(--blanc-pur);
            border-radius: 50px;
            padding: 10px 5px;
            font-size: 0.85em;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
        }

        .btn-active {
            background: var(--orange-chic);
            border-color: var(--orange-chic);
        }
    </style>
</head>
<body>

    <?php
include('db.php');
?>
<!DOCTYPE html>
<html lang="fr">
<body>
    <h1>Dashboard Cuisine</h1>
    <div class="container">
        <?php
        // On affiche tout ce qui n'est pas encore 'prêt'
        $sql_cmd = "SELECT * FROM commandes WHERE statut = 'en attente' ORDER BY id DESC";
        $res_cmd = mysqli_query($conn, $sql_cmd);

        if ($res_cmd && mysqli_num_rows($res_cmd) > 0) {
            while ($commande = mysqli_fetch_assoc($res_cmd)) {
                $id_cmd = $commande['id'];
                $table = $commande['num_table'];
                $type = $commande['type_service'];
                
                // Logique d'affichage : Si c'est sur place, on montre la table
                $display_mode = ($type == 'sur place') ? "Table " . $table : "À emporter";
        ?>
            <div class="capsule">
                <div class="header-capsule">
                    <span><?php echo $display_mode; ?></span>
                    <span>N° #<?php echo $id_cmd; ?></span>
                </div>
                <div class="plats-area">
                    <?php
                    $details_bruts = explode(',', $commande['details']);
                    foreach ($details_bruts as $item) {
                        $item_clean = trim($item);
                        if ($item_clean != "") {
                            $parts = explode('x', $item_clean);
                            $qte = isset($parts[0]) ? trim($parts[0]) : '1';
                            $nom = isset($parts[1]) ? trim($parts[1]) : $item_clean;
                    ?>
                        <div class="plat-row">
                            <span><?php echo $nom; ?></span>
                            <span class="quantite-badge"><?php echo $qte; ?></span>
                        </div>
                    <?php } } ?>
                </div>
                <div class="footer-btns">
                    <a href="update_statut.php?id=<?php echo $commande['id']; ?>" 
                        onclick="return confirm('Prêt pour la commande #<?php echo $commande['id']; ?> ?')" 
                        class="btn-chef">
                        MARQUER COMME PRÊT
                        </a>
                </div>
            </div>
        <?php 
            }
        } else {
            echo "<p style='text-align:center;'>Aucune commande en cuisine pour le moment.</p>";
        }
        ?>
    </div>
</body>
</html>
