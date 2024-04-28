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
  <div class="container">
        <form action="/authentification.php" method="post" >
        <h2>Connexion</h2>
                <div class="mb-3">
                    <label class="form-label" for="login">Identifiant :</label>
                    <input class="form-control" type="text" name="login" id="login" required>
                </div>
                <div class="mb-3">
                    <label for="motDePasse" class="form-label">Mot de passe</label>
                    <input class="form-control" type="password" name="motDePasse" id="motDePasse" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Se souvenir de moi</label>
                </div>
                <button type="submit" class="btn btn-primary" style="background-color: #003580;">Connexion</button>
        </form>
    </div>

    


</body>

</html>