<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Vente d'un contrat</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<?php
require('init.php'); 
checkAcl('auth');
include VIEWS_DIR . '/menu.php';
try {
    echo '
    <h2>Formulaire de Vente de Contrat</h2>
    <form action="vendreContrat.php" method="post">
        <label for="date">Date d\'ouverture :</label>
        <input type="date" id="date" name="date" required><br><br>

        <label for="tarif">Tarif mensuel :</label>
        <input type="number" id="tarif" name="tarif" min="0" step="0.01" required><br><br>

        <label for="nomcli">Nom du client :</label>
        <input type="text" id="nomcli" name="nomcli" required><br><br>

        <label for="numcon">Nom du contrat :</label>
        <input type="text" id="nomcon" name="nomcon" required><br><br>

        <input type="submit" name="ventecon" value="Vendre un contrat">
    </form>';

            if(isset($_POST['ventecon'], $_POST['date'], $_POST['tarif'], $_POST['nomcli'], $_POST['nomcon'])) {
                // Récupération des données du formulaire
                $datcon = $_POST['date'];
                $tarcon = $_POST['tarif'];
                $nomcli = $_POST['nomcli'];
                $nomcon = $_POST['nomcon'];

                // Recherche du numéro de client à partir du nom saisi
                $sql = "SELECT numClient FROM client WHERE nom LIKE '%$nomcli%'";
                $result = $conn->query($sql);
            
                if ($result->rowCount() > 0) {
                    // Récupération du numéro de client    
                    $row = $result->fetch(PDO::FETCH_ASSOC);
                    $rowcli = $row['numClient'];

                // Recherche du numéro de contrat à partir du nom saisi
                $sql = "SELECT numContrat FROM contrat WHERE nomContrat LIKE '%$nomcon%'";
                $result2 = $conn->query($sql);

                if ($result2->rowCount() > 0) {
                    // Récupération du numéro de contrat
                    $row = $result2->fetch(PDO::FETCH_ASSOC);
                    $rowcon = $row['numContrat'];

                    // Vérification de l'existence du contrat
                    $sql_contrat = "SELECT nomContrat FROM Contrat WHERE nomContrat = '$nomcon'";
                    $result_contrat = $conn->query($sql_contrat);
                    if ($result_contrat->rowCount() > 0) {
                        // Insertion des données dans la base de données
                        $req = "INSERT INTO ContratClient (dateOuvertureContrat, tarifMensuel, numClient, numContrat) VALUES ('$datcon', '$tarcon', '$rowcli', '$rowcon')";
                        $res = $conn->query($req);
            
                        if($res) {
                            echo '<script> alert "Le contrat client a été ajouté à la base de données."</script>';
                        } else {
                            echo '<script> alert"Une erreur est survenue lors de l\'ajout du contrat client."</script>';
                        }
                    }
                } else {
                    echo '<script> alert"Le contrat spécifié n\'existe pas."</script>';
                }
            } else {
                echo '<script> alert "Aucun client trouvé avec le nom spécifié."</script>';
            }}
    }
 catch(PDOException $e) {
    $msg = 'ERREUR dans ' . $e->getFile() . 'Ligne' . $e->getLine() . ':' . $e->getMessage();
}
?>
