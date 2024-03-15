<?php
require('connect.php');
// Récupération de la liste des employés
$sql = "SELECT numEmploye, nom, categorie FROM employe";
$stmt = $conn->prepare($sql);
$stmt->execute();
$employes = $stmt->fetchAll();
?>
<form action="modification.php" method="post">
    <label for="employe">Choisir un employé à modifier :</label>
    <select name="numEmploye" id="employe">
        <?php foreach ($employes as $employe): ?>
            <option value="<?php echo $employe['numEmploye']; ?>">
                <?php echo $employe['nom']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Modifier</button>
</form>

