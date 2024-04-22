<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';
// Récupération de la liste des comptes
$sql = "SELECT idCompte, nomCompte FROM compte";
$stmt = $conn->prepare($sql);
$stmt->execute();
$comptes = $stmt->fetchAll();
?>
<form action="modifierCompte.php" method="post">
    <label for="compte">Choisir un compte à modifier :</label>
    <select name="idCompte" id="compte">
        <?php foreach ($comptes as $compte): ?>
            <option value="<?php echo $compte['idCompte']; ?>">
                <?php echo $compte['nomCompte']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Modifier</button>
</form>
