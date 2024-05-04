<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques du solde total</title>
</head>
<body>
<?php
require('../../init.php'); // Inclure le fichier d'initialisation pour établir la connexion PDO
checkAcl('auth'); // Vérification des autorisations (ACL)
include VIEWS_DIR . '/menu.php'; // Inclusion du menu (si nécessaire);
?>
<form action="statSolde.php" method="post">
    <label for="datedebut">Date de début :</label>
    <input type="date" name="datedebut" id="datedebut" required><br>
    <label for="datefin">Date de fin :</label>
    <input type="date" name="datefin" id="datefin" required><br>
    <button type="submit">Voir</button>
</form>
<?php
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupération des dates spécifiées dans le formulaire
        $datedebut = $_POST['datedebut'];
        $datefin = $_POST['datefin'];
        
        // Requête SQL pour récupérer la somme des soldes des comptes clients ouverts dans la période spécifiée
        $sql = "SELECT SUM(solde) AS somme_solde 
                FROM CompteClient 
                WHERE dateOuverture BETWEEN ? AND ?";
        
        // Préparation et exécution de la requête SQL avec PDO
        $stmt = $conn->prepare($sql);
        $stmt->execute([$datedebut, $datefin]);
        
        // Récupération du résultat
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Affichage de la somme des soldes des comptes clients ouverts dans la période spécifiée
        echo "Somme des soldes des comptes clients ouverts entre $datedebut et $datefin : " . $result['somme_solde'];
        
        // Requête SQL pour récupérer les soldes des clients
        $sql = "SELECT SUM(solde) AS solde_client, nom, prenom 
                FROM compteclient 
                JOIN client ON client.Numclient = compteclient.Numclient 
                WHERE compteclient.dateOuverture BETWEEN ? AND ? 
                GROUP BY nom, prenom";
        
        // Préparation et exécution de la requête SQL avec PDO
        $stmt = $conn->prepare($sql);
        $stmt->execute([$datedebut, $datefin]);
        
        // Récupération des résultats de la requête
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Préparation des données pour les graphiques
        $labels = [];
        $values = [];

        // Formatage des résultats pour les graphiques
        foreach ($clients as $client) {
            $labels[] = $client['nom'] . ' ' . $client['prenom'];
            $values[] = (int) $client['solde_client'];
        }

        // Inclure la bibliothèque Chart.js
        echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>';

        // Script JavaScript pour générer le graphique circulaire
        echo '<div style="width: 30%; display: block;"><canvas id="pieChart"></canvas>
        <script>
        var ctxPie = document.getElementById("pieChart").getContext("2d");
        var pieChart = new Chart(ctxPie, {
            type: "pie",
            data: {
                labels: ' . json_encode($labels) . ',
                datasets: [{
                    label: "Solde des clients",
                    data: ' . json_encode($values) . ',
                    backgroundColor: [
                        "rgba(255, 99, 132, 0.8)", // Rouge
                        "rgba(54, 162, 235, 0.8)", // Bleu
                        "rgba(255, 206, 86, 0.8)", // Jaune
                        "rgba(75, 192, 192, 0.8)", // Vert
                        "rgba(153, 102, 255, 0.8)" // Violet
                    ],
                    borderColor: [
                        "rgba(255, 99, 132, 1)",
                        "rgba(54, 162, 235, 1)",
                        "rgba(255, 206, 86, 1)",
                        "rgba(75, 192, 192, 1)",
                        "rgba(153, 102, 255, 1)"
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: "Répartition des soldes des clients "
                    }
                }
            }
        });
        </script></div>';

        // Script JavaScript pour générer le graphique en histogramme
        echo '<div style="width: 30%; display: block;"><canvas id="barChart"></canvas>
        <script>
        var ctxBar = document.getElementById("barChart").getContext("2d");
        var barChart = new Chart(ctxBar, {
            type: "bar",
            data: {
                labels: ' . json_encode($labels) . ',
                datasets: [{
                    label: "Solde des clients",
                    data: ' . json_encode($values) . ',
                    backgroundColor: "rgba(75, 192, 192, 0.2)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: "Soldes des clients "
                    }
                }
            }
        });
        </script></div>';
    }
} catch (PDOException $e) {
    // Gestion des erreurs PDO
    echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
}
?>
</body>
</html>
