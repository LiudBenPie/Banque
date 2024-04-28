<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

// Récupération de la liste des comptes clients avec les informations sur le client
$sql = "SELECT CompteClient.idCompteClient, CompteClient.numClient, Client.nom, Client.prenom, CompteClient.solde 
        FROM CompteClient 
        INNER JOIN Client ON CompteClient.numClient = Client.numClient";
$stmt = $conn->prepare($sql);
$stmt->execute();
$compteClients = $stmt->fetchAll();

// Traitement de la suppression du compte client
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idCompteClient'])) {
    $idCompteClient = $_POST['idCompteClient'];

    // Récupération du solde du compte client
    $sqlSolde = "SELECT solde FROM CompteClient WHERE idCompteClient = ?";
    $stmtSolde = $conn->prepare($sqlSolde);
    $stmtSolde->execute([$idCompteClient]);
    $solde = $stmtSolde->fetchColumn();

    // Vérification du solde du compte avant suppression
    if ($solde == 0) {
        try {
            // Suppression des opérations associées à ce compte client
            $sqlDeleteOperations = "DELETE FROM Operation WHERE idCompteClient = ?";
            $stmtDeleteOperations = $conn->prepare($sqlDeleteOperations);
            $stmtDeleteOperations->execute([$idCompteClient]);

            // Requête pour supprimer le compte client spécifié
            $sqlDelete = "DELETE FROM CompteClient WHERE idCompteClient = ?";
            $stmtDelete = $conn->prepare($sqlDelete);
            $stmtDelete->execute([$idCompteClient]);

            // Redirection vers une page de confirmation ou de gestion des comptes
            header("Location: supprimerCompteClient.php");
            exit;
        } catch (PDOException $e) {
            // En cas d'erreur SQL, afficher le message d'erreur
            echo "Erreur SQL lors de la suppression du compte client : " . $e->getMessage();
        }
    } else {
        echo "Impossible de supprimer le compte car le solde n'est pas nul.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un compte client</title>
</head>
<body>

<form action="supprimerCompteClient.php" method="post">
    <label for="compteClient">Sélectionnez le compte client à supprimer :</label>
    <select name="idCompteClient" id="compteClient">
        <?php foreach ($compteClients as $compteClient) : ?>
            <option value="<?php echo $compteClient['idCompteClient']; ?>">
                <?php echo "Client: " . htmlspecialchars($compteClient['nom']) . ' ' . htmlspecialchars($compteClient['prenom']) . ", Solde: " . htmlspecialchars($compteClient['solde']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Supprimer le compte</button>
</form>

</body>
</html>

