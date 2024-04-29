<?php
// Inclusion du fichier d'initialisation
require('init.php');

// Vérification des autorisations (ACL)
checkAcl('auth');

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
echo json_encode($data);
?>
