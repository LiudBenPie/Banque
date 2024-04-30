<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

$createSuccessful = false;

// Traitement du formulaire lorsqu'il est soumis
if (isset($_POST['action']) && $_POST['action'] === 'Créer') {
    // Récupérer les données du formulaire
    $montant = $_POST['montant'];
    $typeOp = $_POST['typeOp'];
    $idCompteClient = 1; // Remplacez par l'ID du compte client concerné

    // Validation des données (vous pouvez ajouter des validations supplémentaires ici)

    // Préparation et exécution de la requête SQL pour insérer l'opération
    $sql = "INSERT INTO Operation (montant, typeOp, dateOperation, idCompteClient) VALUES (?, ?, NOW(), ?)";
    $res = $conn->prepare($sql);
    if ($res->execute([$montant, $typeOp, $idCompteClient])) {
        $createSuccessful = true;
    }
    
    // Affichage d'une alerte si l'opération a été créée avec succès
    if ($createSuccessful) {
        echo '<script>alert("L\'opération a été enregistrée avec succès.");</script>';
    }
}
?>

<!-- Formulaire pour la création de l'opération -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" name="monForm">
    <p>
        <label for="montant">Montant :</label>
        <input type="number" name="montant" step="0.01" required>
    </p>
    <p>
        <label for="typeOp">Type d'opération :</label>
        <select name="typeOp" required>
            <option value="Dépôt">Dépôt</option>
            <option value="Retrait">Retrait</option>
        </select>
    </p>
    <!-- Champ caché pour l'action -->
    <input type="hidden" name="action" value="Créer">

    <p>
        <a href="../">Page précédente</a>
        <button type="submit">Créer</button>
    </p>
</form>
