<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistique du nombre de client</title>
</head>
<body>
<?php
require('../../init.php'); // Inclure le fichier d'initialisation pour établir la connexion PDO
checkAcl('auth'); // Vérification des autorisations (ACL)
include VIEWS_DIR . '/menu.php'; // Inclusion du menu (si nécessaire)
?>
<form action="statClient.php" method="post">
        <label for="datedebut">Date de début :</label>
        <input type="date" name="datedebut" id="datedebut" required><br>
        <label for="datefin">Date de fin :</label>
        <input type="date" name="datefin" id="datefin" required><br>
        <button type="submit">Voir</button>
    </form>
    <?php
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $datedebut = $_POST['datedebut'];
        $datefin = $_POST['datefin'];

        // Requête SQL pour récupérer les données
        $sql = "SELECT COUNT(DISTINCT Client.numClient) AS nombre_client
        FROM Client
        LEFT JOIN CompteClient ON Client.numClient = CompteClient.numClient
        LEFT JOIN ContratClient ON Client.numClient = ContratClient.numClient
        WHERE (CompteClient.dateOuverture BETWEEN ? AND ? OR ContratClient.dateOuvertureContrat BETWEEN ? AND ?)";

        // Préparation et exécution de la requête SQL avec PDO
        $stmt = $conn->prepare($sql);
        $stmt->execute([$datedebut, $datefin, $datedebut, $datefin]);

        // Récupération du résultat
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Affichage du nombre de clients ayant un compte ou un contrat à la date spécifiée
        echo "Nombre de clients ayant un compte ou un contrat entre le " . $datedebut . " et le " . $datefin . " est de : " . $result['nombre_client'];
    }
} catch (PDOException $e) {
    // Gestion des erreurs PDO
    die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
}
?>
</body>
</html>