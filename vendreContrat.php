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

try {
    echo '
    <h2>Formulaire de Vente de Contrat</h2>
    <form action="vendreContract.php" method="post">
        <label for="date">Date d\'ouverture :</label>
        <input type="date" id="date" name="date" required><br><br>

        <label for="tarif">Tarif mensuel :</label>
        <input type="number" id="tarif" name="tarif" min="0" step="0.01" required><br><br>

        <label for="nomcli">Nom du client :</label>
        <input type="text" id="nomcli" name="nomcli" required><br><br>

        <label for="numcon">Nom du contrat :</label>
        <input type="text" id="numcon" name="numcon" required><br><br>

        <input type="submit" name="ventecon" value="Vendre un contrat">
    </form>';

            if(isset($_POST['ventecon'], $_POST['date'], $_POST['tarif'], $_POST['nomcli'], $_POST['numcon'])) {
                // Récupération des données du formulaire
                $datcon = $_POST['date'];
                $tarcon = $_POST['tarif'];
                $nomcli = $_POST['nomcli'];
                $ncon = $_POST['numcon'];

                // Recherche du numéro de client à partir du nom saisi
                $sql = "SELECT numClient FROM client WHERE nom LIKE '%$nomcli%'";
                $result = $conn->query($sql);
            
                if ($result->rowCount() > 0) {
                    // Récupération du numéro de client
                    $row = $result->fetch(PDO::FETCH_ASSOC);
                    $rowcli = $row['numClient'];
            
                    // Vérification de l'existence du contrat
                    $sql_contrat = "SELECT nomContrat FROM Contrat WHERE nomContrat = '$ncon'";
                    $result_contrat = $conn->query($sql_contrat);
                    
                    
                    if ($result_contrat->rowCount() > 0) {
                        // Insertion des données dans la base de données
                        $req = "INSERT INTO ContratClient (dateOuvertureContrat, tarifMensuel, numClient, nomContrat) VALUES ('$datcon', '$tarcon', '$rowcli', '$ncon')";
                        $res = $conn->query($req);
            
                        if($res) {
                            echo 'Le contrat client a été ajouté à la base de données.';
                        } else {
                            echo 'Une erreur est survenue lors de l\'ajout du contrat client.';
                        }
                    } else {
                        echo 'Le contrat spécifié n\'existe pas.';
                    }
                } else {
                    echo 'Aucun client trouvé avec le nom spécifié.';
                }
            }
    }
 catch(PDOException $e) {
    $msg = 'ERREUR dans ' . $e->getFile() . 'Ligne' . $e->getLine() . ':' . $e->getMessage();
}
?>
