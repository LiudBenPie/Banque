<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

$updateSuccessful = false;
$deleteSuccessful = false;

if (isset($_POST['idCompte'])) {
    $idCompte = $_POST['idCompte'];

    if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
        $nomCompte = $_POST['nomCompte'];

        $sql = "UPDATE compte SET nomCompte = ? WHERE idCompte = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nomCompte, $idCompte]);

        $_SESSION['updateSuccess'] = true;
        $updateSuccessful = true; 

    } elseif (isset($_POST['action']) && $_POST['action'] === 'supprimer') {
        $sql = "DELETE FROM compte WHERE idCompte = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$idCompte]);

        $_SESSION['deleteSuccess'] = true;
        $deleteSuccessful = true;
    } else {
        $sql = "SELECT * FROM compte WHERE idCompte = ?";
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
    echo '<script>alert("Le compte a été supprimé avec succès.");</script>';
}
?>
<!-- Formulaire pour la mise à jour et la suppression des informations du compte -->
<form action="modifierCompte.php" method="post" name='monForm'>

    <!-- Champs du formulaire avec les informations à jour du compte -->
    <p>
        <label for="idCompte">ID Compte :</label>
        <input type="hidden" name="idCompte" value="<?php echo isset($compte['idCompte']) ? htmlspecialchars($compte['idCompte']) : ''; ?>">
    </p>

    <p>
        <label for="nomCompte">Nom du Compte:</label>
        <input type="text" id="nomCompte" name="nomCompte" value="<?php echo isset($compte['nomCompte']) ? htmlspecialchars($compte['nomCompte']) : ''; ?>">
    </p>
    
    <p>
        <a href="../">Page précédente</a>
        <button type="submit" name="action" value="modifier">Mettre à jour</button>
        <button type="submit" name="action" value="supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce compte ?')">Supprimer</button>
    </p>
</form>
