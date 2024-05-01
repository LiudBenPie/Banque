<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Création d'un type de compte</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    require('init.php');
    checkAcl('auth');
    include VIEWS_DIR . '/menu.php';

    $createSuccessful = false;

    if (isset($_POST['action']) && !empty($_POST['nomcompte'])) {
        $nomCompte = $_POST['nomcompte'];
        $description = $_POST['description'];
        $sql = "INSERT INTO compte (nomTypeCompte, description) VALUES (?, ?)";
        $res = $conn->prepare($sql);
        if ($res->execute([$nomCompte, $description])) {
            $createSuccessful = true;
        }
    }
    // Affiche une alerte si la création a été réussie
    if ($createSuccessful) {
        echo '<script>alert("Le type de compte a été créé avec succès.");</script>';
    }
    ?>
    <!-- Formulaire pour la création du type de compte -->
    <form action="creerCompte.php" method="post" name='monForm'>
        <p>
            <label for="nomcompte">Nom du type de compte :</label>
            <input type="text" name="nomcompte" id="nomcompte" required>
        </p>
        <p>
            <label for="description">Description : </label>
            <textarea name="description" id="description" required></textarea>
        </p>
        <p>
            <a href="../">Page précédente</a>
            <button type="submit" name="action" value="Créer">Créer</button>
        </p>
    </form>
</body>

</html>