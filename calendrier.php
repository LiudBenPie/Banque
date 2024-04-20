<!DOCTYPE html>
<html lang="fr">
 		<head>
   			 <meta charset="utf-8">
   			 <link rel="stylesheet" href="style.css">
   			 <title>Calendrier des examens</title>
        </head>
 	    <body>

		 <form action="calendrier.php" method="post" name='monForm'>
			<p>
				<label for="nom"></label>
				<input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($conseilleur['nom'] ?? ''); ?>">
			</p>

			<p>
				<button type="submit" name="action" value="modifier">Mettre à jour</button>
			</p>
		</form>
		<?php
		require_once('init.php');
		$nom = $_POST['nom'];

		try{

		echo '<table><tr><th colspan="7">CALENDRIER</th></tr>';
	    echo '<tr>';
			for ($i = 1; $i <= 35; $i++) {
				if ($i <= 31) {
					// la première requête permet de revenir à la ligne tout les 7 jours (7,14,21,28)
					if ($i%7==0) {
						$req = "select  timeRdv, libelleMotif from rdv join motif on rdv.idmotif=motif.idmotif join employe on employe.numEmploye=rdv.numEmploye where DAYOFMONTH(dateRdv) = $i and nom = '$nom'";
						$res = $conn->query($req);
						$res->setFetchMode(PDO::FETCH_OBJ);
						$ligne = $res->fetch();
						if ($ligne == false) {
							echo '<td>' . $i . '</td>';
						} else {
							echo '<td>'. $i .'  '. $ligne->timeRdv . ' minutes   ' . $ligne->libelleMotif . '</td></br>';
						}
						echo '</br></tr>';
					}else{
						// La deuxième requête va prendre tout les autres valeurs de $i
						$req = "select  timeRdv, libelleMotif from rdv join motif on rdv.idmotif=motif.idmotif join employe on employe.numEmploye=rdv.numEmploye where DAYOFMONTH(dateRdv) = $i and nom = '$nom'";
						$res = $conn->query($req);
						$res->setFetchMode(PDO::FETCH_OBJ);
						$ligne = $res->fetch();
						if ($ligne == false) {
							echo '<td>' . $i . '</td>';
						} else {
						echo '<td>'. $i .'  ' . $ligne->timeRdv . ' minutes   ' . $ligne->libelleMotif . '</td></br>';
						}
					}
	}else{
		echo '<td></td>';
	}
}
		echo'</tr>';
		$res->closeCursor();
		}
			catch(PDOException $e){
			$msg='ERREUR dans '.$e->getFile().'Ligne'.$e->getLine().':'.$e->getMessage();
			}
		
		?>  
</table>
  	</body>
</html>