<?php
require('connect.php');
// Récupération de la liste des clients
$sql = "SELECT numClient, nom, prenom, adresse, mail, numtel, situation, dateNaissance FROM client";
$stmt = $conn->prepare($sql);
$stmt->execute();
$clients = $stmt->fetchAll();
?>
<form action="modifierClient.php" method="post">
    <label for="client">Choisir un client à modifier :</label>
    <select name="numClient" id="client">
        <?php foreach ($clients as $client): ?>
            <option value="<?php echo $client['numClient']; ?>">
                <?php echo $client['nom'].' '.$client['prenom'].' '.$client['dateNaissance']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Modifier</button>
</form>
