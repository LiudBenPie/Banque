<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

$updateSuccessful = false;
$deleteSuccessful = false;

if (isset($_POST['idType'])) {
    $idType = $_POST['idType'];

    if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
        $nomType = $_POST['nomType'];
        $description = $_POST['description'];

        $sql = "UPDATE TypeCompte SET nomType = ?, description = ? WHERE idType = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nomType, $description, $idType]);

        $_SESSION['updateSuccess'] = true;
        $updateSuccessful = true; 

    } elseif (isset($_POST['action']) && $_POST['action'] === 'supprimer') {
        $sql = "DELETE FROM TypeCompte WHERE idType = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$idType]);

        $_SESSION['deleteSuccess'] = true;
        $deleteSuccessful = true;
    } else {
        $sql = "SELECT * FROM TypeCompte WHERE idType = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$idType]);
        $typeCompte = $stmt->fetch();
    }
}

// Affiche une alerte si la mise à jour a été réussie
if ($updateSuccessful) {
    echo '<script>alert("Les informations du type de compte ont été mises à jour avec succès.");</script>';
}

// Affiche une alerte si la suppression a été réussie
if ($deleteSuccessful) {
    echo '<script>alert("Le type de compte a été supprimé avec succès.");</script>';
}
?>
<!-- Formulaire pour la mise à jour et la suppression des informations du type de compte -->
<form action="modifierTypeCompte.php" method="post" name='monForm'>

    <!-- Champs du formulaire avec les informations à jour du type de compte -->
    <p>
        <label for="idType">ID Type de Compte :</label>
        <input type="hidden" name="idType" value="<?php echo isset($typeCompte['idType']) ? htmlspecialchars($typeCompte['idType']) : ''; ?>">
    </p>

    <p>
        <label for="nomType">Nom du Type de Compte :</label>
        <input type="text" id="nomType" name="nomType" value="<?php echo isset($typeCompte['nomType']) ? htmlspecialchars($typeCompte['nomType']) : ''; ?>">
    </p>

    <p>
        <label for="description">Description :</label>
        <textarea id="description" name="description"><?php echo isset($typeCompte['description']) ? htmlspecialchars($typeCompte['description']) : ''; ?></textarea>
    </p>
    
    <p>
        <a href="../">Page précédente</a>
        <button type="submit" name="action" value="modifier">Mettre à jour</button>
        <button type="submit" name="action" value="supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce type de compte ?')">Supprimer</button>
    </p>
</form>
