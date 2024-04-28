<?php
require('init.php'); // Ensure init.php sets up PDO correctly
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
    <ul>
        <?php
        $sql = "SELECT DISTINCT nom FROM rdv JOIN motif ON motif.idMotif = rdv.idMotif JOIN employe ON rdv.numEmploye = employe.numEmploye WHERE categorie = 'Conseiller'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $conseillers = $stmt->fetchAll();

        $selectedNom = $_GET['nom'] ?? '';
        $selectedMois = $_GET['mois'] ?? date('m');
        $selectedAnnee = $_GET['annee'] ?? date('Y');
        ?>

        <form action="/calendrier.php" method="get">
            <label for="nom">Sélectionnez le nom du conseiller :</label>
            <select name="nom" id="nom">
                <?php foreach ($conseillers as $conseiller): ?>
                    <option value="<?= htmlspecialchars($conseiller['nom']); ?>"
                        <?= $conseiller['nom'] === $selectedNom ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($conseiller['nom']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="mois">Sélectionnez le mois :</label>
            <select name="mois" id="mois">
                <?php for ($m = 1; $m <= 12; $m++): ?>
                    <option value="<?= $m; ?>"
                        <?= (int)$m === (int)$selectedMois ? 'selected' : ''; ?>>
                        <?= date('F', mktime(0, 0, 0, $m, 10)); ?>
                    </option>
                <?php endfor; ?>
            </select>

            <label for="annee">Sélectionnez l'année :</label>
            <select name="annee" id="annee">
                <?php for ($y = date('Y') - 5; $y <= date('Y') + 5; $y++): ?>
                    <option value="<?= $y; ?>"
                        <?= $y === (int)$selectedAnnee ? 'selected' : ''; ?>>
                        <?= $y; ?>
                    </option>
                <?php endfor; ?>
            </select>

            <button type="submit">Modifier</button>
        </form>
    </ul>
</div>

<?php
echo '<table><tr><th colspan="7">CALENDRIER</th></tr><tr>';
$nom = $_GET['nom'] ?? '';  // Prevent undefined index notice
$mois = $_GET['mois'] ?? date('m');  // Default to current month
$annee = $_GET['annee'] ?? date('Y');  // Default to current year

$nb_jours = cal_days_in_month(CAL_GREGORIAN, $mois, $annee);

$sql = "SELECT dateRdv, heureRdv, libelleMotif FROM rdv JOIN employe ON rdv.numEmploye = employe.numEmploye JOIN motif ON rdv.idMotif = motif.idMotif WHERE YEAR(dateRdv) = :year AND MONTH(dateRdv) = :month AND nom = :nom";
$stmt = $conn->prepare($sql);
$stmt->execute(['year' => $annee, 'month' => $mois, 'nom' => $nom]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

$eventsByDay = [];
foreach ($events as $event) {
    $day = (int)substr($event['dateRdv'], 8, 2);
    $eventsByDay[$day][] = $event['heureRdv'] . ' - ' . $event['libelleMotif'];
}

for ($i = 1; $i <= 35; $i++) {
    if ($i <= $nb_jours) {
        $date = sprintf("%04d-%02d-%02d", $annee, $mois, $i);
        echo "<td data-date='{$date}' class='date-cell'>";
        echo $i;

        if (array_key_exists($i, $eventsByDay)) {
            echo "<ul>";
            foreach ($eventsByDay[$i] as $eventDetail) {
                echo "<li>" . htmlspecialchars($eventDetail) . "</li>";
            }
            echo "</ul>";
        }

        echo "</td>";
        if ($i % 7 == 0) echo '</tr><tr>';
    } else {
        echo '<td></td>';
    }
}
echo '</tr></table>';
?>
</body>
</html>
