<?php
require('init.php'); // Inclut le script d'initialisation de la base de données
checkAcl('auth'); // Vérifie les autorisations d'accès

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérifie si les champs requis ont été fournis
    if (isset($_POST['idCompteClient'], $_POST['montant'], $_POST['dateOperation'], $_POST['typeOp'])) {
        $idCompteClient = $_POST['idCompteClient'];
        $montant = $_POST['montant'];
        $dateOperation = $_POST['dateOperation'];
        $typeOp = $_POST['typeOp'];
        
        try {
            // Insertion de l'opération dans la base de données
            $sql = "INSERT INTO Operation (montant, dateOperation, typeOp, idCompteClient) 
                    VALUES (:montant, :dateOperation, :typeOp, :idCompteClient)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':montant', $montant);
            $stmt->bindParam(':dateOperation', $dateOperation);
            $stmt->bindParam(':typeOp', $typeOp);
            $stmt->bindParam(':idCompteClient', $idCompteClient);
            
            // Exécute la requête d'insertion
            if ($stmt->execute()) {
                echo "L'opération a été enregistrée avec succès.";
            } else {
                throw new Exception("Une erreur s'est produite lors de l'enregistrement de l'opération.");
            }
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        echo "Tous les champs sont requis.";
    }
}

include VIEWS_DIR . '/menu.php';

// Récupération de la liste des comptes clients avec les informations sur le client
$sql = "SELECT CompteClient.idCompteClient, CompteClient.numClient, Client.nom, Client.prenom, CompteClient.idCompteClient 
        FROM CompteClient 
        INNER JOIN Client ON CompteClient.numClient = Client.numClient";
$stmt = $conn->prepare($sql);
$stmt->execute();
$compteClients = $stmt->fetchAll();
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="compteClient">Sélectionnez le compte client pour l'opération :</label>
    <select name="idCompteClient" id="compteClient">
        <?php foreach ($compteClients as $compteClient) : ?>
            <option value="<?php echo htmlspecialchars($compteClient['idCompteClient']); ?>">
                <?php echo "Client: " . htmlspecialchars($compteClient['nom']) . ' ' . htmlspecialchars($compteClient['prenom']) . ", N° Compte: " . htmlspecialchars($compteClient['idCompteClient']); ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>
    <label for="montant">Montant :</label>
    <input type="text" name="montant" id="montant" required><br><br>
    <label for="dateOperation">Date de l'opération :</label>
    <input type="date" name="dateOperation" id="dateOperation" required><br><br>
    <label for="typeOp">Type d'opération :</label>
    <input type="text" name="typeOp" id="typeOp" required><br><br>
    <button type="submit">Réaliser l'opération</button>
</form>


