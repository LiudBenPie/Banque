<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechercher Type Compte</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    require('../../init.php');
    checkAcl('auth');
    include VIEWS_DIR . '/menu.php';
    // Récupération de la liste des types de compte
    $sql = "SELECT idCompte, nomTypeCompte FROM compte";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $typesCompte = $stmt->fetchAll();
    ?>
    <form action="modifierTypeCompte.php" method="post">
        <label for="typeCompte">Choisir un type de compte à modifier :</label>
        <select name="idCompte" id="typeCompte">
            <?php foreach ($typesCompte as $typeCompte): ?>
                <option value="<?php echo $typeCompte['idCompte']; ?>">
                    <?php echo $typeCompte['nomTypeCompte']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Modifier</button>
    </form>
</body>

