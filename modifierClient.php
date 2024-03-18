<?php
require('connect.php');

$updateSuccessful = false;

if (isset($_POST['numClient'])) {
    $numClient = $_POST['numClient'];

    if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $adresse = $_POST['adresse'];
        $mail = $_POST['mail'];
        $numTel = $_POST['numTel'];
        $situation = $_POST['situation'];

        $sql = "UPDATE Client SET nom = ?, prenom = ?, adresse = ?, mail = ?, numTel = ?, situation = ? WHERE numClient = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nom, $prenom, $adresse, $mail, $numTel, $situation, $numClient]);

        $_SESSION['updateSuccess'] = true;
        $updateSuccessful = true; 

    } else {
        $sql = "SELECT * FROM Client WHERE numClient = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$numClient]);
        $employe = $stmt->fetch();
    }
}
// Display the message and unset it so it doesn't persist on page refresh
// At the very end of your PHP script, before closing the PHP tag
if (isset($_SESSION['updateSuccess'])) {
    unset($_SESSION['updateSuccess']); // Unset the variable to prevent future alerts
}
?>

<form action="modifierClient.php" method="post" name='monForm'>

        <input type="hidden" name="numClient" value="<?php echo isset($client['numClient']) ? htmlspecialchars($employe['numEmploye']) : ''; ?>">

    <p>
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?php echo isset($client['nom']) ? htmlspecialchars($client['nom']) : ''; ?>">
    </p>

    <p>
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo isset($client['prenom']) ? htmlspecialchars($client['prenom']) : ''; ?>">
    </p>

    <p>
        <label for="adresse">Adresse:</label>
        <input type="text" id="adresse" name="adresse" value="<?php echo isset($client['adresse']) ? htmlspecialchars($client['adresse']) : ''; ?>">
    </p>

    <p>
        <label for="mail">Mail :</label>
        <input type="text" id="mail" name="mail" value="<?php echo isset($client['mail']) ? htmlspecialchars($client['mail']) : ''; ?>">
    </p>

    <p>
        <label for="numTel">numTel :</label>
        <input type="text" id="numTel" name="numTel" value="<?php echo isset($client['numTel']) ? htmlspecialchars($client['numTel']) : ''; ?>">
    </p>

    <p>
        <label for="numTel">numTel :</label>
        <input type="text" id="numTel" name="numTel" value="<?php echo isset($client['numTel']) ? htmlspecialchars($client['numTel']) : ''; ?>">
    </p>
  
    <p>
        <label for="situation">Situation :</label>
        <input type="text" id="situation" name="situation" value="<?php echo isset($client['situation']) ? htmlspecialchars($client['situation']) : ''; ?>">
    </p>
  
    <p>
        <button type="submit" name="action" value="modifier">Mettre à jour</button>
    </p>
</form>

<script type="text/javascript">
  window.onload = function() {
    // If the PHP variable indicates success, show the message
    <?php if ($updateSuccessful): ?>
    alert('Les valeurs ont été modifiées avec succès.');
    <?php endif; ?>
  }
</script>
