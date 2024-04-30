<?php
require('init.php');
checkAcl('auth');

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupère l'identifiant du compte client sélectionné dans le formulaire
    $idCompteClient = $_POST['idCompteClient'];
    
    // Récupère les autres informations nécessaires pour l'opération
    $montant = $_POST['montant'];
    $dateOperation = $_POST['dateOperation'];
    $typeOp = $_POST['typeOp'];
    
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
        echo "Une erreur s'est produite lors de l'enregistrement de l'opération.";
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
            <option value="<?php echo $compteClient['idCompteClient']; ?>">
                <?php echo "Client: " . $compteClient['nom'] . ' ' . $compteClient['prenom'] . ", N° Compte: " . $compteClient['idCompteClient']; ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>
    <label for="montant">Montant :</label>
    <input type="text" name="montant" id="montant"><br><br>
    <label for="dateOperation">Date de l'opération :</label>
    <input type="date" name="dateOperation" id="dateOperation"><br><br>
    <label for="typeOp">Type d'opération :</label>
    <input type="text" name="typeOp" id="typeOp"><br><br>
    <button type="submit">Réaliser l'opération</button>
</form>


