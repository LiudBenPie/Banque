<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';
$updateSuccessful = false;

// Vérifie si le formulaire a été soumis
if (isset($_POST['action']) && $_POST['action'] === 'modifier' && isset($_POST['idMotif'])) {
    $idMotif = $_POST['idMotif'];
    $libelleMotif = $_POST['libelleMotif'];
    $listePieces = $_POST['listePieces'];

    // Prépare et exécute la requête SQL pour mettre à jour les informations du motif
    $sql = "UPDATE motif SET libelleMotif = ?, listePieces = ? WHERE idMotif = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$libelleMotif, $listePieces, $idMotif]);

    // Marque que la mise à jour a été réussie
    $updateSuccessful = true;
}

// Récupère les informations du motif après la mise à jour ou si l'ID est spécifié
if (isset($_POST['idMotif'])) {
    $idMotif = $_POST['idMotif'];
    $sql = "SELECT * FROM motif WHERE idMotif = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$idMotif]);
    $motif = $stmt->fetch();
}

// Affiche une alerte si la mise à jour a été réussie
if ($updateSuccessful) {
    echo '<script>alert("Les informations du motif ont été mises à jour avec succès.");</script>';
}
?>

<!-- Formulaire pour la mise à jour des informations du client -->
<form action="modifierPiece.php" method="post" name='monForm'>
    <fieldset>
        <legend>INFORMATION DU MOTIF</legend>
        <!-- Champs du formulaire avec les informations à jour du client -->
        <p>
            <label for="idMotif">ID Motif :</label>
            <input type="text" name="idMotif" value="<?php echo htmlspecialchars($motif['idMotif'] ?? ''); ?>" readonly>
        </p>
        <p>
            <label for="libelle">Libelle :</label>
            <input type="text" id="libelleMotif" name="libelleMotif" value="<?php echo htmlspecialchars($motif['libelleMotif'] ?? ''); ?>" readonly>
        </p>
        <p>
            <label for="listePieces">Liste des Pièces:</label>
            <input type="text" id="listePieces" name="listePieces" value="<?php echo htmlspecialchars($motif['listePieces'] ?? ''); ?>">
        </p>
        <p>
            <button><a href="../">Page précédente</a></button>
            <button type="submit" name="action" value="modifier">Mettre à jour</button>
        </p>
    </fieldset>
</form>