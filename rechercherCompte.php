<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';
// Récupération de la liste des comptes clients avec les informations sur le client
$sql = "SELECT cc.idCompteClient, cc.numClient, c.nom, c.prenom, cc.dateOuverture, cc.solde, cc.montantDecouvert, cc.idCompte 
        FROM CompteClient cc 
        INNER JOIN Client c ON cc.numClient = c.numClient";
$stmt = $conn->prepare($sql);
$stmt->execute();
$compteClients = $stmt->fetchAll();
?>
<form action="realiserOperation.php" method="post">
    <label for="compteClient">Sélectionnez le compte client à modifier :</label>
    <select name="idCompteClient" id="compteClient">
        <?php foreach ($compteClients as $compteClient) : ?>
            <option value="<?php echo $compteClient['idCompteClient']; ?>">
                <?php echo "Client: " . $compteClient['nom'] . ' ' . $compteClient['prenom'] . ", Date d'ouverture: " . $compteClient['dateOuverture'] . ", Solde: " . $compteClient['solde'] . ", Montant découvert: " . $compteClient['montantDecouvert'] . ", ID Compte: " . $compteClient['idCompte']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Modifier</button>
</form>
