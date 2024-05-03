<?php
require('../../init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

// Récupération de la liste des rendez-vous avec les détails clients
$sql = "SELECT rdv.numRdv, rdv.dateRdv, rdv.heureRdv, client.nom AS client_nom, client.prenom AS client_prenom
        FROM rdv
        INNER JOIN client ON rdv.numclient = client.numClient";
$stmt = $conn->prepare($sql);
$stmt->execute();
$Rdv = $stmt->fetchAll();
?>

<form action="modifierRDV.php" method="post">
    <label for="rdv">Sélectionnez le rendez-vous à modifier :</label>
    <select name="numRdv" id="numRdv">
        <?php foreach ($Rdv as $RDV) : ?>
            <option value="<?php echo $RDV['numRdv']; ?>">
                <?php echo "RDV du " . $RDV['dateRdv'] . " à " . $RDV['heureRdv'] . "h avec " . $RDV['client_nom'] . " " . $RDV['client_prenom']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Modifier</button>
</form>
