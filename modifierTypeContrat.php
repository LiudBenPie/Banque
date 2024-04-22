<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

$updateSuccessful = false;
$deleteSuccessful = false;

if (isset($_POST['numContrat'])) {
    $numContrat = $_POST['numContrat'];

    if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
        $nomContrat = $_POST['nomContrat'];

        $sql = "UPDATE contrat SET nomContrat = ? WHERE numContrat = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nomContrat, $numContrat]);

        $_SESSION['updateSuccess'] = true;
        $updateSuccessful = true; 

    } elseif (isset($_POST['action']) && $_POST['action'] === 'supprimer') {
        $sql = "DELETE FROM contrat WHERE numContrat = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$numContrat]);

        $_SESSION['deleteSuccess'] = true;
        $deleteSuccessful = true;
    } else {
        $sql = "SELECT * FROM contrat WHERE numContrat = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$numContrat]);
        $contrat = $stmt->fetch();
    }
}

// Affiche une alerte si la mise à jour a été réussie
if ($updateSuccessful) {
    echo '<script>alert("Les informations du contrat ont été mises à jour avec succès.");</script>';
}

// Affiche une alerte si la suppression a été réussie
if ($deleteSuccessful) {
    echo '<script>alert("Le contrat a été supprimé avec succès.");</script>';
}
?>
<!-- Formulaire pour la mise à jour et la suppression des informations du contrat -->
<form action="modifierTypeContrat.php" method="post" name='monForm'>

    <!-- Champs du formulaire avec les informations à jour du contrat -->
    <p>
        <label for="num">ID Contrat :</label>
        <input type="hidden" name="numContrat" value="<?php echo isset($contrat['numContrat']) ? htmlspecialchars($contrat['numContrat']) : ''; ?>">
    </p>

    <p>
        <label for="nomContrat">Nom du Contrat:</label>
        <input type="text" id="nomContrat" name="nomContrat" value="<?php echo isset($contrat['nomContrat']) ? htmlspecialchars($contrat['nomContrat']) : ''; ?>">
    </p>
    
    <p>
        <a href="../">Page précédente</a>
        <button type="submit" name="action" value="modifier">Mettre à jour</button>
        <button type="submit" name="action" value="supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce contrat ?')">Supprimer</button>
    </p>
</form>
