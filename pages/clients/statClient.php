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

try {
    // Requête SQL pour récupérer les données
    $sql = "SELECT COUNT(*) AS nombre_client FROM client";
    
    // Préparation et exécution de la requête SQL avec PDO
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Récupération du résultat
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Affichage du nombre de client
    echo "Nombre de client de la banque est de : " . $result['nombre_client'];
    
} catch (PDOException $e) {
    // Gestion des erreurs PDO
    die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
}
?>
</body>
</html>
