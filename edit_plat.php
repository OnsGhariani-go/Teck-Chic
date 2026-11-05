<?php include('db.php'); 
$id = $_GET['id'];
$plat = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM bd_menu WHERE id=$id"));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le Plat</title>
    <style>
        body { font-family: sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .edit-card { background: white; padding: 30px; border-radius: 12px; width: 400px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        input, textarea { width: 100%; margin-bottom: 15px; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        .btn-save { background: #df5826; color: white; border: none; padding: 10px 20px; width: 100%; cursor: pointer; border-radius: 6px; }
    </style>
</head>
<body>
    <div class="edit-card">
        <h3>Modifier le plat</h3>
        <form action="actions.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $plat['id']; ?>">
            <label>Nom :</label>
            <input type="text" name="nom" value="<?php echo $plat['nom']; ?>" required>
            <label>Prix (DT) :</label>
            <input type="number" step="0.01" name="prix" value="<?php echo $plat['prix']; ?>" required>
            <label>Description :</label>
            <textarea name="description"><?php echo $plat['description']; ?></textarea>
            <label>Changer l'image (optionnel) :</label>
            <input type="file" name="image">
            <button type="submit" name="modifier" class="btn-save">Enregistrer les modifications</button>
        
        </form>
    </div>
</body>
</html>