<?php
require('init.php'); 
checkAcl('auth'); // Vérifie les autorisations de l'utilisateur

include VIEWS_DIR . '/menu.php'; // Inclut le fichier de menu

try {
    // Récupération de la liste des découverts des comptes clients
    $sql = "SELECT idCompteClient, montantDecouvert FROM CompteClient";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $comptes = $stmt->fetchAll();

} catch (PDOException $e) {
    // En cas d'erreur, afficher le message d'erreur SQL
    echo "Erreur SQL : " . $e->getMessage();
    exit; // Arrêter l'exécution du script en cas d'erreur
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
    <p>
        <!-- Sélection du compte à modifier -->
        <label for="idCompteClient">Sélectionnez un compte :</label>
        <select id="idCompte" name="idCompte">
            <?php foreach ($comptes as $compte): ?>
                <option value="<?php echo $compte['idCompteClient']; ?>">
                    <?php echo "Compte " . $compte['idCompteClient'] . " (Découvert autorisé : " . $compte['montantDecouvert'] . ")"; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="action" value="modifier">Modifier le découvert</button>
    </p>
</form>

</body>
</html>


