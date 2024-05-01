<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechercher Type Contrat</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    require('init.php');
    checkAcl('auth');
    include VIEWS_DIR . '/menu.php';
    // Récupération de la liste des contrats
    $sql = "SELECT numContrat, nomTypeContrat FROM contrat";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $contrats = $stmt->fetchAll();
    ?>
    <div class="container">
        <h2>Rechercher Type Contrat</h2>
        <form action="modifierTypeContrat.php" method="post">
            <div class="form-group">
                <label for="contrat">Choisir un contrat à modifier :</label>
                <select name="numContrat" id="contrat">
                    <?php foreach ($contrats as $contrat) : ?>
                        <option value="<?php echo $contrat['numContrat']; ?>">
                            <?php echo $contrat['nomTypeContrat']; ?>
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
