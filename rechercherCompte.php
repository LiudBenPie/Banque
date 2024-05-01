<?php
require('init.php'); // Inclut le script d'initialisation de la base de données
checkAcl('auth'); // Vérifie les autorisations d'accès
include VIEWS_DIR . '/menu.php';

try {
    // Vérifie si les champs requis ont été fournis
    if (isset($_POST['realiseroperation'], $_POST['compteClient'], $_POST['montant'], $_POST['dateOperation'], $_POST['typeOp'])) {
        // Récupération des données du formulaire
        $idCompteClient = $_POST['compteClient'];
        $montant = $_POST['montant'];
        $dateOperation = $_POST['dateOperation'];
        $typeOp = $_POST['typeOp'];
        
        // Insertion de l'opération dans la base de données
        $sql = "INSERT INTO Operation (montant, dateOperation, typeOp, idCompteClient) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute([$montant, $dateOperation, $typeOp, $idCompteClient])) {
            echo "L'opération a été enregistrée avec succès.";
        } else {
            echo "Une erreur s'est produite lors de l'enregistrement de l'opération.";
        }
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<form action="rechercherCompte.php" method="post">
    <label for="compteClient">Sélectionnez le compte client pour l'opération :</label>
    <select name="compteClient" id="compteClient" required>
        <?php
        // Récupération de la liste des comptes clients avec les informations sur le client
        $sql = "SELECT cc.idCompteClient, c.nom, c.prenom FROM CompteClient AS cc JOIN Client AS c ON cc.numClient = c.numClient";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $compteClients = $stmt->fetchAll();

        foreach ($compteClients as $compteClient) {
            echo "<option value=\"{$compteClient['idCompteClient']}\">{$compteClient['nom']} {$compteClient['prenom']}</option>";
        }
        ?>
    </select><br><br>
    <label for="montant">Montant :</label>
    <input type="number" name="montant" id="montant" required><br><br>
    <label for="dateOperation">Date de l'opération :</label>
    <input type="date" name="dateOperation" id="dateOperation" required><br><br>
    <label for="typeOp">Type d'opération :</label>
    <input type="text" name="typeOp" id="typeOp" required><br><br>
    <button type="submit" name="realiseroperation">Réaliser l'opération</button>
</form>
