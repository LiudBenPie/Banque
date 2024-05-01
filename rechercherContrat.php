<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un Contrat</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    require('init.php');
    checkAcl('auth');
    include VIEWS_DIR . '/menu.php';

    // Récupération de la liste des contrats clients avec des informations détaillées
    $sql = "SELECT cc.idContratClient, c.nomTypeContrat, cl.nom, cl.prenom
            FROM ContratClient cc
            INNER JOIN Contrat c ON cc.numContrat = c.numContrat
            INNER JOIN Client cl ON cc.numClient = cl.numClient";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $contrats = $stmt->fetchAll();
    ?>

    <div class="container">
        <h2>Supprimer un Contrat</h2>
        <form action="supprimerContrat.php" method="post">
            <div class="form-group">
                <label for="contrat">Choisir un contrat à supprimer :</label>
                <select name="numContrat" id="contrat">
                    <?php foreach ($contrats as $contrat) : ?>
                        <option value="<?php echo $contrat['idContratClient']; ?>">
                            <?php echo "Contrat n°" . $contrat['idContratClient'] . " - " . $contrat['nomTypeContrat'] . " Client: " . $contrat['nom'] . ' ' . $contrat['prenom']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit">Supprimer</button>
            </div>
        </form>
    </div>

</body>

</html>
