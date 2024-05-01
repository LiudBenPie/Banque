<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création d'une Opération</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    require('init.php');
    checkAcl('auth');
    include VIEWS_DIR . '/menu.php';

    $createSuccessful = false;

    if (isset($_POST['action'])) {
        $montant = $_POST['montant'];
        $dateOperation = $_POST['dateOperation'];
        $typeOp = $_POST['typeOp'];
        $idCompteClient = $_POST['idCompteClient'];

        
        $sql = "INSERT INTO operation (montant, dateOperation, typeOp, idCompteClient) VALUES (?, ?, ?, ?)";
        $res = $conn->prepare($sql);
        $res->execute([$montant, $dateOperation, $typeOp, $idCompteClient]);
        $createSuccessful = true;
    }

    // Affiche une alerte si la création a été réussie
    if ($createSuccessful) {
        echo '<script>alert("L\'opération a été créée avec succès.");</script>';
    }
    ?>
    <div class="container">
        <h2>Création d'une Opération</h2>
        <!-- Formulaire pour la création de l'opération -->
        <form action="rechercherCompte.php" method="post" name='monForm'>
            <div class="form-group">
                <label for="montant">Montant :</label>
                <input type="number" name="montant" id="montant" required>
            </div>
            <div class="form-group">
                <label for="dateOperation">Date de l'opération :</label>
                <input type="date" name="dateOperation" id="dateOperation" required>
            </div>
            <div class="form-group">
                <label for="typeOp">Type de l'opération :</label>
                <input type="text" name="typeOp" id="typeOp" required>
            </div>
            <div class="form-group">
                <label for="idCompteClient">ID du compte client :</label>
                <input type="text" name="idCompteClient" id="idCompteClient" required>
            </div>
            <div class="form-group">
                <a href="../" id="previousPage">Page précédente</a>
                <button type="submit" name="action" value="Créer" id="createOperation">Créer</button>
            </div>
        </form>
    </div>
</body>
</html>