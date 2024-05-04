<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création d'un type de compte</title>
    <link rel="stylesheet" href="/static/css/formstyle.css">
</head>

<body>
    <?php
    require('../../init.php');
    checkAcl('auth');
    include VIEWS_DIR . '/menu.php';

    $createSuccessful = false;

    if (isset($_POST['action']) && !empty($_POST['nomcompte'])) {
        $nomcompte = $_POST['nomcompte'];
        $description = $_POST['description'];
        $sql = "INSERT INTO compte (nomTypeCompte,description) VALUES (?,?)";
        $res = $conn->prepare($sql);
        if ($res->execute([$nomcompte,$description])) {
            $createSuccessful = true;
        }
    }
    // Affiche une alerte si la création a été réussie
    if ($createSuccessful) {
        echo '<script>alert("Le type de compte a été créé avec succès.");</script>';
    }
    ?>
    <!-- Formulaire pour la création du contrat -->
    <div class="container mt-5" style="max-width: 700px;">
        <form action="creerCompte.php" method="post" name='monForm' class="row g-3 rounded shadow">
            <legend>Création d'un type de compte</legend>
            <div class="form-group">
                <label for="nomcompte">Nom du type de compte :</label>
                <input type="text" name="nomcompte" id="nomcompte" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description : </label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button type="submit" name="action" value="Créer" class="btn btn-outline-warning">Créer</button>
            </div>
        </form>
    </div>
</body>

</html>