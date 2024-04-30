<?php
require('init.php'); // Inclusion du fichier d'initialisation de la base de données
checkAcl('auth'); // Vérification des autorisations (fonction non définie dans l'extrait)
include VIEWS_DIR . '/menu.php'; // Inclusion du fichier de menu (constante VIEWS_DIR non définie dans l'extrait)

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
            if ($stmt->execute([$montant, $dateOperation, $typeOperation, $idCompteClient])) {
                echo '<script> alert ("L\'opération a été ajoutée à la base de données.");</script>';
            } else {
                echo '<script> alert("Une erreur est survenue lors de l\'ajout de l\'opération.");</script>';
            }
        }
    }
} catch (PDOException $e) {
    $msg = 'ERREUR dans ' . $e->getFile() . 'Ligne' . $e->getLine() . ':' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une opération</title>
</head>
<body>
    <h2>Ajouter une nouvelle opération</h2>
    <form method="post" action="">
        <label for="montant">Montant :</label>
        <input type="text" id="montant" name="montant" required><br><br>

        <label for="date_operation">Date de l'opération :</label>
        <input type="date" id="date_operation" name="date_operation" required><br><br>

        <label for="type_operation">Type d'opération :</label>
        <input type="text" id="type_operation" name="type_operation" required><br><br>

        <label for="id_compte_client">Identifiant du compte client :</label>
        <input type="text" id="id_compte_client" name="id_compte_client" required><br><br>

        <button type="submit">Ajouter Opération</button>
    </form>
</body>
</html>







