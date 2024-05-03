<!DOCTYPE html>
<html lang="fr"> 

<head>
    <meta charset="UTF-8"> 
    <title>Ajouter un rendez-vous</title> 
</head>

<body>
    <?php
    require('../../init.php'); 
    checkAcl('auth');
    include VIEWS_DIR . '/menu.php'; 

    // Vérifier que le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collecter les données du formulaire
        $dateRdv = $_POST['dateRdv'];
        $heureRdv = $_POST['heureRdv'];
        // $numEmploye = $auth->id();
        $numEmploye = $_POST['numEmploye'];
        $idMotif = $_POST['idMotif'];
        $numClient = $_POST['numClient'];

        // Préparer une requête SQL pour insérer les données
        try {
            $stmt = $conn->prepare("INSERT INTO rdv (dateRdv, heureRdv, numEmploye, idMotif, numClient) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$dateRdv, $heureRdv, $numEmploye, $idMotif, $numClient]);

            echo "RDV ajouté avec succès!";
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
    ?>
</body>

</html>
