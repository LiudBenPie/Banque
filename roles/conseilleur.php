<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de redirection</title>
</head>
<body>
    <h1>Options disponibles pour les conseillers</h1>
    <!-- Formulaire pour choisir une date spécifique -->
    <form action="visualiser_planning.php" method="GET">
        <label for="date">Visualiser le planning pour la date :</label>
        <input type="date" id="date" name="date">
        <button type="submit">Visualiser</button>
    </form>

    <!-- Bouton pour bloquer des créneaux horaires -->
    <button onclick="bloquerCreneaux()">Prendre un rendez-vous</button>

    <!-- Boutons pour les actions sur les clients -->
    <h2>Actions sur les clients :</h2>
    <button onclick="inscrireClient()">Inscrire un nouveau client</button>
    <button onclick="vendreContrat()">Vendre un contrat</button>
    <button onclick="ouvrirCompte()">Ouvrir un compte</button>
    <button onclick="resilierContratCompte()">Résilier un contrat ou un compte</button>
    
    <?php
    require_once('connect.php');
                if (!isset($_GET['menu'])) {
                    echo '<h2>Bienvenu sur le site !!!</h2><h3>Ce site permet de créer des joueurs, de les consulter et de gérer les inscriptions aux tournois !<br>Vous allez adorer !</h3>';
                }

                
                //MENU CREATION
                if (isset($_GET['menu']) && $_GET['menu'] == 'creation') {
                    echo '<form  method="post">
                    <fieldset>
                    <legend>INFORMATION PERSONNELLES</legend>
                    <p>
                    <label for = "nom"> Nom </label>
                    <input type="text" name ="nom" id = "nom" autofocus required/>
                    </p>
                    <p>
                    <label for = "prenom"> Prénom </label>
                    <input type="text" name ="prenom" id = "prenom" required />
                    </p>
                    <p>
                    <label for = "ad"> Adresse </label>
                    <input type="text" name ="ad" id = "ad" required />
                    </p>
                    <p>
                    <label for = "datenais"> Date de naissance </label>
                    <input type="date" name ="datenais" id = "datenais" required />
                    </p>
                    </fieldset>
                    <p>
                    <label class="pas_de_style">&nbsp; </label>
                    <input type = "reset" value="Annuler"/>
                    <input type = "submit" name="valider" value="Valider"/>
                    </p>
                    </form>';
                    if (isset($_POST['valider']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['ad']) && !empty($_POST['datenais'])) {
                        $n = $_POST['nom'];
                        $pren = $_POST['prenom'];
                        $ad = $_POST['ad'];
                        $daten = $_POST['datenais'];
                        $requete = "insert into joueur values(0, '$n', '$pren', '$ad', '$daten')";
                        $resultat = $connexion->query($requete);
                        $resultat->closeCursor();
                        echo '<p class="insertion">Insertion effectuée</p>';
                    }
                
            }
        $resultat->closeCursor() ;
?>

</body>
</html>

