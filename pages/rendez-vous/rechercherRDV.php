<?php
require('../../init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';
// Récupération de la liste des pieces
$sql = "SELECT numRdv, dateRdv, heureRdv, client.nom, client.prenom,
        FROM rdv
        INNER JOIN client on rdv.numclient = client.numClient";
$stmt = $conn->prepare($sql);
$stmt->execute();
$Rdv = $stmt->fetchAll();
?>
<form action="modifierRDV.php" method="post">
    <label for="rdv">Sélectionnez le rendez-vous à modifier :</label>
    <select name="numRdv" id="numRdv">
        <?php foreach ($Rdv as $RDV) : ?>
            <option value="<?php echo $RDV['numRdv']; ?>">
                <?php echo "RDV du".$RDV['dateRdv']." à ".$RDV['heureRdv']." avec ".$RDV['client.nom']." ".$RDV['client.prenom'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Modifier</button>
</form>