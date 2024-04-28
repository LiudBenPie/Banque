<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idCompteClient'])) {
    $idCompteClient = $_POST['idCompteClient'];

    try {
        // Requête pour supprimer le compte client avec cascade
        $sqlDelete = "DELETE FROM CompteClient WHERE idCompteClient = ?";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->execute([$idCompteClient]);

        // Redirection vers une page de confirmation ou de gestion des comptes
        header("Location: gestionComptes.php");
        exit;
    } catch (PDOException $e) {
        // En cas d'erreur SQL, afficher le message d'erreur
        echo "Erreur SQL lors de la suppression du compte client : " . $e->getMessage();
    }
}

// Récupération de la liste des comptes clients avec les informations sur le client
$sql = "SELECT idCompteClient, numClient, solde FROM CompteClient";
$stmt = $conn->prepare($sql);
$stmt->execute();
$compteClients = $stmt->fetchAll();
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
                <?php echo "ID Compte: " . htmlspecialchars($compteClient['idCompteClient']) . ", Solde: " . htmlspecialchars($compteClient['solde']); ?>
            </option>
        <?php endforeach; ?>
    </select>
   
