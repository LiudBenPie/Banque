<?php
require('init.php');
checkAcl('auth');

// Initialisation des variables pour le retour JSON
$response = array('success' => false, 'message' => '');

// Vérification de la méthode de requête et de la présence du paramètre
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['numContrat'])) {
    $idContratClient = $_POST['numContrat'];

    try {
        // Suppression du contrat client spécifié
        $sqlDeleteContrat = "DELETE FROM ContratClient WHERE idContratClient = ?";
        $stmtDeleteContrat = $conn->prepare($sqlDeleteContrat);
        $stmtDeleteContrat->execute([$idContratClient]);

        // Mise à jour de la réponse JSON
        $response['success'] = true;
        $response['message'] = "Le contrat client a été supprimé avec succès.";
    } catch (PDOException $e) {
        // En cas d'erreur SQL, afficher le message d'erreur
        $response['message'] = "Erreur SQL lors de la suppression du contrat : " . $e->getMessage();
    }
} else {
    // Si la méthode de requête est invalide ou le paramètre manquant
    $response['message'] = "Paramètre invalide pour la suppression du contrat.";
}

// Conversion de la réponse en format JSON
echo json_encode($response);
?>
