<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

$updateSuccessful = false;

    if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
        // Traitement de la modification du découvert du compte sélectionné
        $idCompteClient = $_POST['idCompteClient'];
        $nouveauDecouvert = $_POST['nouveauDecouvert'];
        $sql = "UPDATE CompteClient SET montantDecouvert = ? WHERE idCompteClient = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nouveauDecouvert, $idCompteClient]);

        $_SESSION['updateSuccess'] = true;
        $updateSuccessful = true; 

    } else {
        // Requête pour récupérer les identifiants et les découverts des comptes associés à ce client
        $sqlComptes = "SELECT idCompte, montantDecouvert FROM CompteClient WHERE idCompteClient = ?";
        $stmtComptes = $conn->prepare($sqlComptes);
        $stmtComptes->execute([$idCompteClient]);
        $comptes = $stmtComptes->fetchAll(PDO::FETCH_ASSOC);
    }

// Affiche une alerte si la mise à jour a été réussie
if ($updateSuccessful) {
    echo '<script>alert("Les informations du decouvert ont été mises à jour avec succès.");</script>';
}
?>

<form action="modifierDecouvert.php" method="post" name='monForm'>
    <input type="hidden" name="idCompteClient" value="<?php echo isset($_POST['idCompteClient']) ? htmlspecialchars($_POST['idCompteClient']) : ''; ?>">

    <p>
        <label for="nouveauDecouvert">Nouveau montant autorisé de découvert :</label>
        <input type="text" id="nouveauDecouvert" name="nouveauDecouvert">
    </p>
  
    <p>
        <a href="../">Page précédente</a>
        <button type="submit" name="action" value="modifier">Modifier le découvert</button>
    </p>
</form>