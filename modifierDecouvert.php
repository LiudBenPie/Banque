<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

$updateSuccessful = false;

if (isset($_POST['numClient'])) {
    $numClient = intval($_POST['numClient']); // Assurez-vous que $numClient est un entier

    if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
        // Traitement de la modification du découvert du compte sélectionné
        $idCompte = intval($_POST['idCompte']); // Assurez-vous que $idCompte est un entier
        $nouveauDecouvert = floatval($_POST['nouveauDecouvert']); // Assurez-vous que $nouveauDecouvert est un flottant
        $sql = "UPDATE CompteClient SET montantDecouvert = ? WHERE numClient = ? AND idCompte = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nouveauDecouvert, $numClient, $idCompte]);

        $_SESSION['updateSuccess'] = true;
        $updateSuccessful = true; 
    } else {
        // Requête pour récupérer les identifiants et les découverts des comptes associés à ce client
        $sqlComptes = "SELECT idCompte, montantDecouvert FROM CompteClient WHERE numClient = ?";
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
    <p>
        <label for="idCompte">Sélectionnez un compte :</label>
        <select name="idCompte">
            <?php foreach ($comptes as $compte): ?>
                <option value="<?php echo $compte['idCompte']; ?>"><?php echo $compte['idCompte']; ?></option>
            <?php endforeach; ?>
        </select>
    </p>

    <p>
        <label for="nouveauDecouvert">Nouveau montant autorisé de découvert :</label>
        <input type="text" id="nouveauDecouvert" name="nouveauDecouvert">
    </p>
  
    <p>
        <a href="../">Page précédente</a>
        <button type="submit" name="action" value="modifier">Modifier le découvert</button>
    </p>
</form>
