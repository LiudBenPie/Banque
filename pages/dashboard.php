<?php
require('../init.php');
checkAcl('auth');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>dashbord</title>
    <link rel="stylesheet" href="style_directeur.css">
</head>
<body>
    <div class="container">
    <?php
        if($auth->checkRole('Directeur')){
            include VIEWS_DIR. '/roles/directeur.php';
        }
        elseif($auth->checkRole('Agent')){
            include VIEWS_DIR. '/roles/agent.php';
        }
        elseif($auth->checkRole('Conseiller')){
            include VIEWS_DIR. '/roles/conseiller.php';
        }
    ?>
       
    </div>
    <a href="/logout.php">Deconnexion</a>
</body>
</html>
