<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';


try {
    if (isset($_POST['ventecom'], $_POST['date'], $_POST['decou'], $_POST['nomcli'], $_POST['numcon'])) {
        // Récupération des données du formulaire
        $datcon = $_POST['date'];
        $deccon = $_POST['decou'];
        $nomcli = $_POST['nomcli'];
        $ncon = $_POST['numcon'];

        // Recherche du numéro de client à partir du nom saisi
        $sql = "SELECT numClient FROM client WHERE nom LIKE '%$nomcli%'";
        $result = $conn->query($sql);

        if ($result->rowCount() > 0) {
            // Récupération du numéro de client
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $rowcli = $row['numClient'];

            // Vérification de l'existence du compte
            $sql_contrat = "SELECT nomCompte FROM compte WHERE nomCompte = '$ncon'";
            $result_contrat = $conn->query($sql_contrat);


            if ($result_contrat->rowCount() > 0) {
                // Insertion des données dans la base de données
                $req = "INSERT INTO compteclient (dateOuverture, montantDecouvert, numClient, idCompte) VALUES ('$datcon', '$deccon', '$rowcli', '$ncon')";
                $res = $conn->query($req);

                if ($res) {
                    echo 'Le compte client a été ajouté à la base de données.';
                } else {
                    echo 'Une erreur est survenue lors de l\'ajout du compte client.';
                }
            } else {
                echo 'Le compte spécifié n\'existe pas.';
            }
        } else {
            echo 'Aucun client trouvé avec le nom spécifié.';
        }
    }
} catch (PDOException $e) {
    $msg = 'ERREUR dans ' . $e->getFile() . 'Ligne' . $e->getLine() . ':' . $e->getMessage();
}
?>
<h2>Formulaire d\'ouverture de compte</h2>
<form action="ouvrirCompte.php" method="post">
    <label for="date">Date d\'ouverture :</label>
    <input type="date" id="date" name="date" required><br><br>
    <label for="decou">Montant du découvert :</label>
    <input type="number" id="decou" name="decou" min="0" step="100" required><br><br>
    <label for="nomcli">Nom du client :</label>
    <input type="text" id="nomcli" name="nomcli" required><br><br>
    <label for="numcon">Nom du compte :</label>
    <input type="text" id="numcon" name="numcon" required><br><br>
    <input type="submit" name="ventecom" value="Vendre un contrat">
</form>