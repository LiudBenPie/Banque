<?php
require('init.php'); // Assurez-vous que init.php configure correctement PDO
include VIEWS_DIR . '/menu.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Calendrier des examens</title>
</head>

<body>
    <div class="container">
        <?php
        $moisFrancais = [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
            5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
            9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
        ];

        $joursFrancais = [
            1 => 'Lun', 2 => 'Mar', 3 => 'Mer', 4 => 'Jeu',
            5 => 'Ven', 6 => 'Sam', 7 => 'Dim'
        ];

        $sql = "SELECT DISTINCT nom FROM rdv JOIN motif ON motif.idMotif = rdv.idMotif JOIN employe ON rdv.numEmploye = employe.numEmploye WHERE categorie = 'Conseiller'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $conseillers = $stmt->fetchAll();

        $selectedNom = $_GET['nom'] ?? '';
        $selectedMois = $_GET['mois'] ?? date('m');
        $selectedAnnee = $_GET['annee'] ?? date('Y');
        ?>

        <form action="/calendrier.php" method="get" class="selection-form">
            <label for="nom">Sélectionnez le nom du conseiller :</label>
            <select name="nom" id="nom">
                <?php foreach ($conseillers as $conseiller) : ?>
                    <option value="<?= htmlspecialchars($conseiller['nom']); ?>" <?= $conseiller['nom'] === $selectedNom ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($conseiller['nom']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="mois">Sélectionnez le mois :</label>
            <select name="mois" id="mois">
                <?php for ($m = 1; $m <= 12; $m++) : ?>
                    <option value="<?= $m; ?>" <?= (int)$m === (int)$selectedMois ? 'selected' : ''; ?>>
                        <?= $moisFrancais[$m]; ?>
                    </option>
                <?php endfor; ?>
            </select>

            <label for="annee">Sélectionnez l'année :</label>
            <select name="annee" id="annee">
                <?php for ($y = date('Y') - 5; $y <= date('Y') + 5; $y++) : ?>
                    <option value="<?= $y; ?>" <?= $y === (int)$selectedAnnee ? 'selected' : ''; ?>>
                        <?= $y; ?>
                    </option>
                <?php endfor; ?>
            </select>

            <button type="submit">Modifier</button>
        </form>
    </div>

    <?php
    $nom = $_GET['nom'] ?? '';  // Éviter l'avis d'indice non défini
    $mois = $_GET['mois'] ?? date('m');  // Par défaut, utiliser le mois en cours
    $annee = $_GET['annee'] ?? date('Y');  // Par défaut, utiliser l'année en cours

    // Trouver le jour de la semaine du premier jour du mois
    $premierJourTimestamp = strtotime("$annee-$mois-01");
    $jourDeLaSemaine = date('N', $premierJourTimestamp);

    echo '<table><tr><th colspan="7">CALENDRIER</th></tr><tr>';
    foreach ($joursFrancais as $jour) {
        echo "<th class='jour'>$jour</th>";
    }
    echo '</tr><tr>';

    // Ajoutez des cellules vides pour les jours précédant le premier jour du mois
    for ($i = 1; $i < $jourDeLaSemaine; $i++) {
        echo '<td></td>';
    }

    $nb_jours = cal_days_in_month(CAL_GREGORIAN, $mois, $annee);

    // Afficher les jours du mois
    for ($jour = 1; $jour <= $nb_jours; $jour++) {
        $date = sprintf("%04d-%02d-%02d", $annee, $mois, $jour);
        echo "<td data-date='{$date}' class='date-cell'>$jour</td>";
        if (($jour + $jourDeLaSemaine - 1) % 7 == 0) {
            echo '</tr><tr>';
        }
    }

    // Ajoutez des cellules vides pour compléter la dernière semaine
    $dernierJourTimestamp = strtotime("$annee-$mois-$nb_jours");
    $dernierJourDeLaSemaine = date('N', $dernierJourTimestamp);
    for ($i = $dernierJourDeLaSemaine + 1; $i <= 7; $i++) {
        echo '<td></td>';
    }

    echo '</tr></table>';
    ?>
</body>

</html>
