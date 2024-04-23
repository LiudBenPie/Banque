<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';
// Récupération de la liste des comptes clients
$sql = "SELECT idCompteClient, numClient FROM CompteClient";
$stmt = $conn->prepare($sql);
$stmt->execute();
$comptesClients = $stmt->fetchAll();
?>
<form action="realiserOperation.php" method="post">
    <label for="compteClient">Sélectionnez le compte client pour l'opération :</label>
    <select name="idCompteClient" id="compteClient">
        <?php foreach ($comptesClients as $compteClient) : ?>
            <option value="<?php echo $compteClient['idCompteClient']; ?>">
                <?php echo $compteClient['numClient']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Réaliser une opération</button>
</form>
