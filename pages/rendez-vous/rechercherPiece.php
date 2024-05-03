<!DOCTYPE html> 
<html lang="fr"> 

<head>
    <meta charset="UTF-8"> 
    <title>Modifier un motif</title>
</head>

<body>
    <?php
    require('../../init.php');
    checkAcl('auth');
    include VIEWS_DIR . '/menu.php'; 
    // Récupération de la liste des motifs
    $sql = "SELECT idMotif, libelleMotif FROM motif";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $motifs = $stmt->fetchAll();
    ?>
    <form action="modifierPiece.php" method="post">
        <label for="motif">Sélectionnez le motif à modifier :</label>
        <select name="idMotif" id="motif">
            <?php foreach ($motifs as $motif) : ?>
                <option value="<?php echo $motif['idMotif']; ?>">
                    <?php echo $motif['libelleMotif']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Modifier</button>
    </form>
</body>

</html>
