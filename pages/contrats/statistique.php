<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistique des types de contrats</title>
</head>

<body>
    <?php
    require('../../init.php'); // Inclure le fichier d'initialisation pour établir la connexion PDO
    checkAcl('auth'); // Vérification des autorisations (ACL)
    include VIEWS_DIR . '/menu.php'; // Inclusion du menu (si nécessaire)
    // Définir les mois en lettres
    $moisEnLettres = [
        1 => "Janvier", 2 => "Février", 3 => "Mars", 4 => "Avril", 5 => "Mai", 6 => "Juin",
        7 => "Juillet", 8 => "Août", 9 => "Septembre", 10 => "Octobre", 11 => "Novembre", 12 => "Décembre"
    ];

    $totalRdv = 0; // Variable pour stocker le nombre total de rendez-vous
    ?>
    <form action="statContrat.php" method="post">
        <label for="datedebut">Date de début :</label>
        <input type="date" name="datedebut" id="datedebut" value="<?php echo isset($_POST['datedebut']) ? $_POST['datedebut'] : ''; ?>" required>
        <label for="datefin">Date de fin :</label>
        <input type="date" name="datefin" id="datefin" value="<?php echo isset($_POST['datefin']) ? $_POST['datefin'] : ''; ?>" required>
        <button type="submit">Voir</button>
    </form>
    <div style="height: 80%;">
        <?php
        try {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $datedebut = $_POST['datedebut'];
                $datefin = $_POST['datefin'];

                // La statistique du contrat
                $sql = "SELECT COUNT(DISTINCT contratClient.idContratClient) AS nombre_contrat
                FROM contratclient
                WHERE dateOuverturecontrat BETWEEN '$datedebut' AND '$datefin'";

                // Préparation et exécution de la requête SQL avec PDO
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                // Récupération du résultat
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                // Affichage de la somme des soldes des comptes clients ouverts dans la période spécifiée
                echo "<div style='width: 25%; float: left; vertical-align: middle; text-align: center; box-shadow: 0 4px 8px rgba(0,0,0,0.1); '><h3 style='text-align: center'>Statistique des contrats</h3><p>Nombre de contrats ouverts <br> entre $datedebut et $datefin : " . $result['nombre_contrat'].'</p>';

                // Requête SQL pour récupérer les données entre deux dates
                $sqlcontrat = "SELECT nomTypeContrat, COUNT(*) AS nombre_contrats FROM ContratClient
                INNER JOIN Contrat ON ContratClient.numContrat = Contrat.numContrat
                WHERE dateOuvertureContrat BETWEEN :datedebut AND :datefin
                GROUP BY Contrat.nomTypeContrat";

                // Préparation de la requête SQL avec PDO
                $stmtcontrat = $conn->prepare($sqlcontrat);

                // Exécution de la requête avec les valeurs directement
                $stmtcontrat->execute([':datedebut' => $datedebut, ':datefin' => $datefin]);

                // Récupération des résultats de la requête
                $typesContrat = $stmtcontrat->fetchAll(PDO::FETCH_ASSOC);

                // Préparation des données pour le graphique
                $labelscontrat = [];
                $valuescontrat = [];

                // Formatage des résultats pour le graphique
                foreach ($typesContrat as $row) {
                    $labelscontrat[] = $row['nomTypeContrat'];
                    $valuescontrat[] = (int) $row['nombre_contrats'];
                }

                // Inclure la bibliothèque Chart.js
                echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>';
                echo '<canvas id="myChart"></canvas>';
                echo "<script>
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: " . json_encode($labelscontrat) . ",
                    datasets: [{
                        label: 'Nombre de contrat',
                        data: " . json_encode($valuescontrat) . ",
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)', 'rgba(255, 206, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)', 'rgba(153, 102, 255, 0.8)',
                            'rgba(255, 159, 64, 0.8)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Répartition des types de contrat entre " . $datedebut . " et " . $datefin . "'
                        }
                    }
                }
            });
            </script></div>";

                // La statistique des rdv
                $sql = "SELECT COUNT(DISTINCT rdv.numRdv) AS nombre_rdv
                FROM rdv
                WHERE dateRdv BETWEEN '$datedebut' AND '$datefin'";

                // Préparation et exécution de la requête SQL avec PDO
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                // Récupération du résultat
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                // Affichage de la somme des soldes des comptes clients ouverts dans la période spécifiée
                echo "<div style='width: 25%; float: left; vertical-align: middle; text-align: center;box-shadow: 0 4px 8px rgba(0,0,0,0.1);  '><h3 style='text-align: center'>Statistique des rendez-vous</h3><p>Nombre de rdv pris <br> entre $datedebut et $datefin : " . $result['nombre_rdv'].'</p>';

                // Requête SQL pour récupérer les données
                $sql = "SELECT nom, MONTH(dateRdv) AS mois, COUNT(*) AS nombre_rdv FROM rdv 
                JOIN employe ON rdv.NumEmploye = employe.Numemploye 
                WHERE dateRdv BETWEEN ? AND ? 
                GROUP BY nom, mois";

                // Prepare and execute SQL query with PDO
                $stmt = $conn->prepare($sql);
                $stmt->execute([$datedebut, $datefin]);

                // Retrieve query results
                $typesCompte = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Prepare data for the pie chart
                $labelsPie = [];
                $valuesPie = [];
                $pieColors = ['rgba(255, 99, 132, 0.8)', 'rgba(54, 162, 235, 0.8)', 'rgba(255, 206, 86, 0.8)', 'rgba(75, 192, 192, 0.8)', 'rgba(153, 102, 255, 0.8)', 'rgba(255, 159, 64, 0.8)'];

                // Prepare data for the bar chart
                $labelsBar = array_values($moisEnLettres);
                $datasetsBar = [];

                // Create an associative array to group appointments by month for each advisor
                $dataByMonth = [];
                foreach ($typesCompte as $row) {
                    $labelsPie[$row['nom']] = $row['nom'];
                    if (!isset($valuesPie[$row['nom']])) {
                        $valuesPie[$row['nom']] = 0;
                    }
                    $valuesPie[$row['nom']] += (int) $row['nombre_rdv'];

                    if (!isset($dataByMonth[$row['nom']])) {
                        $dataByMonth[$row['nom']] = array_fill(1, 12, 0); // Initialize all months to 0
                    }

                    $dataByMonth[$row['nom']][$row['mois']] = $row['nombre_rdv'];

                    // Increment the total number of appointments
                    $totalRdv += (int) $row['nombre_rdv'];
                }

                // Prepare data for the bar chart
                foreach ($dataByMonth as $nom => $moisData) {
                    $datasetsBar[] = [
                        'label' => $nom,
                        'data' => array_values($moisData), // Values are the number of appointments for each month
                        'backgroundColor' => $pieColors[array_rand($pieColors)],
                        'borderColor' => "rgba(255, 255, 255, 1)",
                        'borderWidth' => 1
                    ];
                }

                // Data in JSON format for the pie chart
                $dataPie = [
                    'labels' => array_values($labelsPie),
                    'values' => array_values($valuesPie)
                ];

                // JavaScript script to generate the pie chart
                echo '<canvas id="myChartPie"></canvas>       
        <script>
        var ctxPie = document.getElementById("myChartPie").getContext("2d");
        var myChartPie = new Chart(ctxPie, {
            type: "pie",
            data: {
                labels: ' . json_encode(array_values($labelsPie)) . ',
                datasets: [{
                    label: "Nombre de rendez-vous",
                    data: ' . json_encode(array_values($valuesPie)) . ',
                    backgroundColor: ' . json_encode(array_slice($pieColors, 0, count($valuesPie))) . ',
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
                        text: "Répartition des rendez-vous par conseiller"
                    }
                }
            }
        });
        </script>';

                // Data in JSON format for the bar chart
                $dataBar = [
                    'labels' => $labelsBar,
                    'datasets' => $datasetsBar
                ];

                // JavaScript script to generate the bar chart
                echo '<canvas id="myChartBar" ></canvas>
        <script>
        var ctxBar = document.getElementById("myChartBar").getContext("2d");
        var myChartBar = new Chart(ctxBar, {
            type: "bar",
            data: ' . json_encode($dataBar) . ',
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: "Nombre total de rendez-vous : ' . $totalRdv . '"
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        title: {
                            display: true,
                            text: "Mois"
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: "Nombre de rendez-vous"
                        }
                    }
                }
            }
        });
        </script></div>';

                //Le graphique de solde

                // Requête SQL pour récupérer la somme des soldes des comptes clients ouverts dans la période spécifiée
                $sql = "SELECT SUM(solde) AS somme_solde 
                FROM CompteClient 
                WHERE dateOuverture BETWEEN '$datedebut' AND '$datefin'";

                // Préparation et exécution de la requête SQL avec PDO
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                // Récupération du résultat
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                // Affichage de la somme des soldes des comptes clients ouverts dans la période spécifiée
                echo "<div style='width: 25%; float: left; vertical-align: middle; text-align: center; box-shadow: 0 4px 8px rgba(0,0,0,0.1); '><h3 style='text-align: center'>Statistique du solde</h3><p>Somme des soldes des comptes clients ouverts <br> entre $datedebut et $datefin : " . $result['somme_solde'].'</p>';

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
                echo '
                <canvas id="pieChart"></canvas>
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
                        "rgba(255, 99, 132, 0.8)", // Rose
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
                </script>';

                // Script JavaScript pour générer le graphique en histogramme
                echo '<canvas id="barChart"></canvas>
                <script>
                var ctxBar = document.getElementById("barChart").getContext("2d");
                var barChart = new Chart(ctxBar, {
                type: "bar",
                data: {
                labels: ' . json_encode($labels) . ',
                datasets: [{
                    label: "Solde des clients",
                    data: ' . json_encode($values) . ',
                    backgroundColor: "rgba(75, 192, 192, 0.8)",
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

                //Statistique client 
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
                echo "<div style='width: 25%; float: left; vertical-align: middle; text-align: center; box-shadow: 0 4px 8px rgba(0,0,0,0.1); '><h3 style='text-align: center'>Statistique des clients</h3><p>Nombre de clients ayant un compte ou un contrat <br> entre le " . $datedebut . " et le " . $datefin . " est de : " . $result['nombre_client'] ."</p></div>";
            }
        } catch (PDOException $e) {
            // Gestion des erreurs PDO
            die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
        }
        ?>
    </div>
</body>

</html>