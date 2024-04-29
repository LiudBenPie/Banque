<?php
require('init.php'); // Inclure le fichier d'initialisation pour établir la connexion PDO
checkAcl('auth'); // Vérification des autorisations (ACL)
include VIEWS_DIR . '/menu.php'; // Inclusion du menu (si nécessaire)

// Vérifier l'existence de la connexion PDO
if (!isset($pdo)) {
    die("La connexion à la base de données n'est pas disponible.");
}

// Requête SQL pour récupérer les données
$sql = "SELECT nomTypeContrat, COUNT(*) AS nombre_contrats FROM ContratClient
        INNER JOIN Contrat ON ContratClient.numContrat = Contrat.numContrat
        GROUP BY Contrat.nomTypeContrat";

try {
    // Préparation et exécution de la requête SQL avec PDO
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    // Récupération des résultats de la requête
    $typesCompte = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Préparation des données pour le graphique
    $data = [
        'labels' => [],
        'values' => []
    ];

    // Formatage des résultats pour le graphique
    foreach ($typesCompte as $row) {
        $data['labels'][] = $row['nomTypeContrat'];
        $data['values'][] = (int) $row['nombre_contrats'];
    }

    // Retourner les données au format JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    // Gestion des erreurs PDO
    die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
}
?>
