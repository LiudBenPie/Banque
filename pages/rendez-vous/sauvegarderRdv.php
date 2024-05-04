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

        // Vérifier si le rendez-vous existe déjà pour le même conseiller, date et heure.
        $stmt = $conn->prepare("SELECT COUNT(*) FROM rdv WHERE dateRdv = ? AND heureRdv = ? AND numEmploye = ?");
        $stmt->execute([$dateRdv, $heureRdv, $numEmploye]);
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            try {
                // Le rendez-vous n'existe pas encore, donc on peut l'insérer
                // Préparer une requête SQL pour insérer les données
                $stmt = $conn->prepare("INSERT INTO rdv (dateRdv, heureRdv, numEmploye, idMotif, numClient) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$dateRdv, $heureRdv, $numEmploye, $idMotif, $numClient]);

                echo "RDV ajouté avec succès!";
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
        } else {
            echo '<script>alert("Un rendez-vous existe déjà pour cette date, cette heure et ce conseiller.");</script>';
        }
    }
    ?>
</body>

</html>