<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>

<?php
require('../init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';
$user = $auth->getUser();
?>
<div class="container">
    <h1>Bonjour <?php echo $user['nom']; ?>,</h1>
    <p>Bienvenue sur le tableau de bord de la banque.</p>
    <p>Vous pouvez naviguer dans le menu pour accéder aux différentes fonctionnalités.</p>
    <p>Si vous avez des questions, n'hésitez pas à contacter le support.</p>
</div>
</body>

</html>