<?php
require('../init.php');
checkAcl('auth');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>rdv</title>
    <link rel="stylesheet" href="style_directeur.css">
</head>
<body>
    <div class="container">
        <a href="/logout.php">Deconnexion</a>
        <a href="/pages/newrdv.php">Creer rdv</a>
        <ul>
        <?php $sql = "SELECT distinct nom FROM rdv JOIN motif ON motif.idMotif=rdv.idMotif JOIN employe ON rdv.numEmploye=employe.numEmploye WHERE categorie = 'Conseiller'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $conseillers = $stmt->fetchAll();
        ?>
        <form action="../calendrier.php" method="post">
        <label for="conseiller">Sélectionnez le nom du conseiller :</label>
        <select name="conseiller" id="conseiller">
        <?php foreach ($conseillers as $conseiller): ?>
            <option value="<?php echo $conseiller['nom']; ?>">
                <?php echo $conseiller['nom'];?>
            </option>

        <?php endforeach; ?> 
        </select>
        <button type="submit">Modifier</button>
    </div>
</body>
</html>
