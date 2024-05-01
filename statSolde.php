<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
require('init.php'); // Inclure le fichier d'initialisation pour établir la connexion PDO
checkAcl('auth'); // Vérification des autorisations (ACL)
include VIEWS_DIR . '/menu.php'; // Inclusion du menu (si nécessaire)

try {
    // Requête SQL pour récupérer la somme des soldes
    $sql = "SELECT SUM(solde) AS somme_solde FROM compteclient";
    
    // Préparation et exécution de la requête SQL avec PDO
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Récupération du résultat
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Affichage de la somme des soldes
    echo "La somme des soldes des comptes clients est de : " . $result['somme_solde'];
    
    // Requête SQL pour récupérer les soldes des clients
    $sql = "SELECT SUM(solde) AS solde_client, nom, prenom FROM compteclient JOIN client ON client.Numclient = compteclient.Numclient GROUP BY nom, prenom";
    
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
        $labels[] = $row['nom'] . ' ' . $row['prenom'];
        $values[] = (int) $row['solde_client'];
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
                label: "Solde des clients",
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
                    text: "répartion des soldes des clients"
                }
            },
        }
    });
    </script></div>';
} catch (PDOException $e) {
    // Gestion des erreurs PDO
    echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
}
?>
</body>
</html>