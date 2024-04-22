<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';
// Récupération de la liste des types de compte
$sql = "SELECT idType, nomType FROM TypeCompte";
$stmt = $conn->prepare($sql);
$stmt->execute();
$typesCompte = $stmt->fetchAll();
?>
<form action="modifierTypeCompte.php" method="post">
    <label for="typeCompte">Choisir un type de compte à modifier :</label>
    <select name="idType" id="typeCompte">
        <?php foreach ($typesCompte as $typeCompte): ?>
            <option value="<?php echo $typeCompte['idType']; ?>">
                <?php echo $typeCompte['nomType']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Modifier</button>
</form>

