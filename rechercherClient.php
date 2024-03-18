<?php
require('connect.php');
// Récupération de la liste des clients
$sql = "SELECT numClient, nom, prenom, adresse, mail, numtel, situation FROM client";
$stmt = $conn->prepare($sql);
$stmt->execute();
$employes = $stmt->fetchAll();
?>
<form action="modifierClient.php" method="post">
    <label for="client">Choisir un client à modifier :</label>
    <select name="numClient" id="client">
        <?php foreach ($client as $client): ?>
            <option value="<?php echo $client['numClient']; ?>">
                <?php echo $client['nom']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Modifier</button>
</form>
