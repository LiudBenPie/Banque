<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un employé</title>
    <link rel="stylesheet" href="/static/css/formstyle.css">
</head>

<body>
    <?php
    require('../../init.php');
    checkAcl('auth');
    include VIEWS_DIR . '/menu.php';

    $createSuccessful = false;

    if (isset($_POST['action']) && !empty($_POST['nomEmploye']) && !empty($_POST['login']) && !empty($_POST['motDePasse']) && !empty($_POST['categorie'])) {
        $nomEmploye = $_POST['nomEmploye'];
        $login = $_POST['login'];
        $motDePasse = $_POST['motDePasse'];
        $hashedPassword = password_hash($motDePasse, PASSWORD_DEFAULT);
        $categorie = $_POST['categorie'];
        $actif =$_POST ['actif'];
        $sql = "INSERT INTO employe (`nom`, `login`, `motDePasse`, `categorie`, `actif`) VALUES (?, ?, ?, ?, ?)";
        $res = $conn->prepare($sql);
        if ($res->execute([$nomEmploye, $login, $hashedPassword, $categorie, $actif])) {
            $createSuccessful = true;
        }
    }
    // Affiche une alerte si la création a été réussie
    if ($createSuccessful) {
        echo '<script>alert("L\'employé a été créé avec succès.");</script>';
    }
    ?>
    <!-- Formulaire pour la création de l'employé -->
    <div class="container mt-5" style="max-width: 700px;">
        <form action="creerEmploye.php" method="post" name="monForm" class="row g-3 rounded shadow">
            <legend>Créer un nouveau employé</legend>
            <div class="form-group">
                <label for="nomEmploye" class="form-label">Nom de l'employé :</label>
                <input type="text" name="nomEmploye" id="nomEmploye" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="login" class="form-label">Login :</label>
                <input type="text" name="login" id="login" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="motDePasse" class="form-label">Mot de passe :</label>
                <input type="password" name="motDePasse" id="motDePasse" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="categorie" class="form-label">Catégorie : </label>
                <select id="categorie" name="categorie" required>
                    <option value="Directeur">Directeur</option>
                    <option value="Agent">Agent</option>
                    <option value="Conseiller">Conseiller</option>
                </select>
            </div>
            <div class="form-group">
                <input type="hidden" name="actif" value="1" ?>">
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button type="submit" name="action" value="Créer" class="btn">Créer</button>
            </div>
        </form>
</body>

</html>