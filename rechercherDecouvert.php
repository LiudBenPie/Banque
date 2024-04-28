<?php
require('init.php'); 
checkAcl('auth'); // Vérifie les autorisations de l'utilisateur

include VIEWS_DIR . '/menu.php'; // Inclut le fichier de menu

// Récupération de la liste des découverts des comptes clients
$sql = "SELECT idCompte, montantDecouvert FROM CompteClient";
$stmt = $conn->prepare($sql);
$stmt->execute();
$comptes = $stmt->fetchAll();

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
        <label for="idCompte">Sélectionnez un compte :</label>
        <select id="idCompte" name="idCompte">
            <?php foreach ($comptes as $compte): ?>
                <option value="<?php echo htmlspecialchars($compte['idCompte']); ?>">
                    <?php echo "Compte ".htmlspecialchars($compte['idCompte'])." (Découvert autorisé : ".htmlspecialchars($compte['montantDecouvert']).")"; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="action" value="modifier">Modifier le découvert</button>
    </p>
</form>

</body>
</html>

