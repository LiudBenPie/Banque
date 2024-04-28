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
		<?php
		$moisFrancais = [
			1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
			5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
			9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
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
	echo '<table><tr><th colspan="7">CALENDRIER</th></tr><tr><tr>
	<th class="jour">Lun</th> <!-- Lundi -->
	<th class="jour">Mar</th> <!-- Mardi -->
	<th class="jour">Mer</th> <!-- Mercredi -->
	<th class="jour">Jeu</th> <!-- Jeudi -->
	<th class="jour">Ven</th> <!-- Vendredi -->
	<th class="jour">Sam</th> <!-- Samedi -->
	<th class="jour">Dim</th> <!-- Dimanche -->
	</tr>';
	$nom = $_GET['nom'] ?? '';  // Prevent undefined index notice
	$mois = $_GET['mois'] ?? date('m');  // Default to current month
	$annee = $_GET['annee'] ?? date('Y');  // Default to current year

	$nb_jours = cal_days_in_month(CAL_GREGORIAN, $mois, $annee);

	$sql = "SELECT rdv.dateRdv, rdv.heureRdv, Motif.libelleMotif, Client.nom AS nomClient, Client.prenom AS prenomClient FROM rdv JOIN Employe ON rdv.numEmploye = Employe.numEmploye JOIN Client ON Client.numClient = rdv.numClient JOIN Motif ON rdv.idMotif = Motif.idMotif WHERE YEAR(rdv.dateRdv) = :year AND MONTH(rdv.dateRdv) = :month AND Employe.nom = :nom";
	$stmt = $conn->prepare($sql);
	$stmt->execute(['year' => $annee, 'month' => $mois, 'nom' => $nom]);
	$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$eventsByDay = [];
	foreach ($events as $event) {
		$day = (int)substr($event['dateRdv'], 8, 2);
		$eventsByDay[$day][] = $event['heureRdv'] . ':00 ' . $event['libelleMotif'] . ' avec ' . $event['nomClient'] . ' ' . $event['prenomClient'];
	}

	for ($i = 1; $i <= 35; $i++) {
		if ($i <= $nb_jours) {
			$date = sprintf("%04d-%02d-%02d", $annee, $mois, $i);
			echo "<td data-date='{$date}' class='date-cell'>";
			echo $i;

			if (array_key_exists($i, $eventsByDay)) {
				echo "<ul class='event-list'>";
				foreach ($eventsByDay[$i] as $eventDetail) {
					echo "<li class='event-item'>" . htmlspecialchars($eventDetail) . "</li>";
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