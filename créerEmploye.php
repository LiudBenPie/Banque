<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

$createSuccessful = false;

if (isset($_POST['action']) && !empty($_POST['nomEmploye']) && !empty($_POST['cate'])) {
    $nomEmploye = $_POST['nomEmploye'];
    $cate = $_POST['cate'];
    $mdp = "$2y$10$4ieMYxLS0BSGqTNQBwI.SOfFUG.VIQPq5cIjDQGg73Bbraw/9Cr1m";
    $sql = "INSERT INTO employe (`nom`, `login`, `motDePasse`, `categorie`) VALUES (?, ?, ?, ?)";
    $res = $conn->prepare($sql);
    if ($res->execute([$nomEmploye, $nomEmploye, $mdp, $cate])) {
        $createSuccessful = true;
    }
}
// Affiche une alerte si la création a été réussie
if ($createSuccessful) {
    echo '<script>alert("L\'employé a été crée avec succès.");</script>';
}
?>
<!-- Formulaire pour la création de l'employé -->
<form action="créerEmploye.php" method="post" name='monForm'>
    <p>
        <label for="nom">Nom de l'employé :</label>
        <input type="text" name="nomEmploye" required>
    </p>

    <p>
        <label for="login">Catégorie : </label>
        <select id="cate" name="cate" required>
                <option value="Directeur">Directeur</option>
                <option value="Agent">Agent</option>
                <option value="Conseiller">Conseiller</option>
        </select>
    </p>
    <p>
        <a href="../">Page précédente</a>
        <button type="submit" name="action" value="Créer">Créer</button>
    </p>
</form>