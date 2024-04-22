<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

$updateSuccessful = false;

if (isset($_POST['numContrat'])) {
    $numContrat = $_POST['numContrat'];

    if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
        $nomContrat = $_POST['nomContrat'];

        $sql = "UPDATE contrat SET nomContrat = ? WHERE numContrat = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nomContrat, $numContrat]);

        $_SESSION['updateSuccess'] = true;
        $updateSuccessful = true; 

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
?>
<!-- Formulaire pour la mise à jour des informations du contrat -->
<form action="modifierContrat.php" method="post" name='monForm'>

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
    </p>
</form>
