<?php
require('connect.php');

$updateSuccessful = false;

// Vérifie si le formulaire a été soumis
if (isset($_POST['action']) && $_POST['action'] === 'modifier' && isset($_POST['numClient'])) {
    $numClient = $_POST['numClient'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $mail = $_POST['mail'];
    $numTel = $_POST['numTel'];
    $situation = $_POST['situation'];

    // Prépare et exécute la requête SQL pour mettre à jour les informations du client
    $sql = "UPDATE Client SET nom = ?, prenom = ?, adresse = ?, mail = ?, numTel = ?, situation = ? WHERE numClient = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nom, $prenom, $adresse, $mail, $numTel, $situation, $numClient]);

    // Indique que la mise à jour a été réussie
    $updateSuccessful = true; 
    $_SESSION['updateSuccess'] = true;
} elseif (isset($_POST['numClient'])) {
    // Prépare et exécute la requête pour obtenir les informations actuelles du client
    $numClient = $_POST['numClient'];
    $sql = "SELECT * FROM Client WHERE numClient = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$numClient]);
    $client = $stmt->fetch();
}

// Si la mise à jour a été réussie, affiche un message et réinitialise le marqueur de succès
if (isset($_SESSION['updateSuccess'])) {
    echo '<script>alert("Les informations du client ont été mises à jour avec succès.");</script>';
    unset($_SESSION['updateSuccess']);
}
?>

<!-- Formulaire pour la mise à jour des informations du client -->
<form action="modifierClient.php" method="post" name='monForm'>
    <fieldset><legend>MODIFICATION DES INFORMATIONS DES CLIENTS</legend>
        <p>
            <label for="num">ID Client :</label>
            <input type="text" name="numClient" value="<?php echo htmlspecialchars($client['numClient'] ?? ''); ?>" readonly>
        </p>
        <p>
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($client['nom'] ?? ''); ?>">
        </p>
        <p>
            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($client['prenom'] ?? ''); ?>">
        </p>
        <p>
            <label for="adresse">Adresse:</label>
            <input type="text" id="adresse" name="adresse" value="<?php echo htmlspecialchars($client['adresse'] ?? ''); ?>">
        </p>
        <p>
            <label for="mail">Mail :</label>
            <input type="email" id="mail" name="mail" value="<?php echo htmlspecialchars($client['mail'] ?? ''); ?>">
        </p>
        <p>
            <label for="numTel">Numéro de Téléphone :</label>
            <input type="text" id="numTel" name="numTel" value="<?php echo htmlspecialchars($client['numTel'] ?? ''); ?>">
        </p>
        <p>
            <label for="situation">Situation :</label>
            <input type="text" id="situation" name="situation" value="<?php echo htmlspecialchars($client['situation'] ?? ''); ?>">
        </p>
        <p>
            <button type="submit" name="action" value="modifier">Mettre à jour</button>
        </p>
    </fieldset>
</form>