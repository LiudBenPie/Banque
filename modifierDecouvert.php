<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

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

// Affiche une alerte si la mise à jour a été réussie
if ($updateSuccessful) {
    echo '<script>alert("Les informations du decouvert ont été mises à jour avec succès.");</script>';
}
?>

<form action="modifierDecouvert.php" method="post" name='monForm'>
    <input type="hidden" name="numClient" value="<?php echo isset($_POST['numClient']) ? htmlspecialchars($_POST['numClient']) : ''; ?>">
    <!-- Ajout d'un champ pour saisir l'ID du compte -->
    <input type="hidden" name="idCompte" value="<?php echo isset($_POST['idCompte']) ? htmlspecialchars($_POST['idCompte']) : ''; ?>">

    <p>
        <label for="nouveauDecouvert">Nouveau montant autorisé de découvert :</label>
        <input type="text" id="nouveauDecouvert" name="nouveauDecouvert">
    </p>
  
    <p>
        <a href="../">Page précédente</a>
        <button type="submit" name="action" value="modifier">Modifier le découvert</button>
    </p>
</form>
