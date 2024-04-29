<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Création d'un client</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="accueil.css"/>
</head>
<body>
<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';
try{
            if(isset($_POST['ajouterclient'])&& !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['adresse']) && !empty($_POST['adressemail']) && !empty($_POST['numtel']) && !empty($_POST['datedenaissance'])){
                $nomemploye = $_POST['nomemploye'];
                // Recherche du numéro de contrat à partir du nom du contrat
                $sql = "SELECT numEmploye FROM employe WHERE nom = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$nomemploye]);
                $rowemploye = $stmt->fetch(PDO::FETCH_ASSOC);

                $situation = $_POST['situation'];
                // Recherche du numéro de contrat à partir du nom du contrat
                $sql2 = "SELECT idSituation FROM situation WHERE description = ?";
                $stmt = $conn->prepare($sql2);
                $stmt->execute([$situation]);
                $rowsituation = $stmt->fetch(PDO::FETCH_ASSOC);
            
                $search1 = $_POST['nom'];
                $search2 = $_POST['prenom'];
                $search3 = $_POST['numtel'];
                $search4 = $_POST['datedenaissance'];
                $sql = "SELECT * FROM client WHERE nom LIKE '%$search1%' AND prenom LIKE '%$search2%' AND numTel LIKE '%$search3%' AND dateNaissance LIKE '%$search4%'" ;
                $result = $conn->query($sql);
                    if (($result->rowCount() > 0)&& ($_POST['ajouterclient'])) {
                    // Afficher les données trouvées
                        foreach ($result as $row) {
                        $rowcli=$row['numClient'];
                        $rownom=$row['nom'];
                        $rowpre=$row['prenom'];
                        $rowad=$row['adresse'];
                        $rowma=$row['mail'];
                        $rownum=$row['numTel'];
                        $rowsitu=$row['situation'];
                            if(isset($_POST['ajouterclient'])&& (($_POST['nom'])==$rownom) || (($_POST['prenom'])==$rowpre) || (($_POST['adresse'])==$rowad) || (($_POST['adressemail'])==$rowma) || (($_POST['numtel'])==$rownum)){
                                echo "Le client existe déjà dans la base de données";
                        }else{
                            $nomclient = $_POST['nom'];
                            $prenomclient = $_POST['prenom'];
                            $adresseclient = $_POST['adresse'];
                            $adressemailclient = $_POST['adressemail'];
                            $numerotelclient = $_POST['numtel'];
                            $datedenaissance = $_POST['datedenaissance'];
                            $situation = $_POST['situation'];
                            $nomemploye = $_POST['nomemploye'];
                            $sql = "INSERT INTO client (nom, prenom, adresse, mail, numTel,dateNaissance, idSituation, numEmploye) VALUES (?, ?, ?, ?,?, ?, ?, ?)";
                            echo $sql;
                            $stmt = $connexion->prepare($sql);
                            if ($stmt->execute([$nomclient, $prenomclient, $adresseclient, $adressemailclient,$numerotelclient,$datedenaissance, $rowsituation['situation'], $rowemploye['nomemploye']])) {
                                echo '<script>alert("Le client a été ajouté à la base de données.");</script>';
                            } else {
                                echo '<script>alert("Une erreur est survenue lors de l\'ajout du client.");</script>';
                            }
                }}}}}
catch(PDOException $e){
    $msg='ERREUR dans '.$e->getFile().'Ligne'.$e->getLine().':'.$e->getMessage();
    }
?>
    <form action="ajouterClient.php" method="post">
            <fieldset>
            <legend>Création du client</legend>
            <p>
            <label for="Nom">Nom</label>
            <input type="text" name="nom" value="" id="nom" size="12" maxlength="25" required>
            </p>
            <p>
            <label for="Prenom">Prénom</label>
            <input type="text" name="prenom" value="" id="prenom" size="12" maxlength="25" required>
            </p>
            <p>
            <label for="adresse">Adresse</label>
            <input type="text" name="adresse" value="" id="adresse" size="12" maxlength="25" required>
            </p>
            <p>
            <label for="adressemail">Adresse email</label>
            <input type="text" name="adressemail" value="" id="adressemail" size="50" maxlength="50" required></br>
            </p>
            <p>
            <label for="numtel">Numéro de téléphone</label>
            <input type="text" name="numtel" value="" id="numtel" size="10" maxlength="25" required></br>
            </p>
            <p>
            <label for="datedenaissance">Date de naissance : </label>
            <input type="date" name="datedenaissance" value="" id="datedenaissance" required></br>
            </p>
            <p>
            <label for="nomemploye">Nom du conseiller</label>
            <select id="nomemploye" name="nomemploye">
            <?php
                $sql = "SELECT nom FROM employe WHERE categorie='Conseiller'";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $nomconseillers = $stmt->fetchAll();

                foreach ($nomconseillers as $nomconseiller) {
                    $selected = ($rowemploye['nom'] == $nomconseiller['nom']) ? 'selected' : '';
                    echo "<option value=\"{$nomconseiller['nom']}\" $selected>{$nomconseiller['nom']}</option>";
                }
                ?>
            </select>
            </p>
            <p>
            <label for="situation">Situation</label>
            <select id="situation" name="situation">
            <?php
                $sql = "SELECT description FROM situation";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $nomsituations = $stmt->fetchAll();

                foreach ($nomsituations as $nomsituation) {
                    $selected = ($rowemploye['description'] == $nomsituation['description']) ? 'selected' : '';
                    echo "<option value=\"{$nomsituation['description']}\" $selected>{$nomsituation['description']}</option>";
                }
                ?>
            </select>
            </p>
            <p>
            <input type="submit" name="ajouterclient" value="Ajouter un client">
            <input type="reset" name="reset" value="Effacer les valeurs saisies">
            </p>
            </fieldset>
            </form>
