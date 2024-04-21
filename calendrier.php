<?php
require('init.php');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="style.css">
	<title>Calendrier des examens</title>
</head>

<body>
	<?php
	include VIEWS_DIR . '/menu.php';
	?>

	<div class="container">
		<ul>
			<?php $sql = "SELECT distinct nom FROM rdv JOIN motif ON motif.idMotif=rdv.idMotif JOIN employe ON rdv.numEmploye=employe.numEmploye WHERE categorie = 'Conseiller'";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$conseillers = $stmt->fetchAll();
			?>
			<form action="/calendrier.php" method="get">
				<label for="nom">Sélectionnez le nom du conseiller :</label>
				<select name="nom" id="nom">
					<?php foreach ($conseillers as $conseiller) : ?>
						<option value="<?php echo $conseiller['nom']; ?>">
							<?php echo $conseiller['nom'] ?>
						</option>

					<?php endforeach; ?>
				</select>
				<button type="submit">Modifier</button>
	</div>
	<?php
	require_once('init.php');
	$nom = $_GET['nom']??NULL;

	try {

		echo '<table><tr><th colspan="7">CALENDRIER</th></tr>';
		echo '<tr>';
		for ($i = 1; $i <= 35; $i++) {
			if ($i <= 31) {
				// la première requête permet de revenir à la ligne tout les 7 jours (7,14,21,28)
				if ($i % 7 == 0) {
					$req = "select  timeRdv, libelleMotif from rdv join motif on rdv.idmotif=motif.idmotif join employe on employe.numEmploye=rdv.numEmploye where DAYOFMONTH(dateRdv) = $i and nom = '$nom'";
					$res = $conn->query($req);
					$res->setFetchMode(PDO::FETCH_OBJ);
					$ligne = $res->fetch();
					if ($ligne == false) {
						echo '<td>' . $i . '</td>';
					} else {
						echo '<td>' . $i . '  ' . $ligne->timeRdv . ' minutes   ' . $ligne->libelleMotif . '</td></br>';
					}
					echo '</br></tr>';
				} else {
					// La deuxième requête va prendre tout les autres valeurs de $i
					$req = "select  timeRdv, libelleMotif from rdv join motif on rdv.idmotif=motif.idmotif join employe on employe.numEmploye=rdv.numEmploye where DAYOFMONTH(dateRdv) = $i and nom = '$nom'";
					$res = $conn->query($req);
					$res->setFetchMode(PDO::FETCH_OBJ);
					$ligne = $res->fetch();
					if ($ligne == false) {
						echo '<td>' . $i . '</td>';
					} else {
						echo '<td>' . $i . '  ' . $ligne->timeRdv . ' minutes   ' . $ligne->libelleMotif . '</td></br>';
					}
				}
			} else {
				echo '<td></td>';
			}
		}
		echo '</tr>';
		$res->closeCursor();
	} catch (PDOException $e) {
		$msg = 'ERREUR dans ' . $e->getFile() . 'Ligne' . $e->getLine() . ':' . $e->getMessage();
	}

	?>
	</table>
</body>

</html>