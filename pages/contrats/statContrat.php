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
    ?>
    <form action="statContrat.php" method="post">
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
            // Requête SQL pour récupérer les données entre deux dates
            $sql = "SELECT nomTypeContrat, COUNT(*) AS nombre_contrats FROM ContratClient
                INNER JOIN Contrat ON ContratClient.numContrat = Contrat.numContrat
                WHERE dateOuvertureContrat BETWEEN '$datedebut' AND '$datefin'
                GROUP BY Contrat.nomTypeContrat";

            // Préparation et exécution de la requête SQL avec PDO
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            // Récupération des résultats de la requête
            $typesContrat = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Préparation des données pour le graphique
            $labels = [];
            $values = [];

            // Formatage des résultats pour le graphique
            foreach ($typesContrat as $row) {
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
            echo '<div style="width: 30%; margin: 0 auto;"><canvas id="myChart"></canvas>
            <script>
            var ctx = document.getElementById("myChart").getContext("2d");
            var myChart = new Chart(ctx, {
                type: "pie",
                data: {
                    labels: ' . json_encode($data['labels']) . ',
                    datasets: [{
                        label: "Nombre de contrat",
                        data: ' . json_encode($data['values']) . ',
                        backgroundColor: [
                            "rgba(75, 0, 130, 0.8)", // Indigo foncé
                            "rgba(0, 0, 128, 0.8)", // Bleu marine foncé
                            "rgba(0, 100, 0, 0.8)", // Vert foncé
                            "rgba(139, 0, 139, 0.8)", // Violet foncé
                            "rgba(165, 42, 42, 0.8)", // Brun foncé
                            "rgba(128, 0, 0, 0.8)" // Rouge foncé
                        ],
                        borderColor: [
                            "rgba(75, 0, 130, 1)",
                            "rgba(0, 0, 128, 1)",
                            "rgba(0, 100, 0, 1)",
                            "rgba(139, 0, 139, 1)",
                            "rgba(165, 42, 42, 1)",
                            "rgba(128, 0, 0, 1)"
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: "Répartition des types de contrat entre ' . $datedebut . ' et ' . $datefin . '"
                        }
                    },
                }
            });
            </script></div>';
        }
    } catch (PDOException $e) {
        // Gestion des erreurs PDO
        die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
    }
    ?>
</body>

</html>