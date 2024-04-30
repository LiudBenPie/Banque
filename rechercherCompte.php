<?php
// Inclusion du fichier d'initialisation de la base de données
require('init.php');

// Vérification des autorisations (fonction non définie dans l'extrait)
checkAcl('auth');

// Inclusion du fichier de menu (constante VIEWS_DIR non définie dans l'extrait)
include VIEWS_DIR . '/menu.php';

// Activation de l'affichage des erreurs PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Traitement du formulaire lorsqu'il est soumis
        if (isset($_POST['montant'], $_POST['date_operation'], $_POST['type_operation'], $_POST['id_compte_client'])) {
            // Récupération des données du formulaire
            $montant = $_POST['montant'];
            $dateOperation = $_POST['date_operation'];
            $typeOperation = $_POST['type_operation'];
            $idCompteClient = $_POST['id_compte_client'];

            // Insertion des données dans la table Operation
            $sql = "INSERT INTO Operation (montant, dateOperation, typeOp, idCompteClient) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            // Exécution de la requête d'insertion avec gestion des erreurs PDO
            if ($stmt->execute([$montant, $dateOperation, $typeOperation, $idCompteClient])) {
                echo '<script> alert ("L\'opération a été ajoutée à la base de données.");</script>';
            } else {
                // Affichage d'une alerte JavaScript avec le message d'erreur PDO
                echo '<script> alert("Une erreur est survenue lors de l\'ajout de l\'opération : ' . $stmt->errorInfo()[2] . '");</script>';
            }
        }
    }
} catch (PDOException $e) {
    // Gestion des erreurs PDO
    $msg = 'ERREUR dans ' . $e->getFile() . 'Ligne' . $e->getLine() . ':' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter une opération</title>
    <link rel="stylesheet" href="formstyle.css">
</head>

<body>
    <div class="container mt-5" style="max-width: 700px;">
        <form method="post" action="rechercherCompte.php" class="row g-3 rounded shadow">
            <legend>Ajouter une nouvelle opération</legend>
            <div class="form-group">
                <label for="montant" class="form-label">Montant :</label>
                <input type="number" class="form-control" id="montant" name="montant" required>
            </div>
            <div class="form-group">
                <label for="date_operation" class="form-label">Date de l'opération :</label>
                <input type="date" class="form-control" id="date_operation" name="date_operation" required>
            </div>
            <div class="form-group">
                <label for="type_operation" class="form-label">Type d'opération :</label>
                <input type="text" class="form-control" id="type_operation" name="type_operation" required>
            </div>
            <div class="form-group">
                <label for="id_compte_client" class="form-label">Identifiant du compte client :</label>
                <input type="number" class="form-control" id="id_compte_client" name="id_compte_client" required>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button type="submit" class="btn">Ajouter Opération</button>
            </div>
        </form>
</body>

</html>