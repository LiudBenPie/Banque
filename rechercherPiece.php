<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Motif</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    require('init.php');
    checkAcl('auth');
    include VIEWS_DIR . '/menu.php';
    // Récupération de la liste des pièces
    $sql = "SELECT idMotif, libelleMotif, listePieces FROM motif";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $motifs = $stmt->fetchAll();
    ?>
    <div class="container">
        <h2>Modifier un Motif</h2>
        <form action="modifierPiece.php" method="post">
            <div class="form-group">
                <label for="motif">Sélectionnez le motif à modifier :</label>
                <select name="idMotif" id="motif">
                    <?php foreach ($motifs as $motif) : ?>
                        <option value="<?php echo $motif['idMotif']; ?>">
                            <?php echo $motif['libelleMotif'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit">Modifier</button>
            </div>
        </form>
    </div>
</body>

</html>
