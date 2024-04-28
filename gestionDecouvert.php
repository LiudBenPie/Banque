<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

$updateSuccessful = false;
$updateError = '';

// Vérifie si le formulaire a été soumis pour effectuer la modification du découvert
if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
    // Vérifie si les données nécessaires sont présentes dans $_POST
    if (isset($_POST['idCompteClient'], $_POST['nouveauDecouvert'])) {
        $idCompteClient = $_POST['idCompteClient'];
        $nouveauDecouvert = $_POST['nouveauDecouvert'];

        // Valider le nouveau montant autorisé de découvert
        if (!is_numeric($nouveauDecouvert) || $nouveauDecouvert < 0) {
            $updateError = 'Le montant autorisé de découvert doit être un nombre positif.';
        } else {
            try {
                // Requête pour mettre à jour le montant autorisé de découvert pour le compte spécifié
                $sql = "UPDATE CompteClient SET montantDecouvert = ? WHERE idCompteClient = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$nouveauDecouvert, $idCompteClient]);

                // Mise à jour réussie, définir la variable pour afficher l'alerte
                $updateSuccessful = true;
            } catch (PDOException $e) {
                // En cas d'erreur SQL, afficher le message d'erreur
                $updateError = 'Erreur SQL : ' . $e->getMessage();
            }
        }
    }
}

try {
    // Récupération de la liste des découverts des comptes clients
    $sql = "SELECT idCompteClient, montantDecouvert FROM CompteClient";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $comptes = $stmt->fetchAll();
} catch (PDOException $e) {
    // En cas d'erreur SQL, afficher le message d'erreur
    echo 'Erreur SQL : ' . $e->getMessage();
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
        <select id="idCompte" name="idCompteClient">
            <?php foreach ($comptes as $compte): ?>
                <option value="<?php echo htmlspecialchars($compte['idCompteClient']); ?>">
                    <?php echo "Compte " . htmlspecialchars($compte['idCompteClient']) . " (Découvert autorisé : " . htmlspecialchars($compte['montantDecouvert']) . ")"; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>
  
    <p>
        <label for="nouveauDecouvert">Nouveau montant autorisé de découvert :</label>
        <input type="text" id="nouveauDecouvert" name="nouveauDecouvert">
    </p>
  
    <?php if ($updateError): ?>
        <p style="color: red;"><?php echo htmlspecialchars($updateError); ?></p>
    <?php endif; ?>
  
    <p>
        <a href="../">Page précédente</a>
        <button type="submit" name="action" value="modifier">Modifier le découvert</button>
    </p>
</form>

<?php if ($updateSuccessful): ?>
    <script>alert("Les informations du découvert ont été mises à jour avec succès.");</script>
<?php endif; ?>

</body>
</html>
