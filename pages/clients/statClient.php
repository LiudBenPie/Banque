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


        // Requête SQL pour récupérer le nombre de clients par mois
        $sql = "SELECT YEAR(dateInscription) AS year, MONTH(dateInscription) AS month, COUNT(DISTINCT numClient) AS nombre_client
            FROM (
                SELECT numClient, dateOuverture AS dateInscription
                FROM CompteClient
                UNION ALL
                SELECT numClient, dateOuvertureContrat AS dateInscription
                FROM ContratClient
            ) AS DatesInscription
            WHERE dateInscription BETWEEN ? AND ?
            GROUP BY YEAR(dateInscription), MONTH(dateInscription)
            ORDER BY year, month;";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$datedebut, $datefin]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Préparation des données pour Chart.js
    $labels = [];
    $data = [];
    foreach ($results as $row) {
        $labels[] = $row['year'] . '-' . sprintf("%02d", $row['month']);  // Formater le mois en 'YYYY-MM'
        $data[] = $row['nombre_client'];
    }

    $dataBar = [
        'labels' => $labels,
        'datasets' => [
            [
                'label' => 'Nombre de Clients Inscrits',
                'data' => $data,
                'backgroundColor' => 'rgba(75, 192, 192, 0.6)',
                'borderColor' => 'rgba(75, 192, 192, 1)',
                'borderWidth' => 1
            ]
        ]
    ];
    ?>

    <div style="width: 75%; margin: auto;">
        <canvas id="clientsHistogram"></canvas>
    </div>
    <script>
        var ctx = document.getElementById('clientsHistogram').getContext('2d');
        var clientsHistogram = new Chart(ctx, {
            type: 'bar',  // Type de graphique
            data: <?php echo json_encode($dataBar); ?>,  // Données du graphique
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Nombre de Clients'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Mois'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Nombre de Clients par Mois'
                    }
                }
            }
        });
    </script>
        <?php
    }
} catch (PDOException $e) {
    echo "Erreur lors de l'exécution de la requête : " . htmlspecialchars($e->getMessage());
}
?>
</body>
</html>