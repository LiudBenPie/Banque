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
    echo '<form action="ajouterClient.php" method="post">
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
            <label for="situation">Situation</label>
            <select id="situations" name="situ">
                <option value="marie">Marié(e)</option>
                <option value="celibataire">Célibataire</option>
                <option value="veuf">Veuf/Veuve</option>
                <option value="divorce">Divorcé(e)</option>
                <option value="en-couple">En couple</option>
                <option value="concubinage">En concubinage</option>
                <option value="separe">Séparé(e)</option>
                <option value="fiance">Fiancé(e)</option>
                <option value="pacs">Pacsé(e)</option>
                <option value="relation-distance">En relation à distance</option>
            </select>
            </p>
            <p>
            <input type="submit" name="adcli" value="Ajouter un client">
            <input type="reset" name="reset" value="Effacer les valeurs saisies">
            </p>
            </fieldset>
            </form>';
            if(isset($_POST['adcli'])&& !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['adresse']) && !empty($_POST['adressemail']) && !empty($_POST['numtel']) && !empty($_POST['situ'])){
                $search = $_POST['nom'];
                $sql = "SELECT * FROM client WHERE nom LIKE '%$search%'";
                $result = $conn->query($sql);
                    if (($result->rowCount() > 0)&& ($_POST['adcli'])) {
                    // Afficher les données trouvées
                        foreach ($result as $row) {
                        $rowcli=$row['numClient'];
                        $rownom=$row['nom'];
                        $rowpre=$row['prenom'];
                        $rowad=$row['adresse'];
                        $rowma=$row['mail'];
                        $rownum=$row['numTel'];
                        $rowsitu=$row['situation'];
                            if(isset($_POST['adcli'])&& (($_POST['nom'])==$rownom) && (($_POST['prenom'])==$rowpre) && (($_POST['adresse'])==$rowad) && (($_POST['adressemail'])==$rowma) && (($_POST['numtel'])==$rownum) && (($_POST['situ'])==$rowsitu)){
                                echo "Le client existe déjà dans la base de données";
                        }else{
                            $ncli = $_POST['nom'];
                            $pcli = $_POST['prenom'];
                            $acli = $_POST['adresse'];
                            $amcli = $_POST['adressemail'];
                            $ntcli = $_POST['numtel'];
                            $scli = $_POST['situ'];
                            $req = "INSERT INTO `client` (`numClient`, `nom`, `prenom`, `adresse`, `mail`, `numTel`, `situation`) VALUES ('$ncli', '$pcli', '$acli', '$amcli', '$ntcli', '$scli')";
                            $res=$connexion->query($req);
                            $res->closeCursor();
                            echo 'Le client a été ajouté à la base de données';
                        }
                }}}}
catch(PDOException $e){
    $msg='ERREUR dans '.$e->getFile().'Ligne'.$e->getLine().':'.$e->getMessage();
    }
