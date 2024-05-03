<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Motif</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    require('../../init.php'); // Assurez-vous que init.php inclut la configuration de la base de données ($conn)
    checkAcl('auth');
    include VIEWS_DIR . '/menu.php';

    $updateSuccessful = false;
    $deleteSuccessful = false;
    if (isset($_POST['numRdv'])) {
        $numRdv = $_POST['numRdv'];

        if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
            $dateRdv = $_POST['dateRdv'];
            $heureRdv = $_POST['heureRdv'];
            $numEmploye = $_POST['numEmploye'];
            $idMotif = $_POST['idMotif'];
            $numClient = $_POST['numClient'];

            $sql = "UPDATE rdv SET dateRdv = ?, heureRdv = ?,numEmploye = ?, idMotif = ?, numClient = ? WHERE numRdv = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$dateRdv, $heureRdv, $numEmploye, $idMotif, $numClient]);

            $_SESSION['updateSuccess'] = true;
            $updateSuccessful = true;

        } elseif (isset($_POST['action']) && $_POST['action'] === 'supprimer') {
            $sql = "DELETE FROM rdv WHERE numRdv = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$idMotif]);

            $_SESSION['deleteSuccess'] = true;
            $deleteSuccessful = true;
        }

        // Sélectionner à nouveau le motif après la mise à jour ou la suppression
        $sql = "SELECT * FROM motif WHERE idMotif = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$idMotif]);
        $motif = $stmt->fetch();
    }

    // Affiche une alerte si la mise à jour a été réussie
    if ($updateSuccessful) {
        echo '<script>alert("Les informations du motif ont été mises à jour avec succès.");</script>';
    }

    // Affiche une alerte si la suppression a été réussie
    if ($deleteSuccessful) {
        echo '<script>alert("Le motif a été supprimé avec succès.");</script>';
    }
    ?>
    <!-- Formulaire pour la mise à jour et la suppression des informations du motif -->
    <form action="modifierPiece.php" method="post" name='monForm'>

        <!-- Champs du formulaire avec les informations à jour du motif -->
        <p>
            <input type="hidden" name="numRdv"
                value="<?php echo isset($motif['numRdv']) ? htmlspecialchars($motif['numRdv']) : ''; ?>">
        </p>

        <p>
            <label for="libelleMotif">Libellé du Motif:</label>
            <input type="text" id="libelleMotif" name="libelleMotif"
                value="<?php echo isset($motif['libelleMotif']) ? htmlspecialchars($motif['libelleMotif']) : ''; ?>">
        </p>
        <p>
            <label for="listePieces">Liste des Pièces:</label>
            <input type="text" id="listePieces" name="listePieces"
                value="<?php echo isset($motif['listePieces']) ? htmlspecialchars($motif['listePieces']) : ''; ?>">
        </p>

        <p>
            <a href="../..">Page précédente</a>
            <button type="submit" name="action" value="modifier">Mettre à jour</button>
            <button type="submit" name="action" value="supprimer"
                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce motif ?')">Supprimer</button>
        </p>
    </form>
</body>

</html>