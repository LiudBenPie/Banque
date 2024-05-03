<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un contrat</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    require('../../init.php');
    checkAcl('auth');
    include VIEWS_DIR . '/menu.php';

    // Récupération de la liste des contrats client avec des informations détaillées
    $sql = "SELECT cc.idContratClient, c.nomTypeContrat, cl.nom, cl.prenom
            FROM ContratClient cc
            INNER JOIN Contrat c ON cc.numContrat = c.numContrat
            INNER JOIN Client cl ON cc.numClient = cl.numClient";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $contrats = $stmt->fetchAll();
    ?>

    <form action="supprimerContrat.php" method="post">
        <label for="contrat">Choisir un contrat à supprimer :</label>
        <select name="contrat" id="contrat">
            <?php foreach ($contrats as $contrat) : ?>
                <option value="<?php echo $contrat['idContratClient']; ?>">
                    <?php echo "Contrat n°" . $contrat['idContratClient'] . " - " . $contrat['nomTypeContrat'] . " Client: " . $contrat['nom'] . ' ' . $contrat['prenom']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Supprimer</button>
    </form>

</body>

</html>