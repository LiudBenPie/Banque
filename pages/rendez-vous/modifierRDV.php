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
    require('../../init.php');
    checkAcl('auth');
    include VIEWS_DIR . '/menu.php';

    $updateSuccessful = false;
    $deleteSuccessful = false;

    // Récupération de la liste des motifs
    $sql = "SELECT idMotif, libelleMotif FROM motif";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $motifs = $stmt->fetchAll();

    if (isset($_POST['numRdv'])) {
        $numRdv = $_POST['numRdv'];

        if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
            $dateRdv = $_POST['dateRdv'];
            $heureRdv = $_POST['heureRdv'];
            $numEmploye = $_POST['numEmploye'];
            $idMotif = $_POST['idMotif'];
            $numClient = $_POST['numClient'];

            // Mise à jour du rendez-vous
            $sql = "UPDATE rdv SET dateRdv = ?, heureRdv = ?, numEmploye = ?, idMotif = ?, numClient = ? WHERE numRdv = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$dateRdv, $heureRdv, $numEmploye, $idMotif, $numClient, $numRdv]); // Ajoutez $numRdv à la fin

            $_SESSION['updateSuccess'] = true;
            $updateSuccessful = true;

        } elseif (isset($_POST['action']) && $_POST['action'] === 'supprimer') {
            // Suppression du rendez-vous
            $sql = "DELETE FROM rdv WHERE numRdv = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$numRdv]); // Assurez-vous que $numRdv est correctement défini

            $_SESSION['deleteSuccess'] = true;
            $deleteSuccessful = true;
        }

        // Sélectionner à nouveau le rendez-vous après la mise à jour ou la suppression
        $sql = "SELECT * FROM rdv WHERE numRdv = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$numRdv]);
        $Rdv = $stmt->fetch();
    }

    // Affiche une alerte si la mise à jour a été réussie
    if ($updateSuccessful) {
        echo '<script>alert("Le rendez-vous a été mis à jour avec succès.");</script>';
    }

    // Affiche une alerte si la suppression a été réussie
    if ($deleteSuccessful) {
        echo '<script>alert("Le rendez-vous a été supprimé avec succès.");</script>';
    }
    ?>
    <!-- Formulaire pour la mise à jour et la suppression des informations du rendez-vous -->
    <form action="modifierRDV.php" method="post" name='monForm'>

        <!-- Champs du formulaire avec les informations à jour du rendez-vous -->
        <p>
            <input type="hidden" name="numRdv" value="<?php echo isset($Rdv['numRdv']) ? htmlspecialchars($Rdv['numRdv']) : ''; ?>">
        </p>

        <p>
            <label for="dateRdv">Date du rendez-vous :</label>
            <input type="date" id="dateRdv" name="dateRdv" value="<?php echo isset($Rdv['dateRdv']) ? htmlspecialchars($Rdv['dateRdv']) : ''; ?>">
        </p>
        <p>
            <label for="heureRdv">Heure du rendez-vous :</label>
            <input type="number" id="heureRdv" name="heureRdv" value="<?php echo isset($Rdv['heureRdv']) ? htmlspecialchars($Rdv['heureRdv']) : ''; ?>">
        </p>
        <p>
            <label for="numEmploye">Employé pour le rendez-vous :</label>
            <input type="number" id="numEmploye" name="numEmploye" value="<?php echo isset($Rdv['numEmploye']) ? htmlspecialchars($Rdv['numEmploye']) : ''; ?>">
        </p>
        <p>
            <label for="idMotif">Sélectionnez le motif :</label>
            <select name="idMotif" id="idMotif">
                <?php foreach ($motifs as $motif) : ?>
                    <option value="<?php echo $motif['idMotif']; ?>" <?php if (isset($Rdv['idMotif']) && $Rdv['idMotif'] == $motif['idMotif']) echo 'selected'; ?>>
                        <?php echo $motif['libelleMotif'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="numClient">Client du rendez-vous :</label>
            <input type="number" id="numClient" name="numClient" value="<?php echo isset($Rdv['numClient']) ? htmlspecialchars($Rdv['numClient']) : ''; ?>">
        </p>
        <p>
            <a href="../..">Page précédente</a>
            <button type="submit" name="action" value="modifier">Mettre à jour</button>
            <button type="submit" name="action" value="supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rendez-vous ?')">Supprimer</button>
        </p>
    </form>
</body>

</html>
