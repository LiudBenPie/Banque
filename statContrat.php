<?php
require ('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';
if (!isset($pdo)) {
    die("La connexion à la base de données n'est pas disponible.");
}

// Requête SQL pour récupérer les données
    $sql = "SELECT nomTypeContrat, COUNT(*) AS nombre_contrats FROM ContratClient
            INNER JOIN Contrat ON ContratClient.numContrat = Contrat.numContrat
            GROUP BY Contrat.nomTypeContrat";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $typesCompte = $stmt->fetchAll();

try {
    // Exécution de la requête
    $stmt = $pdo->query($sql);

    // Préparation des données pour le graphique
    $data = [
        'labels' => [],
        'values' => []
    ];

    // Récupération des résultats de la requête
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data['labels'][] = $row['nomTypeContrat'];
        $data['values'][] = (int) $row['nombre_contrats'];
    }

    // Retourner les données au format JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
}
?>
