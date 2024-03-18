<?php
require('connect.php');

$updateSuccessful = false;

if (isset($_POST['numEmploye'])) {
    $numEmploye = $_POST['numEmploye'];

    if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
        $nom = $_POST['nom'];
        $login = $_POST['login'];
        $motDePasse = $_POST['motDePasse'];
        $categorie = $_POST['categorie'];

        if (!empty($motDePasse)) {
            $hashedPassword = md5($motDePasse); // Consider using a more secure hashing algorithm
        } else {
            $sql = "SELECT motDePasse FROM employe WHERE numEmploye = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$numEmploye]);
            $hashedPassword = $stmt->fetchColumn();
        }

        $sql = "UPDATE employe SET nom = ?, login = ?, motDePasse = ?, categorie = ? WHERE numEmploye = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nom, $login, $hashedPassword, $categorie, $numEmploye]);

        $_SESSION['updateSuccess'] = true;
        $updateSuccessful = true; 

    } else {
        $sql = "SELECT * FROM employe WHERE numEmploye = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$numEmploye]);
        $employe = $stmt->fetch();
    }
}
// Display the message and unset it so it doesn't persist on page refresh
// At the very end of your PHP script, before closing the PHP tag
if (isset($_SESSION['updateSuccess'])) {
    unset($_SESSION['updateSuccess']); // Unset the variable to prevent future alerts
}
?>

<form action="modifierEmploye.php" method="post" name='monForm'>

        <input type="hidden" name="numEmploye" value="<?php echo isset($employe['numEmploye']) ? htmlspecialchars($employe['numEmploye']) : ''; ?>">

    <p>
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?php echo isset($employe['nom']) ? htmlspecialchars($employe['nom']) : ''; ?>">
    </p>

    <p>
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" value="<?php echo isset($employe['login']) ? htmlspecialchars($employe['login']) : ''; ?>">
    </p>

    
    <p>
        <label for="motDePasse">Mot de Passe (laissez vide si inchangé):</label>
        <input type="password" id="motDePasse" name="motDePasse">
    </p>
    
    <p>
        <label for="categorie">Catégorie:</label>
        <select id="categorie" name="categorie">
            <option value="Conseiller" <?php echo (isset($employe['categorie']) && $employe['categorie'] == 'Conseiller') ? 'selected' : ''; ?>>Conseiller</option>
            <option value="Agent" <?php echo (isset($employe['categorie']) && $employe['categorie'] == 'Agent') ? 'selected' : ''; ?>>Agent</option>
            <option value="Directeur" <?php echo (isset($employe['categorie']) && $employe['categorie'] == 'Directeur') ? 'selected' : ''; ?>>Directeur</option>
        </select>
    </p>
    
    <p>
        <button type="submit" name="action" value="modifier">Mettre à jour</button>
    </p>
</form>



<script type="text/javascript">
  window.onload = function() {
    // If the PHP variable indicates success, show the message
    <?php if ($updateSuccessful): ?>
    alert('Les valeurs ont été modifiées avec succès.');
    <?php endif; ?>
  }
</script>
