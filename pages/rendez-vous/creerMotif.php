<?php
require('../../init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

$createSuccessful = false;

if (isset($_POST['action']) && !empty($_POST['libellemotif']) && !empty($_POST['listepiece'])) {
    $libellemotif = $_POST['libellemotif'];
    $listepiece= $_POST['listepiece'];
    $sql = "INSERT INTO motif (libelleMotif,listePieces) VALUES (?,?)";
    $res = $conn->prepare($sql);
    if ($res->execute([$libellemotif,$listepiece])) {
        $createSuccessful = true;
    }
}
// Affiche une alerte si la création a été réussie
if ($createSuccessful) {
    echo '<script>alert("Le nouveau motif a été crée avec succès.");</script>';
}
?>
<!-- Formulaire pour la création du contrat -->
<form action="creerMotif.php" method="post" name='monForm'>
    <p>
        <label for="libellemotif">Libelle du motif :</label>
        <input type="text" name="libellemotif" required>
    </p>
    <p>
        <label for="listepiece">Liste des pièces : </label>
        <input type="textarea" name="listepiece" required>
    </p>
    <p>
        <button type="submit" name="action" value="Créer">Créer le motif</button>
    </p>
</form>