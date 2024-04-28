<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Type Compte</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    require ('init.php');
    checkAcl('auth');
    include VIEWS_DIR . '/menu.php';

    $updateSuccessful = false;
    $deleteSuccessful = false;

    if (isset($_POST['idCompte'])) {
        $idCompte = $_POST['idCompte'];

        if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
            $nomTypeCompte = $_POST['nomTypeCompte'];

            $sql = "UPDATE Compte SET nomTypeCompte = ? WHERE idCompte = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$nomTypeCompte, $idCompte]); 

            $_SESSION['updateSuccess'] = true;
            $updateSuccessful = true;


        } elseif (isset($_POST['action']) && $_POST['action'] === 'supprimer') {
            $sql = "DELETE FROM Compte WHERE idCompte = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$idCompte]);

            $_SESSION['deleteSuccess'] = true;
            $deleteSuccessful = true;
        } else {
            $sql = "SELECT * FROM Compte WHERE idCompte = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$idCompte]);
            $compte = $stmt->fetch();
        }
    }

    // Affiche une alerte si la mise à jour a été réussie
    if ($updateSuccessful) {
        echo '<script>alert("Les informations du compte ont été mises à jour avec succès.");</script>';
    }

    // Affiche une alerte si la suppression a été réussie
    if ($deleteSuccessful) {
        echo '<script>alert("Le type de compte a été supprimé avec succès.");</script>';
    }
    ?>
    <!-- Formulaire pour la mise à jour et la suppression des informations du compte -->
    <form action="modifierTypeCompte.php" method="post" name='monForm'>

        <!-- Champs du formulaire avec les informations à jour du compte -->
        <p>
            <input type="hidden" name="idCompte"
                value="<?php echo isset($compte['idCompte']) ? htmlspecialchars($compte['idCompte']) : ''; ?>">
        </p>

        <p>
            <label for="nomTypeCompte">Nom du Compte:</label>
            <input type="text" id="nomTypeCompte" name="nomTypeCompte"
                value="<?php echo isset($compte['nomTypeCompte']) ? htmlspecialchars($compte['nomTypeCompte']) : ''; ?>">
        </p>

        <p>
            <a href="../">Page précédente</a>
            <button type="submit" name="action" value="modifier">Mettre à jour</button>
            <button type="submit" name="action" value="supprimer"
                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce type de compte ?')">Supprimer</button>
        </p>
    </form>
</body>
