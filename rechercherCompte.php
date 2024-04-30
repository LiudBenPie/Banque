<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une opération</title>
</head>
<body>
    <h2>Ajouter une opération</h2>

    <?php
    // Inclure le fichier d'initialisation et vérifier les autorisations d'accès
    require('init.php');
    checkAcl('auth');

    // Inclure le menu
    include VIEWS_DIR . '/menu.php';

    $createSuccessful = false;

    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les données du formulaire
        $montant = $_POST['montant'];
        $date_operation = $_POST['date_operation'];
        $type_operation = $_POST['type_operation'];
        $id_compte_client = $_POST['id_compte_client'];

        // Requête d'insertion
        $sql = "INSERT INTO Operation (montant, dateOperation, typeOp, idCompteClient)
                VALUES ('$montant', '$date_operation', '$type_operation', '$id_compte_client')";

        // Exécuter la requête d'insertion
        if ($conn->query($sql) === TRUE) {
            $createSuccessful = true;
        } else {
            echo "Erreur lors de l'ajout de l'opération : " . $conn->error;
        }
    }
    ?>

    <?php
    // Afficher un message de succès si l'opération a été ajoutée avec succès
    if ($createSuccessful) {
        echo "Opération ajoutée avec succès.";
    }
    ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="montant">Montant :</label>
        <input type="text" name="montant" id="montant" required><br><br>
        
        <label for="date_operation">Date de l'opération :</label>
        <input type="date" name="date_operation" id="date_operation" required><br><br>
        
        <label for="type_operation">Type d'opération :</label>
        <select name="type_operation" id="type_operation" required>
            <option value="Dépôt">Dépôt</option>
            <option value="Retrait">Retrait</option>
        </select><br><br>
        
        <label for="id_compte_client">ID du compte client :</label>
        <input type="text" name="id_compte_client" id="id_compte_client" required><br><br>
        
        <input type="submit" value="Ajouter l'opération">
    </form>
</body>
</html>




