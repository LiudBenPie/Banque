<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';


try {
    echo '
    <h2>Formulaire d\'ouverture de compte</h2>
    <form action="ouvrirCompte.php" method="post">
    <label for="date">Date d\'ouverture :</label>
    <input type="date" id="date" name="date" required><br><br>
    <label for="decou">Montant du découvert :</label>
    <input type="number" id="decou" name="decou" min="0" step="100" required><br><br>
    <label for="nomcli">Nom du client :</label>
    <input type="text" id="nomcli" name="nomcli" required><br><br>
    <label for="numcon">Nom du compte :</label>
    <input type="text" id="nomcom" name="nomcom" required><br><br>
    <input type="submit" name="ventecom" value="Vendre un contrat">
</form>';
    if (isset($_POST['ventecom'], $_POST['date'], $_POST['decou'], $_POST['nomcli'], $_POST['nomcom'])) {
        // Récupération des données du formulaire
        $datcon = $_POST['date'];
        $deccon = $_POST['decou'];
        $nomcli = $_POST['nomcli'];
        $nomcom = $_POST['nomcom'];

        // Recherche du numéro de client à partir du nom saisi
        $sql = "SELECT numClient FROM client WHERE nom LIKE '%$nomcli%'";
        $result = $conn->query($sql);

        if ($result->rowCount() > 0) {
            // Récupération du numéro de client
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $rowcli = $row['numClient'];
            

            // Recherche du numéro du type de compte à partir du nom saisi
            $sql = "SELECT idType FROM typecompte WHERE nomType LIKE '%$nomcom%'";
            $result2 = $conn->query($sql);

            if ($result2->rowCount() > 0) {
            // Récupération du numéro du type de compte
            $row = $result2->fetch(PDO::FETCH_ASSOC);
            $rowcom = $row['idType'];

            
            // Vérification de l'existence du compte
            $concat=$nomcom.$nomcli;
            $sql_compte = "SELECT typecompte.idType FROM typecompte join compte on compte.idType=typecompte.idType WHERE nomType = '%$nomcom%'";
            $result_compte = $conn->query($sql_compte);
            
            if ($result_compte) {
                // Insertion des données dans la base de données
                $req ="INSERT INTO compte (nomCompte,idType) VALUE ($concat,$rowcom)";
                // Le code ne lis pas $res et $res2 alors qu'il le devrait donc il n'execute pas les requêtes mais je ne comprends pas pourquoi
                $res = $conn->query($req);

                if($res){
                $req2 = "INSERT INTO compteclient (dateOuverture, montantDecouvert, numClient, idCompte) VALUES ('$datcon', '$deccon', '$rowcli', '$rowcom')";
                echo $req2;
                $res2 = $conn->query($req2);
                
                if ($res2){
                    echo 'Le compte client a été ajouté à la base de données.';
                }} else {
                    echo 'Une erreur est survenue lors de l\'ajout du compte client.';
                }
            } 
        } else {
            echo 'Le compte spécifié n\'existe pas.';
        }
    }else {
        echo 'Aucun client trouvé avec le nom spécifié.';
    }
}
} catch (PDOException $e) {
    $msg = 'ERREUR dans ' . $e->getFile() . 'Ligne' . $e->getLine() . ':' . $e->getMessage();
}
?>