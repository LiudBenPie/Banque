<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistique de nombre de rendez-vous par conseiller</title>
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
<form action="statRdv.php" method="post">
    <label for="datedebut">Date de début :</label>
    <input type="date" name="datedebut" id="datedebut" value="<?php echo isset($_POST['datedebut']) ? $_POST['datedebut'] : ''; ?>" required><br>
    <label for="datefin">Date de fin :</label>
    <input type="date" name="datefin" id="datefin" value="<?php echo isset($_POST['datefin']) ? $_POST['datefin'] : ''; ?>" required><br>
    <button type="submit">Voir</button>
</form>
<?php
    
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $datedebut = $_POST['datedebut'];
        $datefin = $_POST['datefin'];

        // Requête SQL pour récupérer les données
        $sql = "SELECT nom, MONTH(dateRdv) AS mois, COUNT(*) AS nombre_rdv FROM rdv 
                JOIN employe ON rdv.NumEmploye = employe.Numemploye 
                WHERE dateRdv BETWEEN ? AND ? 
                GROUP BY nom, mois";

        // Préparation et exécution de la requête SQL avec PDO
        $stmt = $conn->prepare($sql);
        $stmt->execute([$datedebut, $datefin]);

        // Récupération des résultats de la requête
        $typesCompte = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Préparation des données pour le graphique circulaire
        $labelsPie = [];
        $valuesPie = [];

        // Préparation des données pour l'histogramme
        $labelsBar = array_values($moisEnLettres);
        $datasetsBar = [];

        // Création d'un tableau associatif pour regrouper les rendez-vous par mois pour chaque conseiller
        $dataByMonth = [];
        foreach ($typesCompte as $row) {
            $labelsPie[$row['nom']] = $row['nom'];
            if (!isset($valuesPie[$row['nom']])) {
                $valuesPie[$row['nom']] = 0;
            }
            $valuesPie[$row['nom']] += (int) $row['nombre_rdv'];

            if (!isset($dataByMonth[$row['nom']])) {
                $dataByMonth[$row['nom']] = array_fill(1, 12, 0); // Initialisation de tous les mois à 0
            }

            $dataByMonth[$row['nom']][$row['mois']] = $row['nombre_rdv'];

            // Incrémenter le nombre total de rendez-vous
            $totalRdv += (int) $row['nombre_rdv'];
        }

        // Préparation des données pour l'histogramme
        foreach ($dataByMonth as $nom => $moisData) {
            $datasetsBar[] = [
                'label' => $nom,
                'data' => array_values($moisData), // Les valeurs sont les nombres de rendez-vous pour chaque mois
                'backgroundColor' => "rgba(" . rand(0, 255) . ", " . rand(0, 255) . ", " . rand(0, 255) . ", 0.8)",
                'borderColor' => "rgba(" . rand(0, 255) . ", " . rand(0, 255) . ", " . rand(0, 255) . ", 1)",
                'borderWidth' => 1
            ];
        }

        // Données au format JSON pour le graphique circulaire
        $dataPie = [
            'labels' => array_values($labelsPie),
            'values' => array_values($valuesPie)
        ];

        // Inclure la bibliothèque Chart.js
        echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>';

        // Script JavaScript pour générer le graphique circulaire
        echo '<div style="width: 45%; display: inline-block;"><canvas id="myChartPie"></canvas>
        <script>
        var ctxPie = document.getElementById("myChartPie").getContext("2d");
        var myChartPie = new Chart(ctxPie, {
            type: "pie",
            data: {
                labels: ' . json_encode(array_values($labelsPie)) . ',
                datasets: [{
                    label: "Nombre de rendez-vous",
                    data: ' . json_encode(array_values($valuesPie)) . ',
                    backgroundColor: ' . json_encode(generateRandomColors(count($labelsPie))) . ',
                    borderColor: "#ffffff",
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
        </script></div>';

        // Données au format JSON pour l'histogramme
        $dataBar = [
            'labels' => $labelsBar,
            'datasets' => $datasetsBar
        ];

        // Script JavaScript pour générer l'histogramme
        echo '<div style="width: 45%; display: inline-block;"><canvas id="myChartBar"></canvas>
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
    }
} catch (PDOException $e) {
    // Gestion des erreurs PDO
    die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
}

// Fonction pour générer des couleurs aléatoires
function generateRandomColors($count)
{
    $colors = [];
    for ($i = 0; $i < $count; $i++) {
        $colors[] = "rgba(" . rand(0, 255) . ", " . rand(0, 255) . ", " . rand(0, 255) . ", 0.8)";
    }
    return $colors;
}
?>
</body>
</html>
