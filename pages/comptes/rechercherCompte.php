<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Création d'opération</title>
</head>

<body>

<?php
require('../../init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

$createSuccessful = false;

if (isset($_POST['action'])) {
    $montant = $_POST['montant'];
    $dateOperation = $_POST['dateOperation'];
    $typeOp = $_POST['typeOp'];
    $idCompteClient = $_POST['idCompteClient'];

    $sql = "INSERT INTO operation (montant, dateOperation, typeOp, idCompteClient) VALUES (?, ?, ?, ?)";
    $res = $conn->prepare($sql);
    $res->execute([$montant, $dateOperation, $typeOp, $idCompteClient]);
    $createSuccessful = true;
}

// Affiche une alerte si la création a été réussie
if ($createSuccessful) {
    echo '<script>alert("L\'opération a été créée avec succès.");</script>';
}
?>

    <!-- Formulaire pour la création du contrat -->
    <form action="rechercherCompte.php" method="post" name='monForm'>
        <p>
            <label for="montant">Montant :</label>
            <input type="number" name="montant" id="montant" required>
        </p>
        <p>
            <label for="dateOperation">Date de l'opération :</label>
            <input type="date" name="dateOperation" id="dateOperation" required>
        </p>
        <p>
            <label for="typeOp">Type de l'opération :</label>
            <input type="text" name="typeOp" id="typeOp" required>
        </p>
        <p>
            <label for="idCompteClient">Id du compte client :</label>
            <input type="text" name="idCompteClient" id="idCompteClient" required>
        </p>
        <p>
            <a href="../..">Page précédente</a>
            <button type="submit" name="action" value="Créer">Créer</button>
        </p>
    </form>
</body>

</html>
