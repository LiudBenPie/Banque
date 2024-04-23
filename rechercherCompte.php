<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';
// Récupération de la liste des comptes
$sql = "SELECT idCompte, nomTypeCompte, description FROM compte";
$stmt = $conn->prepare($sql);
$stmt->execute();
$comptes = $stmt->fetchAll();
?>
<form action="realiserOperation.php" method="post">
    <label for="compte">Sélectionnez le compte pour l'opération :</label>
    <select name="idCompte" id="compte">
        <?php foreach ($comptes as $compte) : ?>
            <option value="<?php echo $compte['idCompte']; ?>">
                <?php echo $compte['nomTypeCompte'] . ' - ' . $compte['description']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Réaliser une opération</button>
</form>