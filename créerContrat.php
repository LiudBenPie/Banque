<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

$createSuccessful = false;

if (isset($_POST['action']) && !empty($_POST['nomContrat'])) {
    $nomContrat = $_POST['nomContrat'];
    $sql = "INSERT INTO contrat (nomContrat) VALUES (?)";
    $res = $conn->prepare($sql);
    if ($res->execute([$nomContrat])) {
        $createSuccessful = true;
    }
}
// Affiche une alerte si la création a été réussie
if ($createSuccessful) {
    echo '<script>alert("Le type de contrat a été crée avec succès.");</script>';
}
?>
<!-- Formulaire pour la création du contrat -->
<form action="créerContrat.php" method="post" name='monForm'>
    <p>
        <label for="nom">Nom du contrat :</label>
        <input type="text" name="nomContrat" required>
    </p>
    <p>
        <a href="../">Page précédente</a>
        <button type="submit" name="action" value="Créer">Créer</button>
    </p>
</form>