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
    require ('init.php');
    checkAcl('auth');
    include VIEWS_DIR . '/menu.php';

    $updateSuccessful = false;
    $deleteSuccessful = false;

    if (isset($_POST['idMotif'])) {
        $idMotif = $_POST['idMotif'];

        if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
            $libelleMotif = $_POST['libelleMotif'];

            $sql = "UPDATE motif SET libelleMotif = ? WHERE idMotif = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$libelleMotif, $idMotif]);

            $_SESSION['updateSuccess'] = true;
            $updateSuccessful = true;

        } elseif (isset($_POST['action']) && $_POST['action'] === 'supprimer') {
            $sql = "DELETE FROM motif WHERE idMotif = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$idMotif]);

            $_SESSION['deleteSuccess'] = true;
            $deleteSuccessful = true;
        } else {
            $sql = "SELECT * FROM motif WHERE idMotif = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$idMotif]);
            $motif = $stmt->fetch();
        }
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
    <form action="modifierMotif.php" method="post" name='monForm'>

        <!-- Champs du formulaire avec les informations à jour du motif -->
        <p>
            <input type="hidden" name="idMotif"
                value="<?php echo isset($motif['idMotif']) ? htmlspecialchars($motif['idMotif']) : ''; ?>">
        </p>

        <p>
            <label for="libelleMotif">Libellé du Motif:</label>
            <input type="text" id="libelleMotif" name="libelleMotif"
                value="<?php echo isset($motif['libelleMotif']) ? htmlspecialchars($motif['libelleMotif']) : ''; ?>">
        </p>

        <p>
            <a href="../">Page précédente</a>
            <button type="submit" name="action" value="modifier">Mettre à jour</button>
            <button type="submit" name="action" value="supprimer"
                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce motif ?')">Supprimer</button>
        </p>
    </form>
</body>
</html>
