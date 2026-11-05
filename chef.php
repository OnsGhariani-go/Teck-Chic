<?php
session_start();
// Vérifier si c'est bien le chef qui est connecté
// if(!isset($_SESSION['chef'])) { header("Location: login.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Chef - Teck Chic</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { 
            --primary: #df5826; 
            --primary-hover: #ff6b35;
            --dark: #2c3e50; 
            --white: #ffffff;
        }

        body { 
            font-family: 'Poppins', sans-serif; 
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Utilisation du même fond que vos autres pages */
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                        url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
        }

        .glass-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 50px 40px;
            border-radius: 30px;
            text-align: center;
            max-width: 800px;
            width: 90%;
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
        }

        h1 { 
            color: var(--white); 
            margin-bottom: 40px; 
            font-size: 2.8rem; 
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .selection-grid { 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 25px; 
        }

        .choice-card { 
            background: var(--white); 
            padding: 40px 20px; 
            border-radius: 20px; 
            text-decoration: none; 
            color: var(--dark); 
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
            display: flex; 
            flex-direction: column; 
            align-items: center;
            border: none;
        }

        /* Style spécifique pour différencier les boutons comme sur choix_service */
        .card-menu { background: var(--primary); color: white; }
        .card-orders { background: var(--white); color: var(--dark); }

        .choice-card i { font-size: 3.5rem; margin-bottom: 20px; }
        .card-menu i { color: white; }
        .card-orders i { color: var(--primary); }

        .choice-card h2 { margin: 10px 0; font-size: 1.4rem; font-weight: 700; }
        .choice-card p { font-size: 0.9rem; opacity: 0.9; }

        .choice-card:hover { 
            transform: scale(1.05); 
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }

        .btn-logout { 
            margin-top: 40px; 
            display: inline-block; 
            color: rgba(255,255,255,0.8); 
            text-decoration: none; 
            font-weight: 400; 
            font-size: 0.9rem;
            transition: 0.3s;
        }
        
        .btn-logout:hover { color: var(--primary); }

        /* Responsive pour mobile */
        @media (max-width: 600px) {
            .selection-grid { grid-template-columns: 1fr; }
            h1 { font-size: 2rem; }
        }
    </style>
</head>
<body>

<div class="glass-container">
    <h1>👨‍🍳 Bienvenue, Chef !</h1>
    
    <div class="selection-grid">
        <a href="menudy.php" class="choice-card card-menu">
            <i class="fas fa-utensils"></i>
            <h2>Gérer le Menu</h2>
            <p>Plats, prix et visuels.</p>
        </a>
        
        <a href="demande_cmd.php" class="choice-card card-orders">
            <i class="fas fa-clipboard-list"></i>
            <h2>Voir les Commandes</h2>
            <p>Demandes clients en temps réel.</p>
        </a>
    </div>

    <a href="login.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Se déconnecter de la session</a>
</div>

</body>
</html>