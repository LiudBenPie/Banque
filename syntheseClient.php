<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['numClient'])) {
    $numClient = $_POST['numClient'];
    
    // Récupération des informations du client sélectionné
    $sql = "SELECT nom, prenom, adresse, mail, numtel, dateNaissance FROM client WHERE numClient = :numClient";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':numClient', $numClient, PDO::PARAM_INT);
    $stmt->execute();
    $clientInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$clientInfo) {
        // Gérer le cas où le client n'est pas trouvé
        echo "Client introuvable";
        exit;
    }

    // Afficher les informations du client
    echo "<h2>Synthèse du client : {$clientInfo['nom']} {$clientInfo['prenom']}</h2>";
    echo "<p><strong>Adresse :</strong> {$clientInfo['adresse']}</p>";
    echo "<p><strong>Email :</strong> {$clientInfo['mail']}</p>";
    echo "<p><strong>Téléphone :</strong> {$clientInfo['numtel']}</p>";
    echo "<p><strong>Date de naissance :</strong> {$clientInfo['dateNaissance']}</p>";

    // Exemple de graphique avec Chart.js (à adapter selon vos besoins)
    echo "<h3>Graphique des opérations</h3>";
    echo "<canvas id='operationsChart' width='400' height='200'></canvas>";

    // JavaScript pour initialiser le graphique
    echo "<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>";
    echo "<script>
            var ctx = document.getElementById('operationsChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai'],
                    datasets: [{
                        label: 'Montant des opérations (en €)',
                        data: [150, 200, 400, 0, 0], // Exemple de données à remplacer par les données réelles
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
          </script>";
}
?>
