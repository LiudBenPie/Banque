<!DOCTYPE html>
<html lang="fr">
 		<head>
   			 <meta charset="utf-8">
   			 <link rel="stylesheet" href="Exo1.css">
   			 <title>Calendrier des examens</title>
        </head>
 	    <body>
		<?php
		require_once('connect.php');
		try{
			echo '<tr>';
				for($i=1;$i<=35;$i++){
					if($i<=31){
					if($i%7==0){
						$req="select * from rdv where date(DD)";	
						$res=$connexion->query($req);
						$res->setFetchMode(PDO::FETCH_OBJ);
						$ligne=$res->fetch();
						if($ligne==false){
						echo '<td>'.$i.'</td>';
						}else{
						echo '<td class="exam">'.$ligne->numjour.'--'.$ligne->matiere.'--'.$ligne->salle.'</td></br>';
					}
					echo '</br></tr>';
					}else{
					$req="select * from examens where numjour=$i";	
					$res=$connexion->query($req);
					$res->setFetchMode(PDO::FETCH_OBJ);
					$ligne=$res->fetch();
				if($ligne==false){
					echo '<td>'.$i.'</td>';
				}else{
					echo '<td class="exam">'.$ligne->numjour.'--'.$ligne->matiere.'--'.$ligne->salle.'</td></br>';
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