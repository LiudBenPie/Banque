<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';
// Récupération de la liste des comptes clients avec les informations sur le client
$sql = "SELECT CompteClient.idCompteClient, CompteClient.numClient, Client.nom, Client.prenom, CompteClient.idCompteClient 
        FROM CompteClient 
        INNER JOIN Client ON CompteClient.numClient = Client.numClient";
$stmt = $conn->prepare($sql);
$stmt->execute();
$compteClients = $stmt->fetchAll();
?>
<form action="realiserOperation.php" method="post">
    <label for="compteClient">Sélectionnez le compte client pour l'opération :</label>
    <select name="idCompteClient" id="compteClient">
        <?php foreach ($compteClients as $compteClient) : ?>
            <option value="<?php echo $compteClient['idCompteClient']; ?>">
                <?php echo "Client: " . $compteClient['nom'] . ' ' . $compteClient['prenom'] . ", N° Compte: " . $compteClient['idCompteClient']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Réaliser l'opération</button>
</form>
