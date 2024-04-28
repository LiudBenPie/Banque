<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

$deleteSuccessful = false;

if (isset($_POST['numContrat']) && isset($_POST['action']) && $_POST['action'] === 'supprimer') {
    $numContrat = $_POST['numContrat'];

    $sql = "DELETE FROM ContratClient WHERE idContratClient = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$numContrat]);

    $_SESSION['deleteSuccess'] = true;
    $deleteSuccessful = true; 
} elseif (isset($_POST['numContrat'])) {
    $numContrat = $_POST['numContrat'];

    $sql = "SELECT cc.idContratClient, c.nomTypeContrat, cl.nom, cl.prenom
            FROM ContratClient cc
            INNER JOIN Contrat c ON cc.numContrat = c.numContrat
            INNER JOIN Client cl ON cc.numClient = cl.numClient
            WHERE cc.idContratClient = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$numContrat]);
    $contrat = $stmt->fetch();
}

// Affiche une alerte si la suppression a été réussie
if ($deleteSuccessful) {
    echo '<script>alert("Le contrat a été supprimé avec succès.");</script>';
}
?>

<!-- Formulaire pour la suppression du contrat -->
<form action="supprimerContrat.php" method="post">

    <!-- Champs du formulaire avec les informations du contrat à supprimer -->
    <p>
        <label for="numContrat">Êtes-vous sûr de vouloir supprimer le contrat :</label>
        <input type="hidden" name="numContrat" value="<?php echo isset($contrat['idContratClient']) ? htmlspecialchars($contrat['idContratClient']) : ''; ?>">
        <?php echo isset($contrat['idContratClient']) ? "Contrat n°" . htmlspecialchars($contrat['idContratClient']) . " - " . htmlspecialchars($contrat['nomTypeContrat']) . " pour " . htmlspecialchars($contrat['nom']) . ' ' . htmlspecialchars($contrat['prenom']) : ''; ?>
    </p>

    <p>
        <a href="../">Page précédente</a>
        <button type="submit" name="action" value="supprimer">Supprimer</button>
    </p>
</form>
