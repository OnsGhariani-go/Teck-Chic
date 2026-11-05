<?php 
session_start();
include('db.php'); 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Menu Client - Teck Chic</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { 
            --primary: #ff6b21; /* Orange de ta page d'accueil */
            --glass: rgba(255, 255, 255, 0.08);
            --border: rgba(255, 255, 255, 0.1);
        }

        body { 
            font-family: 'Poppins', sans-serif; 
            margin: 0; 
            padding: 0;
            min-height: 100vh;
            color: white;
            /* Même fond que les autres pages */
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), 
                        url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .navbar { 
            padding: 20px 5%; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            background: rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
        }

        .logo { font-weight: 800; font-size: 1.6rem; text-transform: uppercase; letter-spacing: -1px; }
        .logo span { color: var(--primary); }

        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }

        /* Titre de la page */
        .page-title { text-align: center; margin-bottom: 40px; }
        .page-title h2 { font-size: 2.5rem; font-weight: 800; margin: 0; text-transform: uppercase; }
        .page-title p { opacity: 0.6; font-weight: 300; }

        /* Grille des plats */
        .menu-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
            gap: 30px; 
        }
        
        /* Cartes en mode Glassmorphism */
        .card { 
            background: var(--glass); 
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid var(--border);
            border-radius: 30px; 
            overflow: hidden; 
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
            border-color: var(--primary);
        }

        .card img { width: 100%; height: 180px; object-fit: cover; }
        
        .card-body { padding: 20px; text-align: center; }
        
        .plat-nom { font-weight: 600; font-size: 1.3rem; margin-bottom: 5px; }
        .description-plat { font-size: 0.85rem; opacity: 0.7; height: 40px; overflow: hidden; margin-bottom: 15px; font-weight: 300; }
        
        .price { font-weight: 800; color: var(--primary); font-size: 1.4rem; margin-bottom: 15px; }

        /* Sélecteur de quantité */
        .qty-container { 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            gap: 15px; 
            margin-bottom: 20px;
            background: rgba(255,255,255,0.05);
            padding: 8px;
            border-radius: 15px;
        }

        .qty-btn { 
            border: none; 
            background: white; 
            color: black;
            width: 30px; 
            height: 30px; 
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: bold; 
            transition: 0.2s;
        }
        .qty-btn:hover { background: var(--primary); color: white; }

        .qty-input { 
            width: 30px; 
            border: none; 
            background: transparent; 
            text-align: center; 
            font-weight: bold; 
            font-size: 1.1rem; 
            color: white;
        }

        /* Boutons */
        .btn-add { 
            background: var(--primary); 
            color: white; 
            border: none; 
            padding: 14px; 
            border-radius: 15px; 
            cursor: pointer; 
            width: 100%; 
            font-weight: 700; 
            text-transform: uppercase;
            font-size: 0.9rem;
            transition: 0.3s;
        }
        .btn-add:hover { background: #e65a18; transform: scale(1.02); }

        .btn-disabled { background: rgba(255,255,255,0.1) !important; color: rgba(255,255,255,0.3); cursor: not-allowed !important; }

        /* Panier flottant (FAB) */
        .cart-fab { 
            position: fixed; 
            bottom: 30px; 
            right: 30px; 
            background: white; 
            color: black; 
            padding: 18px 35px; 
            border-radius: 20px; 
            text-decoration: none; 
            box-shadow: 0 15px 30px rgba(0,0,0,0.5); 
            font-weight: 800; 
            z-index: 1000; 
            text-transform: uppercase;
            transition: 0.3s;
            border: 2px solid var(--primary);
        }
        .cart-fab:hover { transform: scale(1.05); background: var(--primary); color: white; }

    </style>

</head>
<body>


<div class="container">
    <div class="menu-grid">
    <?php
    // On récupère TOUS les plats cette fois
    $res = mysqli_query($conn, "SELECT * FROM bd_menu ORDER BY id DESC");
    while($row = mysqli_fetch_assoc($res)) {
        $id = $row['id'];
        $dispo = $row['disponibilite']; // 1 pour oui, 0 pour non
    ?>
    <div class="card <?php echo ($dispo == 0) ? 'non-disponible' : ''; ?>">
        <img src="uploads/<?php echo $row['image_path']; ?>" alt="plat">
        
        
        <div class="card-body">
            <div style="font-weight: 600; font-size: 1.2rem;"><?php echo $row['nom']; ?></div>
            
            <div class="description-plat">
                <?php echo $row['description']; ?>
            </div>
            
            <div class="price"><?php echo $row['prix']; ?> DT</div>
            
            <?php if($dispo == 1): ?>
                <form action="ajouter_au_panier.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="qty-container">
                        <button type="button" class="qty-btn" onclick="changeQty(<?php echo $id; ?>, -1)">-</button>
                        <input type="text" name="qty" id="qty_<?php echo $id; ?>" value="1" class="qty-input" readonly>
                        <button type="button" class="qty-btn" onclick="changeQty(<?php echo $id; ?>, 1)">+</button>
                    </div>
                    <button type="submit" class="btn-add">
                        <i class="fas fa-plus"></i> Ajouter au panier
                    </button>
                </form>
            <?php else: ?>
                <button class="btn-add" style="background: #ccc; cursor: not-allowed;" disabled>
                     non disponible 
                </button>
            <?php endif; ?>
        </div>
    </div>
    <?php } ?>
</div>
</div>

<?php 
$count = isset($_SESSION['panier']) ? array_sum($_SESSION['panier']) : 0;
if($count > 0) { ?>
    <a href="recu.php" class="cart-fab">
        valider commande 
    </a>
<?php } ?>

<script>
function changeQty(id, delta) {
    var input = document.getElementById('qty_' + id);
    var val = parseInt(input.value);
    if(val + delta >= 1) {
        input.value = val + delta;
    }
}
</script>

</body>
</html>