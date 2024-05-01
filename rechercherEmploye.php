<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Employé</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    require('init.php');
    checkAcl('auth');
    include VIEWS_DIR . '/menu.php';
    // Récupération de la liste des employés
    $sql = "SELECT numEmploye, nom, categorie FROM employe";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $employes = $stmt->fetchAll();
    ?>
    <div class="container">
        <h2>Modifier un Employé</h2>
        <form action="modifierEmploye.php" method="post">
            <div class="form-group">
                <label for="employe">Choisir un employé à modifier :</label>
                <select name="numEmploye" id="employe">
                    <?php foreach ($employes as $employe): ?>
                        <option value="<?php echo $employe['numEmploye']; ?>">
                            <?php echo $employe['nom']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit">Modifier</button>
            </div>
        </form>
    </div>
</body>

</html>

