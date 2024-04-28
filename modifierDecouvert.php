<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

$updateSuccessful = false;

// Vérifie si le formulaire a été soumis pour effectuer la modification du découvert
if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
    // Vérifie si les données nécessaires sont présentes dans $_POST
    if (isset($_POST['idCompteClient'], $_POST['nouveauDecouvert'])) {
        $idCompteClient = $_POST['idCompteClient'];
        $nouveauDecouvert = $_POST['nouveauDecouvert'];

        // Requête pour mettre à jour le montant autorisé de découvert pour le compte spécifié
        $sql = "UPDATE CompteClient SET montantDecouvert = ? WHERE idCompteClient = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nouveauDecouvert, $idCompteClient]);

        // Mise à jour réussie, définir la variable pour afficher l'alerte
        $updateSuccessful = true;
    }
}

// Affiche une alerte si la mise à jour a été réussie
if ($updateSuccessful) {
    echo '<script>alert("Les informations du découvert ont été mises à jour avec succès.");</script>';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le découvert</title>
</head>
<body>

<form action="modifierDecouvert.php" method="post">
    <input name="idCompteClient" value="<?php ($_POST['idCompteClient'])?>">

    <p>
        <label for="nouveauDecouvert">Nouveau montant autorisé de découvert :</label>
        <input type="text" id="nouveauDecouvert" name="nouveauDecouvert">
    </p>
  
    <p>
        <a href="../">Page précédente</a>
        <button type="submit" name="action" value="modifier">Modifier le découvert</button>
    </p>
</form>

</body>
</html>
