<?php
require('init.php'); // Inclut le fichier de connexion
// Vérifier que le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collecter les données du formulaire
    $dateRdv = $_POST['dateRdv'];
    $timeRdv = $_POST['timeRdv'];
    $numEmploye = $auth->id();
    $idMotif = $_POST['idMotif'];

    // Préparer une requête SQL pour insérer les données
    try {
        $stmt = $conn->prepare("INSERT INTO rdv (dateRdv, timeRdv, numEmploye, idMotif) VALUES (?, ?, ?, ?)");
        $stmt->execute([$dateRdv, $timeRdv, $numEmploye, $idMotif]);

        echo "RDV ajouté avec succès!";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>