<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Création d'un nouveau motif</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    require('init.php');
    checkAcl('auth');
    include VIEWS_DIR . '/menu.php';

    $createSuccessful = false;

    if (isset($_POST['action']) && !empty($_POST['libellemotif']) && !empty($_POST['listepiece'])) {
        $libellemotif = $_POST['libellemotif'];
        $listepiece= $_POST['listepiece'];
        $sql = "INSERT INTO motif (libelleMotif,listePieces) VALUES (?,?)";
        $res = $conn->prepare($sql);
        if ($res->execute([$libellemotif,$listepiece])) {
            $createSuccessful = true;
        }
    }
    // Affiche une alerte si la création a été réussie
    if ($createSuccessful) {
        echo '<script>alert("Le nouveau motif a été créé avec succès.");</script>';
    }
    ?>
    <!-- Formulaire pour la création du motif -->
    <form action="creerMotif.php" method="post" name='monForm'>
        <p>
            <label for="libellemotif">Libellé du motif :</label>
            <input type="text" name="libellemotif" id="libellemotif" required>
        </p>
        <p>
            <label for="listepiece">Liste des pièces : </label>
            <textarea name="listepiece" id="listepiece" required></textarea>
        </p>
        <p>
            <button type="submit" name="action" value="Créer">Créer le motif</button>
        </p>
    </form>
</body>

</html>