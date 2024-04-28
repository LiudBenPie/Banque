<?php
require('../init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';
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
        <form action="/sauvegarderRdv.php" method="post">
            <fieldset class="border">
                <legend>Créer un Nouveau RDV</legend>
                <p>
                    <label for="dateRdv">Date du RDV:</label>
                    <input type="date" id="dateRdv" name="dateRdv" required>
                </p>
                <p>
                    <label for="heureRdv">Heure de RDV :</label>
                    <input type="number" id="heureRdv" name="heureRdv" min="7" max="19" required>
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