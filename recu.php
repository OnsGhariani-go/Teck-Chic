<?php
session_start();
include('db.php');

// 1. DÉTERMINER LE SERVICE ET LA TABLE
$type_service = isset($_SESSION['service']) ? $_SESSION['service'] : "emporte";

if ($type_service == 'emporte') {
    $num_table = 0;
} else {
    $num_table = isset($_SESSION['table_id']) ? $_SESSION['table_id'] : 0;
}

// 2. GESTION DES ACTIONS (Plus / Moins)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id_plat = $_GET['id'];
    if ($_GET['action'] == 'plus') {
        $_SESSION['panier'][$id_plat]++;
    } elseif ($_GET['action'] == 'minus') {
        if ($_SESSION['panier'][$id_plat] > 1) {
            $_SESSION['panier'][$id_plat]--;
        } else {
            unset($_SESSION['panier'][$id_plat]);
        }
    }
    header("Location: recu.php");
    exit();
}

// 3. VALIDATION ET INSERTION DANS LA BDD
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['valider_id'])) {
    
    if(!empty($_SESSION['panier'])) {
        $total_general = $_POST['total_cache'];
        
        // Préparation de la liste des plats
        $details_tab = array();
        foreach($_SESSION['panier'] as $id => $quantite) {
            $res_plat = mysqli_query($conn, "SELECT nom FROM bd_menu WHERE id=$id");
            $plat = mysqli_fetch_assoc($res_plat);
            $details_tab[] = $quantite . "x " . $plat['nom'];
        }
        $details_final = mysqli_real_escape_string($conn, implode(', ', $details_tab));

        // Insertion
        $sql_insert = "INSERT INTO commandes (details, prix_total, type_service, num_table, statut) 
                       VALUES ('$details_final', '$total_general', '$type_service', '$num_table', 'en attente')";
        
        if (mysqli_query($conn, $sql_insert)) {
            $_SESSION['last_order_id'] = mysqli_insert_id($conn);
            
            // --- ACTION DEMANDÉE : VIDER LE PANIER ICI ---
            $_SESSION['panier'] = array(); // Vide le panier
            unset($_SESSION['table_id']);  // Optionnel : libère la table
            
            // Redirection immédiate
            header("Location: suivi_commande.php");
            exit();
        } else {
            echo "Erreur BDD : " . mysqli_error($conn);
        }
    }
}

$total_general = 0; 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Panier - Teck Chic</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #df5826; --dark: #2c3e50; --white: #ffffff; }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-attachment: fixed;
        }

        .glass-container { 
            max-width: 700px; 
            width: 95%; 
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 30px; 
            border-radius: 25px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
            color: white;
        }

        .header-recu { text-align: center; margin-bottom: 25px; }
        .header-recu h1 { font-weight: 700; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px; }

        .status-badge { 
            display: inline-block; 
            padding: 6px 15px; 
            background: rgba(255,255,255,0.2); 
            border-radius: 50px; 
            font-size: 0.85rem; 
            margin: 5px;
            border: 1px solid rgba(255,255,255,0.3);
        }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.2); font-weight: 600; }
        td { padding: 15px 12px; border-bottom: 1px solid rgba(255,255,255,0.1); }

        .qty-control { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            background: rgba(255,255,255,0.1); 
            padding: 4px 10px; 
            border-radius: 50px; 
            width: fit-content; 
        }

        .btn-qty { 
            color: white; 
            text-decoration: none; 
            font-size: 0.8rem;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--primary);
            transition: 0.2s;
        }
        
        .btn-qty:hover { transform: scale(1.1); }

        .total-section { 
            background: rgba(223, 88, 38, 0.2); 
            padding: 20px; 
            border-radius: 15px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-top: 25px;
            border: 1px solid var(--primary);
        }

        .total-price { font-size: 1.6rem; font-weight: 700; color: var(--primary); }

        .footer-btns { display: flex; gap: 15px; margin-top: 30px; }
        .btn { 
            flex: 1; padding: 14px; border-radius: 12px; text-align: center; 
            font-weight: 600; text-decoration: none; transition: 0.3s; 
            border: none; cursor: pointer; font-size: 1rem; 
        }

        .btn-back { background: rgba(255,255,255,0.1); color: white; border: 1px solid white; }
        .btn-back:hover { background: white; color: var(--dark); }
        
        .btn-confirm { background: var(--primary); color: white; box-shadow: 0 10px 20px rgba(223, 88, 38, 0.3); }
        .btn-confirm:hover { background: #ff6b35; transform: translateY(-2px); }
    </style>
</head>
<body>

<div class="glass-container">
    <div class="header-recu">
        <h1>Mon Panier</h1>
        <div class="status-badge"><i class="fas fa-utensils"></i> <?php echo ($type_service == 'surplace') ? "Sur Place" : "À Emporter"; ?></div>
        <?php if($type_service == 'surplace'): ?>
            <div class="status-badge"><i class="fas fa-chair"></i> Table <?php echo $num_table; ?></div>
        <?php endif; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th style="text-align: center;">Quantité</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(!empty($_SESSION['panier'])) {
                foreach($_SESSION['panier'] as $id => $quantite) {
                    $res = mysqli_query($conn, "SELECT * FROM bd_menu WHERE id=$id");
                    $plat = mysqli_fetch_assoc($res);
                    $sous_total = $plat['prix'] * $quantite;
                    $total_general += $sous_total;
                    ?>
                    <tr>
                        <td><strong><?php echo $plat['nom']; ?></strong></td>
                        <td align="center">
                            <div class="qty-control">
                                <a href="recu.php?action=minus&id=<?php echo $id; ?>" class="btn-qty"><i class="fas fa-minus"></i></a>
                                <span><?php echo $quantite; ?></span>
                                <a href="recu.php?action=plus&id=<?php echo $id; ?>" class="btn-qty"><i class="fas fa-plus"></i></a>
                            </div>
                        </td>
                        <td align="right"><?php echo number_format($sous_total, 2); ?> DT</td>
                    </tr>
                <?php }
            } else {
                echo "<tr><td colspan='3' align='center' style='padding:40px;'>Votre panier est vide.</td></tr>";
            } ?>
        </tbody>
    </table>

    <?php if($total_general > 0): ?>
    <div class="total-section">
        <span style="letter-spacing: 1px;">TOTAL À PAYER</span>
        <span class="total-price"><?php echo number_format($total_general, 2); ?> DT</span>
    </div>
    <?php endif; ?>

    <div class="footer-btns">
        <a href="menu_client.php" class="btn btn-back">Continuer vos achats</a>
        <?php if($total_general > 0): ?>
            <form action="recu.php" method="POST" style="flex: 1;">
                <input type="hidden" name="total_cache" value="<?php echo $total_general; ?>">
                <button type="submit" name="valider_id" class="btn btn-confirm">Valider la commande</button>
            </form>
        <?php endif; ?>
    </div>
</div>

</body>
</html>