<?php
session_start();
include('db.php'); 

// 1. Gérer la sélection d'une table
if (isset($_GET['table_id'])) {
    $table_id = intval($_GET['table_id']);
    mysqli_query($conn, "UPDATE tables_restaurant SET statut = 'occupe' WHERE id = $table_id");
    
    $_SESSION['table_id'] = $table_id;
    $_SESSION['service'] = 'surplace'; // Changé de 'sur place' à 'surplace'
    header("Location: menu_client.php");
    exit();
}

// 2. Récupérer l'état de toutes les tables
$result = mysqli_query($conn, "SELECT * FROM tables_restaurant");
$tables = array();
$toutes_occupees = true;

while ($row = mysqli_fetch_assoc($result)) {
    $tables[$row['id']] = $row['statut'];
    if ($row['statut'] == 'libre') {
        $toutes_occupees = false;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Plan de Salle - Teck&Chic</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --orange-chic: #ff6b35;
            --vert-libre: #27ae60;
            --rouge-occupe: #ce3d2d;
            --blanc: #ffffff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)), 
                        url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: var(--blanc);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.02); 
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 40px;
            padding: 40px;
            width: 90%;
            max-width: 450px;
            text-align: center;
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.6);
        }

        h1 {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 5px;
            text-transform: uppercase;
            color: var(--orange-chic);
        }

        .subtitle {
            font-size: 0.9rem;
            opacity: 0.7;
            margin-bottom: 35px;
        }

        /* Grille des tables */
        .grid-tables {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 25px;
            margin-bottom: 30px;
        }

        .table-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 80px;
            text-decoration: none;
            color: white;
            transition: transform 0.3s ease;
        }

        .circle {
            width: 75px;
            height: 75px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 800;
            font-size: 1.4rem;
            box-shadow: 0 8px 20px rgba(0,0,0,0.4);
            border: 2px solid rgba(255,255,255,0.1);
        }

        .libre { 
            background: var(--vert-libre); 
            cursor: pointer; 
        }
        .libre:hover { 
            transform: translateY(-5px);
            background: #2ecc71;
            box-shadow: 0 0 25px rgba(39, 174, 96, 0.5);
        }

        .occupe { 
            background: var(--rouge-occupe); 
            opacity: 0.5; 
            cursor: not-allowed; 
        }

        .label {
            margin-top: 10px;
            font-size: 0.8rem;
            opacity: 0.9;
        }

        .msg-complet {
            background: rgba(206, 61, 45, 0.2);
            border: 1px solid var(--rouge-occupe);
            padding: 15px;
            border-radius: 15px;
            margin-bottom: 20px;
            color: #ff8a7d;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .btn-retour {
            display: inline-block;
            margin-top: 15px;
            color: var(--orange-chic);
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="glass-card">
    <h1>Plan de Salle</h1>
    <p class="subtitle">Sélectionnez une table disponible</p>
    
    <?php if ($toutes_occupees): ?>
        <div class="msg-complet">⚠️ Désolé, toutes nos tables sont actuellement occupées.</div>
    <?php endif; ?>

    <div class="grid-tables">
        <?php 
        foreach ($tables as $id => $statut) {
            if ($statut == 'libre') { 
                echo '<a href="?table_id='.$id.'" class="table-box">';
                echo '  <div class="circle libre">'.$id.'</div>';
                echo '  <span class="label">Disponible</span>';
                echo '</a>';
            } else { 
                echo '<div class="table-box">';
                echo '  <div class="circle occupe">'.$id.'</div>';
                echo '  <span class="label">Occupée</span>';
                echo '</div>';
            }
        }
        ?>
    </div>

    <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.1); margin: 20px 0;">
    <a href="choix_service.php" class="btn-retour">← Retour au choix du service</a>
</div>

</body>
</html>