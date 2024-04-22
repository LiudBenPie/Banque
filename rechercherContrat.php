<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';
// Récupération de la liste des contrats
$sql = "SELECT numContrat, nomContrat FROM contrat";
$stmt = $conn->prepare($sql);
$stmt->execute();
$contrats = $stmt->fetchAll();
?>
<form action="modifierContrat.php" method="post">
    <label for="contrat">Choisir un contrat à modifier :</label>
    <select name="numContrat" id="contrat">
        <?php foreach ($contrats as $contrat): ?>
            <option value="<?php echo $contrat['numContrat']; ?>">
                <?php echo $contrat['nomContrat']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Modifier</button>
</form>
