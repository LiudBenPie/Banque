<?php
require('../init.php');
checkAcl('guest');
//echo password_hash('password', PASSWORD_DEFAULT);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="row">

        <form action="/authentification.php" method="post" class="mx-auto col-3">
            <h2>Connexion</h2>
            <p>
                <label class="form-label" for="">Identifiant :</label>
                <input class="form-control" type="text" name="login" required>
            </p>
            <p>
                <label class="form-label" for="">Mot de passe :</label>
                <input class="form-control" type="password" name="motDePasse" required>
            </p>
            <p>
                <input class="form-control" type="submit" value="Connexion">
            </p>
        </form>
    </div>
</body>

</html>