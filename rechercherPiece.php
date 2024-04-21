<?php
require('init.php');
checkAcl('auth');
// Récupération de la liste des clients
$sql = "SELECT idMotif, libelleMotif, listePieces FROM motif";
$stmt = $conn->prepare($sql);
$stmt->execute();
$motifs = $stmt->fetchAll();
?>
<form action="modifierPiece.php" method="post">
    <label for="client">Sélectionnez le motif à modifier :</label>
    <select name="idMotif" id="motif">
        <?php foreach ($motifs as $motif) : ?>
            <option value="<?php echo $motif['idMotif']; ?>">
                <?php echo $motif['libelleMotif'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Modifier</button>
</form>