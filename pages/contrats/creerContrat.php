<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Créer un type de Contrat</title>
</head>

<body>
    <?php
    require('../../init.php');
    checkAcl('auth');
    include VIEWS_DIR . '/menu.php';

    $createSuccessful = false;

    if (isset($_POST['action']) && !empty($_POST['nomContrat'])) {
        $nomContrat = $_POST['nomContrat'];
        $description = $_POST['description'];
        $sql = "INSERT INTO contrat (nomTypeContrat, description) VALUES (?, ?)";
        $res = $conn->prepare($sql);
        if ($res->execute([$nomContrat, $description])) {
            $createSuccessful = true;
        }
    }
    // Affiche une alerte si la création a été réussie
    if ($createSuccessful) {
        echo '<script>alert("Le type de contrat a été créé avec succès.");</script>';
    }
    ?>
    <!-- Formulaire pour la création du contrat -->
    <form action="creerContrat.php" method="post" name='monForm'>
        <p>
            <label for="nomContrat">Nom du contrat :</label>
            <input type="text" name="nomContrat" id="nomContrat" required>
        </p>
        <p>
            <label for="description">Description :</label>
            <textarea name="description" id="description" required></textarea>
        </p>
        <p>
            <a href="../..">Page précédente</a>
            <button type="submit" name="action" value="Créer">Créer</button>
        </p>
    </form>
</body>
</html>
