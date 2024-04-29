<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Synthèse client</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php
    require('init.php');
    checkAcl('auth');
    include VIEWS_DIR . '/menu.php';

    // Vérifie si le formulaire a été soumis et que numClient est défini
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['numClient'])) {
        // Récupération du numéro de client sélectionné
        $numClient = $_POST['numClient'];

        // Requête SQL pour récupérer les informations du client
        $sql = "SELECT c.numClient, c.nom, c.prenom, c.adresse, c.mail, c.numtel, s.description AS situation, c.dateNaissance, c.numEmploye, e.nom AS nomEmploye
                FROM client c
                LEFT JOIN situation s ON c.idSituation = s.idSituation
                LEFT JOIN employe e ON c.numEmploye = e.numEmploye
                WHERE c.numClient = :numClient";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':numClient', $numClient, PDO::PARAM_INT);
            $stmt->execute();

            $clientInfo = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($clientInfo) {
                echo "<div id='clientSummary'>";
                echo "<h2>Synthèse du client : {$clientInfo['nom']} {$clientInfo['prenom']}</h2>";
                echo "<p><strong>IdClient :</strong> {$clientInfo['numClient']}</p>";
                echo "<p><strong>Adresse :</strong> {$clientInfo['adresse']}</p>";
                echo "<p><strong>Email :</strong> {$clientInfo['mail']}</p>";
                echo "<p><strong>Téléphone :</strong> {$clientInfo['numtel']}</p>";
                echo "<p><strong>Situation :</strong> {$clientInfo['situation']}</p>";
                echo "<p><strong>Date de naissance :</strong> {$clientInfo['dateNaissance']}</p>";
                echo "<p><strong>Employé en charge du client :</strong> {$clientInfo['nomEmploye']}</p>";
                echo "</div>";

                // Requête pour récupérer les comptes du client
                $sql = "SELECT cc.idCompteClient, co.nomTypeCompte, cc.dateOuverture, cc.solde, cc.montantDecouvert
                        FROM compteclient cc
                        LEFT JOIN compte co ON cc.idCompte = co.idCompte
                        WHERE cc.numClient = :numClient";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':numClient', $numClient, PDO::PARAM_INT);
                $stmt->execute();
                $comptes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                echo "<div id='comptesChartContainer'>";
                echo "<h3>Comptes :</h3>";

                $labels = [];
                $data = [];

                foreach ($comptes as $compte) {
                    echo "<h4>{$compte['nomTypeCompte']}</h4>";
                    echo "<ul>";
                    echo "<li><strong>IdCompte :</strong> {$compte['idCompteClient']}</li>";
                    echo "<li><strong>Date d'ouverture :</strong> {$compte['dateOuverture']}</li>";
                    echo "<li><strong>Solde :</strong> {$compte['solde']} €</li>";
                    echo "<li><strong>Montant autorisé de découvert :</strong> {$compte['montantDecouvert']} €</li>";
                    echo "</ul>";

                    // Ajouter les données pour le graphique en camembert
                    $labels[] = $compte['nomTypeCompte'];
                    $data[] = $compte['solde'];
                }

                echo "<h3>Soldes des Comptes :</h3>";
                echo '<canvas id="comptesChart" width="400" height="400"></canvas>';
                echo "</div>";
            } else {
                echo "<p>Client non trouvé.</p>";
            }
        } catch (PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
        }
    } else {
        echo "<p>Une erreur s'est produite. Veuillez réessayer.</p>";
    }
    ?>

    <script>
        var ctx = document.getElementById('comptesChart').getContext('2d');
        var comptesChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Solde des Comptes',
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</body>

</html>


