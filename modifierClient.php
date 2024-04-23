<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

$updateSuccessful = false;

// Vérifie si le formulaire a été soumis
if (isset($_POST['action']) && $_POST['action'] === 'modifier' && isset($_POST['numClient'])) {
    $numClient = $_POST['numClient'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $mail = $_POST['mail'];
    $numTel = $_POST['numTel'];
    $situation = $_POST['situation'];
    $dateNaissance = $_POST['dateNaissance'];

    // Prépare et exécute la requête SQL pour mettre à jour les informations du client
    $sql = "UPDATE Client SET nom = ?, prenom = ?, adresse = ?, mail = ?, numTel = ?, situation = ?, dateNaissance = ? WHERE numClient = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nom, $prenom, $adresse, $mail, $numTel, $situation, $dateNaissance, $numClient]);

    // Marque que la mise à jour a été réussie
    $updateSuccessful = true;
}

// Récupère les informations du client après la mise à jour ou si l'ID est spécifié
if (isset($_POST['numClient'])) {
    $numClient = $_POST['numClient'];
    $sql = "SELECT * FROM Client WHERE numClient = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$numClient]);
    $client = $stmt->fetch();
}

// Affiche une alerte si la mise à jour a été réussie
if ($updateSuccessful) {
    echo '<script>alert("Les informations du client ont été mises à jour avec succès.");</script>';
}
?>

<!-- Formulaire pour la mise à jour des informations du client -->
<form action="modifierClient.php" method="post" name='monForm'>
    <fieldset>
        <legend>INFORMATION DU CLIENT</legend>
        <!-- Champs du formulaire avec les informations à jour du client -->
        <p>
            <label for="num">ID Client :</label>
            <input type="text" name="numClient" value="<?php echo htmlspecialchars($client['numClient'] ?? ''); ?>" readonly>
        </p>
        <p>
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($client['nom'] ?? ''); ?>">
        </p>
        <p>
            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($client['prenom'] ?? ''); ?>">
        </p>
        <p>
            <label for="adresse">Adresse:</label>
            <input type="text" id="adresse" name="adresse" value="<?php echo htmlspecialchars($client['adresse'] ?? ''); ?>">
        </p>
        <p>
            <label for="mail">Mail :</label>
            <input type="email" id="mail" name="mail" value="<?php echo htmlspecialchars($client['mail'] ?? ''); ?>">
        </p>
        <p>
            <label for="numTel">Numéro de Téléphone :</label>
            <input type="text" id="numTel" name="numTel" value="<?php echo htmlspecialchars($client['numTel'] ?? ''); ?>">
        </p>
        <p>
            <label for="dateNaissance">Date de naissance :</label>
            <input type="date" id="dateNaissance" name="dateNaissance" value="<?php echo htmlspecialchars($client['dateNaissance'] ?? ''); ?>">
        </p>
        <p>
            <label for="situation">Situation :</label>
            <select id="situations" name="situation">
            <?php
                $sql = "SELECT numClient, situation FROM Client";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $clients=$stmt->fetchAll();
                foreach ($clients as $client) {
                    $selected = '';
                    if ($client['numClient']== $numClient) {
                        $selected = 'selected';
                    }
    
                    echo '<option ' . $selected .' value="' . $client['situation'] . '">' . $client['situation'].' </option>';
                }               
                         
            ?>
            </select>       
        </p>
        <p>
            <button><a href="../" class="link">Page précédente</a></button>
            <button type="submit" name="action" value="modifier">Mettre à jour</button>
        </p>
    </fieldset>
</form>
