<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Vente d'un contrat</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="accueil.css"/>
</head>
<body>
<?php
require_once('connect.php');
try{
    echo '<form action="vendre-un-contrat-conseiller.php" method="post">
            <fieldset>
            <legend>Vente d\un contrat</legend>
            <label for="date">Date d\ouverture</label>
            <input type="date" name="date" value="" id="adresse" size="12" maxlength="25" required>
            </p>
            <p>
            <label for="tarifmens">Tarif mensuel</label>
            <input type="number" name="tarif" min="0" max="30" step="0.5">
            </p>
            <p>
            <label for="Nom">Numéro du client</label>
            <input type="text" name="numcli" value="" size="10" maxlength="25" required>
            </p>
            <p>
            <label for="Nom">Numéro du contrat</label>
            <input type="text" name="numcon" value="" size="10" maxlength="25" required>
            </p>
            <input type="submit" name="ventecon" value="Vendre un contrat">
            <input type="reset" name="reset" value="Effacer les valeurs saisies">
            </p>
            </fieldset>
            </form>';
            if(isset($_POST['ventecon'])&& !empty($_POST['date']) && !empty($_POST['tarif']) && !empty($_POST['numcli'])&&!empty($_POST['numcon'])){
                $search = $_POST['numcli'];
                $sql = "SELECT * FROM contratclient WHERE numClient LIKE '%$search%'";
                $result = $conn->query($sql);
                    if (($result->rowCount() > 0)&& ($_POST['ventecon'])) {
                    // Afficher les données trouvées
                        foreach ($result as $row) {
                        $rowcli=$row['numClient'];
                        $rowcon=$row['Id-contrat'];
                            if(isset($_POST['ventecon'])&& (($_POST['numcli'])==$rowcli)&& (($_POST['numcon'])==$row)){
                                echo "Ce client à déjà ce contrat";
                        }else{
                            $ncon=$_POST['numcon'];
                            $datcon = $_POST['date'];
                            $tarcon = $_POST['tarif'];
                            $ncli = $_POST['numcli'];
                            $req = "INSERT INTO `contratclient` (`dateOuvertureContrat`, `tarifMensuel`, `numClient`, `Id-contrat`) VALUES (0, '$datcon', '$tarcon', '$ncli', '$ncon')";
                            $res=$conn->query($req);
                            $res->closeCursor();
                            echo 'Le client a été ajouté à la base de données';
                        }
                }}}}
catch(PDOException $e){
    $msg='ERREUR dans '.$e->getFile().'Ligne'.$e->getLine().':'.$e->getMessage();
    }
