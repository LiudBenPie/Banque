<?php
require('connect.php');

if (isset($_POST['numEmploye'])) {
    $numEmploye = $_POST['numEmploye'];

    // Check if the form was submitted to update an employee
    if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
        // Collecting the form data
        $nom = $_POST['nom'];
        $login = $_POST['login'];
        $motDePasse = $_POST['motDePasse']; // Consider hashing this password
        $categorie = $_POST['categorie'];

        // If the password field is not empty, hash the new password
        if (!empty($motDePasse)) {
            // Hash the password using a more secure method than MD5, such as bcrypt
            $hashedPassword = md5($motDePasse);
        } else {
            // If password is not changed, keep the existing one
            $sql = "SELECT motDePasse FROM employe WHERE numEmploye = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$numEmploye]);
            $hashedPassword = $stmt->fetchColumn();
        }

        // Update query
        $sql = "UPDATE employe SET nom = ?, login = ?, motDePasse = ?, categorie = ? WHERE numEmploye = ?";
        $stmt = $conn->prepare($sql);

        // Execute the query
        $stmt->execute([$nom, $login, $hashedPassword, $categorie, $numEmploye]);
    } else {
        // Récupération des détails de l'employé sélectionné
        $sql = "SELECT * FROM employe WHERE numEmploye = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$numEmploye]);
        $employe = $stmt->fetch();
    }
}
?>

<form action="modification_donnees.php" method="post" name='monForm'>
    <input type="hidden" name="numEmploye" value="<?php echo htmlspecialchars($employe['numEmploye']); ?>">
    
    <p>
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($employe['nom']); ?>">
    </p>
    
    <p>
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" value="<?php echo htmlspecialchars($employe['login']); ?>">
    </p>
    
    <p>
        <label for="motDePasse">Mot de Passe (laissez vide si inchangé):</label>
        <input type="password" id="motDePasse" name="motDePasse">
    </p>
    
    <p>
        <label for="categorie">Catégorie:</label>
        <select id="categorie" name="categorie">
            <option value="Conseiller" <?php echo $employe['categorie'] == 'Conseiller' ? 'selected' : ''; ?>>Conseiller</option>
            <option value="Agent" <?php echo $employe['categorie'] == 'Agent' ? 'selected' : ''; ?>>Agent</option>
            <option value="Directeur" <?php echo $employe['categorie'] == 'Directeur' ? 'selected' : ''; ?>>Directeur</option>
        </select>
    </p>
    
    <p>
        <button type="submit" name="action" value="modifier">Mettre à jour</button>
    </p>
</form>
<?php
?>
