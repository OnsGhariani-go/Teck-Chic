<?php
session_start();
include('db.php'); 

// On vérifie si le service est passé dans l'URL pour l'enregistrer en session
if (isset($_GET['service'])) {
    $_SESSION['service'] = $_GET['service'];
    
    if ($_GET['service'] == 'emporte') {
        header("Location: menu_client.php");
        exit();
    } elseif ($_GET['service'] == 'surplace') {
        header("Location: plan_salle.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue - Tech Chick</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;900&display=swap" rel="stylesheet">
    
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)), 
                        url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.08); 
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 40px;
            padding: 60px 40px;
            width: 100%;
            max-width: 420px;
            text-align: center;
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.6);
            color: white;
            animation: slideUp 0.8s ease-out;
        }

        h1 {
            font-size: 3.5rem;
            font-weight: 900;
            line-height: 0.9;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: -2px;
            background: linear-gradient(to bottom, #ffffff, #bbbbbb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subtitle {
            font-size: 1.1rem;
            opacity: 0.7;
            margin-bottom: 50px;
            font-weight: 300;
        }

        /* Style des liens transformés en boutons */
        .btn-service {
            display: block;
            width: calc(100% - 44px); /* Ajustement pour le padding */
            padding: 22px;
            margin: 0 auto 15px auto;
            border-radius: 18px;
            font-size: 1.3rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none; /* Enlève le souligné du lien */
            box-sizing: content-box;
        }

        /* Orange Pur (À emporter) */
        .btn-primary {
            background: #ff6b21;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background: #e65a18;
            transform: scale(1.02);
        }

        /* Blanc Épuré (Sur place) */
        .btn-outline {
            background: white;
            color: #000;
            border: 1px solid #ddd;
        }

        .btn-outline:hover {
            background: #f8f8f8;
            transform: scale(1.02);
            border-color: #ff6b21;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 400px) {
            h1 { font-size: 2.8rem; }
            .glass-card { padding: 40px 20px; }
        }
    </style>
</head>
<body>

<div class="glass-card">
    <h1>BIENVENUE</h1>
    <p class="subtitle">Veuillez choisir votre type de commande</p>
    
    <a href="choix_service.php?service=emporte" class="btn-service btn-primary">
        À emporter
    </a>
    
    <a href="choix_service.php?service=surplace" class="btn-service btn-outline">
        Sur place
    </a>
</div>
</body>
</html>