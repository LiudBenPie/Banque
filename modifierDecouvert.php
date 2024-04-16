<?php
require('connect.php');

$updateSuccessful = false;

if (isset($_POST['numClient'])) {
    $numClient = $_POST['numClient'];

    if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
        // Traitement de la modification du découvert du compte sélectionné
        $idCompte = $_POST['idCompte'];
        $nouveauDecouvert = $_POST['nouveauDecouvert'];
        $sql = "UPDATE CompteClient SET montantDecouvert = ? WHERE numClient = ? AND idCompte = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nouveauDecouvert, $numClient, $idCompte]);

        $_SESSION['updateSuccess'] = true;
        $updateSuccessful = true; 

    } else {
        // Requête pour récupérer les identifiants et les solde des comptes associés à ce client
        $sqlComptes = "SELECT idCompte, solde FROM CompteClient WHERE numClient = ?";
        $stmtComptes = $conn->prepare($sqlComptes);
        $stmtComptes->execute([$numClient]);
        $comptes = $stmtComptes->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Display the message and unset it so it doesn't persist on page refresh
// At the very end of your PHP script, before closing the PHP tag
if (isset($_SESSION['updateSuccess'])) {
    unset($_SESSION['updateSuccess']); // Unset the variable to prevent future alerts
}
?>

<form action="modifierDecouvert.php" method="post" name='monForm'>

    <input type="hidden" name="numClient" value="<?php echo isset($_POST['numClient']) ? htmlspecialchars($_POST['numClient']) : ''; ?>">

    <p>
        <label for="nouveauDecouvert">Nouveau montant autorisé de découvert :</label>
        <input type="text" id="nouveauDecouvert" name="nouveauDecouvert">
    </p>
  
    <p>
        <button type="submit" name="action" value="modifier">Modifier le découvert</button>
    </p>
</form>

<script type="text/javascript">
  window.onload = function() {
    // If the PHP variable indicates success, show the message
    <?php if ($updateSuccessful): ?>
        alert('Le montant autorisé de découvert a été modifié avec succès.');
    <?php endif; ?>
  }
</script>
