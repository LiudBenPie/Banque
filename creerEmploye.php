<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

$createSuccessful = false;

if (isset($_POST['action']) && !empty($_POST['nomEmploye']) && !empty($_POST['login']) && !empty($_POST['motDePasse']) && !empty($_POST['categorie'])) {
    $nomEmploye = $_POST['nomEmploye'];
    $login = $_POST['login'];
    $motDePasse = $_POST['motDePasse'];
    $hashedPassword = password_hash($motDePasse, PASSWORD_DEFAULT);
    $categorie = $_POST['categorie'];
    $sql = "INSERT INTO employe (`nom`, `login`, `motDePasse`, `categorie`) VALUES (?, ?, ?, ?)";
    $res = $conn->prepare($sql);
    if ($res->execute([$nomEmploye, $login, $hashedPassword, $categorie])) {
        $createSuccessful = true;
    }
}
// Affiche une alerte si la création a été réussie
if ($createSuccessful) {
    echo '<script>alert("L\'employé a été créé avec succès.");</script>';
}
?>
<!-- Formulaire pour la création de l'employé -->
<form action="creerEmploye.php" method="post" name='monForm'>
    <p>
        <label for="nomEmploye">Nom de l'employé :</label>
        <input type="text" name="nomEmploye" id="nomEmploye" required>
    </p>
    <p>
        <label for="login">Login :</label>
        <input type="text" name="login" id="login" required>
    </p>
    <p>
        <label for="motDePasse">Mot de passe :</label>
        <input type="password" name="motDePasse" id="motDePasse" required>
    </p>

    <p>
        <label for="categorie">Catégorie : </label>
        <select id="categorie" name="categorie"  required>
            <option value="Directeur">Directeur</option>
            <option value="Agent">Agent</option>
            <option value="Conseiller">Conseiller</option>
        </select>
    </p>
    <p>
        <button type="submit" name="action" value="Créer">Créer</button>
    </p>
</form>