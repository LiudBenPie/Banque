<?php
require('init.php'); // Inclure le fichier d'initialisation pour établir la connexion PDO
checkAcl('auth'); // Vérification des autorisations (ACL)
include VIEWS_DIR . '/menu.php'; // Inclusion du menu (si nécessaire)

try {
// Requête SQL pour récupérer les données
        $sql = "SELECT nomTypeContrat, COUNT(*) AS nombre_contrats FROM ContratClient
        INNER JOIN Contrat ON ContratClient.numContrat = Contrat.numContrat
        GROUP BY Contrat.nomTypeContrat";
    // Préparation et exécution de la requête SQL avec PDO
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Récupération des résultats de la requête
    $typesCompte = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Préparation des données pour le graphique
    $labels = [];
    $values = [];

    // Formatage des résultats pour le graphique
    foreach ($typesCompte as $row) {
        $labels[] = $row['nomTypeContrat'];
        $values[] = (int) $row['nombre_contrats'];
    }

    // Données au format JSON pour le graphique
    $data = [
        'labels' => $labels,
        'values' => $values
    ];

    // Inclure la bibliothèque Chart.js
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>';

    // Script JavaScript pour générer le graphique circulaire
    echo '<canvas id="myChart" width="400" height="400"></canvas>
    <script>
    var ctx = document.getElementById("myChart").getContext("2d");
    var myChart = new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: ' . json_encode($data['labels']) . ',
            datasets: [{
                label: "Nombre de contrats",
                data: ' . json_encode($data['values']) . ',
                backgroundColor: [
                    "rgba(255, 99, 132, 0.2)",
                    "rgba(54, 162, 235, 0.2)",
                    "rgba(255, 206, 86, 0.2)",
                    "rgba(75, 192, 192, 0.2)",
                    "rgba(153, 102, 255, 0.2)",
                    "rgba(255, 159, 64, 0.2)"
                ],
                borderColor: [
                    "rgba(255, 99, 132, 1)",
                    "rgba(54, 162, 235, 1)",
                    "rgba(255, 206, 86, 1)",
                    "rgba(75, 192, 192, 1)",
                    "rgba(153, 102, 255, 1)",
                    "rgba(255, 159, 64, 1)"
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: "Répartition des types de contrats"
                }
            }
        }
    });
    </script>';
} catch (PDOException $e) {
    // Gestion des erreurs PDO
    die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
}
?>