<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';
// Récupération de la liste des decouverts
$sql = "SELECT idCompte, montantDecouvert FROM CompteClient";
$stmt = $conn->prepare($sql);
$stmt->execute();
$comptes = $stmt->fetchAll();
?>

<form action="modifierDecouvert.php" method="post">
    <p>
        <!-- Sélection du compte à modifier -->
        <label for="idCompte">Sélectionnez un compte :</label>
        <select id="idCompte" name="idCompte">
            <?php foreach ($comptes as $compte): ?>
                <option value="<?php echo $compte['idCompte']; ?>">
                <?php echo "Compte ".$compte['idCompte']." (Découvert autorisé : ".$compte['montantDecouvert'].")"; ?>
            </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="action" value="modifier">Modifier le découvert</button>
    </p>
</form>
    
</body>
</html>