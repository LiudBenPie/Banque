<?php
// Inclusion du fichier d'initialisation
require('init.php');

// Vérification des autorisations (ACL)
checkAcl('auth');

// Inclusion de l'élément de vue du menu
include VIEWS_DIR . '/menu.php';

// Requête SQL pour récupérer les données
$sql = "SELECT nomTypeContrat, COUNT(*) AS nombre_contrats FROM ContratClient
        INNER JOIN Contrat ON ContratClient.numContrat = Contrat.numContrat
        GROUP BY Contrat.nomTypeContrat";

// Exécution de la requête
$stmt = $pdo->query($sql);

// Préparation des données pour le graphique
$data = [
    'labels' => [],
    'values' => []
];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data['labels'][] = $row['nomTypeContrat'];
    $data['values'][] = (int) $row['nombre_contrats'];
}

// Retourner les données au format JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
