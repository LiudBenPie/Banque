<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

$createSuccessful = false;

if (isset($_POST['action']) && !empty($_POST['nomCompte'])) {
    $nomCompte = $_POST['nomCompte'];
    $description = $_POST['description'];
    $sql = "INSERT INTO typecompte (nomType,description) VALUES (?,?)";
    $res = $conn->prepare($sql);
    if ($res->execute([$nomCompte,$description])) {
        $createSuccessful = true;
    }
}
// Affiche une alerte si la création a été réussie
if ($createSuccessful) {
    echo '<script>alert("Le type de compte a été crée avec succès.");</script>';
}
?>
<!-- Formulaire pour la création du contrat -->
<form action="créerCompte.php" method="post" name='monForm'>
    <p>
        <label for="nom">Nom du type de compte :</label>
        <input type="text" name="nomCompte" required>
    </p>
        <label for="description">Description : </label>
        <input type="textarea" name="description" required>
    <p>
        <a href="../">Page précédente</a>
        <button type="submit" name="action" value="Créer">Créer</button>
    </p>
</form>