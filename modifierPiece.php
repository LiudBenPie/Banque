<?php
require('connect.php');

$updateSuccessful = false;

// Vérifie si le formulaire a été soumis
if (isset($_POST['action']) && $_POST['action'] === 'modifier' && isset($_POST['idMotif'])) {
    $idMotif = $_POST['idMotif'];
    $libelleMotif = $_POST['libelleMotif'];
    $listePieces = $_POST['listePieces'];

    // Prépare et exécute la requête SQL pour mettre à jour les informations du client
    $sql = "UPDATE Motif SET libelleMotif = ?, listePieces = ? WHERE idMotif = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$listePieces, $libelleMotif, $idMotif]);

    // Marque que la mise à jour a été réussie
    $updateSuccessful = true;
}

// Récupère les informations du client après la mise à jour ou si l'ID est spécifié
if (isset($_POST['idMotif'])) {
    $idMotif = $_POST['idMotif'];
    $sql = "SELECT * FROM Motif WHERE idMotif = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$idMotif]);
    $client = $stmt->fetch();
}

// Affiche une alerte si la mise à jour a été réussie
if ($updateSuccessful) {
    echo '<script>alert("Les informations du client ont été mises à jour avec succès.");</script>';
}
?>

<!-- Formulaire pour la mise à jour des informations du client -->
<form action="modifierPiece.php" method="post" name='monForm'>
    <fieldset><legend>INFORMATION DU MOTIF</legend>
        <!-- Champs du formulaire avec les informations à jour du client -->
        <p>
            <label for="idMotif">ID Motif :</label>
            <input type="text" name="idMotif" value="<?php echo htmlspecialchars($client['idMotif'] ?? ''); ?>" readonly>
        </p>
        <p>
            <label for="libelle">Libelle :</label>
            <input type="text" id="libelle" name="libelle" value="<?php echo htmlspecialchars($client['libelleMotif'] ?? ''); ?>">
        </p>
        <p>
            <label for="listePieces">Liste dee Pièces:</label>
            <input type="text" id="listePieces" name="listePieces" value="<?php echo htmlspecialchars($client['listePieces'] ?? ''); ?>">
        </p>
        <p>
            <button type="submit" name="action" value="modifier">Mettre à jour</button>
        </p>
    </fieldset>
</form>
