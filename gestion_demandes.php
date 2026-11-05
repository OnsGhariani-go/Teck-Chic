<?php include "db.php"; ?>

<!-- Assurez-vous d'utiliser sty.css ici -->
<link rel="stylesheet" href="sty.css">

<div class="container">
    
    <?php if(isset($_GET['status'])): ?>
        <?php if($_GET['status'] == 'accepted'): ?>
            <div class="alert success"> Compte cree et utilisateur ajoute avec succes !</div>
        <?php elseif($_GET['status'] == 'refused'): ?>
            <div class="alert danger">La demande a été refusee et supprimee.</div>
        <?php endif; ?>
    <?php endif; ?>


    <!-- ... votre boucle while ... -->
    <h1>Demandes en attente</h1>

    <?php
    $res = $conn->query("SELECT * FROM demandes WHERE statut='en_attente'");

    if ($res->num_rows == 0) {
        echo "<p style='opacity:0.5;'>Aucune demande pour le moment.</p>";
    }

    while($row = $res->fetch_assoc()){
    ?>
    <div class="card">
        <p>
            <?php echo htmlspecialchars($row['username']); ?> 
            <span class="role-badge"><?php echo $row['role']; ?></span>
        </p>

        <div class="button-group">
            <a class="accept" href="accepter.php?id=<?php echo $row['id']; ?>"> Accepter</a>
            <a class="refuse" href="refuser.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Refuser cette inscription ?')"> Refuser</a>
        </div>
    </div>
    <?php } ?>

</div>