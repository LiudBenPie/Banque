<?php
require('../init.php');
checkAcl('guest');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>
    <form action="/authentification.php" method="post">
        <p>
            <label for="">Identifiant :</label>
            <input type="text" name="login" required>
        </p>
        <p>
            <label for="">Mot de passe :</label>
            <input type="password" name="motDePasse" required>
        </p>
        <p>
            <input type="submit" value="Connexion">
        </p>
    </form>
</body>
</html>
