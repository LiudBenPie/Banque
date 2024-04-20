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
        <a href="/pages/newrdv.php">Create rdv</a>
        <ul>
        <?php $sql = "SELECT * FROM rdv JOIN motif ON motif.idMotif=rdv.idMotif JOIN employe ON rdv.numEmploye=employe.numEmploye";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $rdvs = $stmt->fetchAll();
                    ?>
                    <?php foreach ($rdvs as $rdv): ?>
                        <li>
                            <?php echo $rdv['numRdv']?>
                            <?php echo $rdv['libelleMotif']?>
                            <?php echo $rdv['nom']?>
                        </li>
                    <?php endforeach; ?> 
        </ul>
    </div>
    <a href="/logout.php">Deconnexion</a>
</body>
</html>
