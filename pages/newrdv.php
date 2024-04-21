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
    <?php
    include VIEWS_DIR . '/menu.php';
    ?>
    <div class="container">
        <form action="/sauvegarderRdv.php" method="post">
            <fieldset class="border">
                <legend>Créer un Nouveau RDV</legend>
                <p>
                    <label for="dateRdv">Date du RDV:</label>
                    <input type="datetime-local" id="dateRdv" name="dateRdv" required>
                </p>
                <p>
                    <label for="timeRdv">Durée de RDV (en minutes):</label>
                    <input type="number" id="timeRdv" name="timeRdv" min="0" max="120" required>
                </p>
                <p>
                    <label for="numEmploye">Numero du Conseiller :</label>
                    <select name="numEmploye" id="numEmploye">
                        <?php
                        $sql = "SELECT numEmploye, nom FROM employe WHERE categorie = 'Conseiller'";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $conseillers = $stmt->fetchAll();
                        ?>
                        <?php foreach ($conseillers as $conseiller) : ?>
                            <option value="<?php echo $conseiller['numEmploye']; ?>">
                                <?php echo $conseiller['numEmploye'] . ' ' . $conseiller['nom'] ?>
                            </option>

                        <?php endforeach; ?>
                    </select>
                </p>
                <div>
                    <label for="idMotif">Motif du RDV:</label>
                    <select id="idMotif" name="idMotif" required>
                        <option value="">Sélectionner un motif</option>
                        <?php $sql = "SELECT * FROM motif";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $motifs = $stmt->fetchAll();
                        ?>
                        <?php foreach ($motifs as $motif) : ?>
                            <option value="<?php echo $motif['idMotif']; ?>">
                                <?php echo $motif['libelleMotif'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit">Planifier RDV</button>
            </fieldset>
        </form>
    </div>
</body>

</html>