<?php include('db.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Chef - Gestion du Menu</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; padding: 30px; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { color: #2c3e50; border-bottom: 3px solid #df5826; padding-bottom: 10px; }
        
        /* Formulaire */
        .add-form { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; background: #f9f9f9; padding: 20px; border-radius: 8px; margin-bottom: 30px; }
        input, textarea { padding: 10px; border: 1px solid #ddd; border-radius: 6px; width: 100%; }
        .btn-add { grid-column: span 2; background: #df5826; color: white; border: none; padding: 12px; cursor: pointer; font-weight: bold; border-radius: 6px; }
        
        /* Grid et Cards */
        .menu-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; }
        .card { background: white; border: 1px solid #eee; border-radius: 10px; overflow: hidden; text-align: center; transition: 0.3s; padding-bottom: 15px; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 6px 12px rgba(0,0,0,0.1); }
        .card img { width: 100%; height: 180px; object-fit: cover; }
        
        /* Toggle Switch */
        .switch { position: relative; display: inline-block; width: 50px; height: 24px; vertical-align: middle; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 34px; }
        .slider:before { position: absolute; content: ""; height: 16px; width: 16px; left: 4px; bottom: 4px; background-color: white; transition: .4s; border-radius: 50%; }
        input:checked + .slider { background-color: #4dd35e; }
        input:checked + .slider:before { transform: translateX(26px); }

        .actions { margin-top: 15px; border-top: 1px solid #eee; padding-top: 10px; }
        .btn-edit { color: #000; text-decoration: none; font-weight: bold;margin-left: 10px; }
        .btn-del { color: #000; text-decoration: none; font-weight: bold; margin-left: 10px; }
    </style>
</head>
<body>

<div class="container">
    <h2>👨‍🍳 Tableau de Bord du Chef</h2>

    <form class="add-form" action="actions.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="nom" placeholder="Nom du plat" required>
        <input type="number" step="0.01" name="prix" placeholder="Prix (en DT)" required>
        <textarea name="description" placeholder="Description du plat (ingrédients, calories...)" style="grid-column: span 2;"></textarea>
        <input type="file" name="image" accept="image/*" required style="grid-column: span 2; ">
        <button type="submit" name="ajouter" class="btn-add">➕ Ajouter au Menu du Jour</button>
    </form>

    <div class="menu-grid">
        <?php
        $res = mysqli_query($conn, "SELECT * FROM bd_menu ORDER BY id");
        while($row = mysqli_fetch_assoc($res)) {
            $checked = $row['disponibilite'] ? 'checked' : '';
            echo "
            <div class='card'>
                <img src='uploads/".$row['image_path']."' alt='plat'>
                <h3>".$row['nom']."</h3>
                <p>".$row['description']."</p>
                <p style='color:  #df5826; font-weight: bold;'>".$row['prix']." DT</p>
                
                <div style='padding: 10px;'>
                    <span>Disponible : </span>
                    <label class='switch'>
                        <input type='checkbox' $checked onclick='window.location.href=\"actions.php?toggle=".$row['id']."&status=".$row['disponibilite']."\"'>
                        <span class='slider'></span>
                    </label>
                </div>

                <div class='actions'>
                    <a href='edit_plat.php?id=".$row['id']."' class='btn-edit'>📝 Modifier</a>
                    <a href='actions.php?delete=".$row['id']."' class='btn-del' onclick='return confirm(\"Supprimer ce plat ?\")'>🗑️ Supprimer</a>
                </div>
            </div>";
        }
        ?>
    </div>
   	 
</div>

</body>
</html>