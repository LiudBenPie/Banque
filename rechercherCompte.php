<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

// Récupération de la liste des comptes clients avec les informations sur le client
$sql = "SELECT CompteClient.idCompteClient, CompteClient.numClient, Client.nom, Client.prenom, CompteClient.idCompte 
        FROM CompteClient 
        INNER JOIN Client ON CompteClient.numClient = Client.numClient";
$stmt = $conn->prepare($sql);
$stmt->execute();
$compteClients = $stmt->fetchAll();

// Traitement du formulaire de sélection du compte client ou de réalisation de l'opération
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Si le formulaire de sélection du compte client est soumis
    if (isset($_POST['idCompteClient'])) {
        $idCompteClient = $_POST['idCompteClient'];
        echo '<h2>Réaliser une opération pour le compte sélectionné</h2>';
        echo '<form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post">';
        echo '<input type="hidden" name="idCompteClient" value="' . $idCompteClient . '">';

        echo '<label for="montant">Montant :</label>';
        echo '<input type="number" name="montant" step="0.01" required>';

        echo '<label for="typeOp">Type d\'opération :</label>';
        echo '<select name="typeOp" required>';
        echo '<option value="Dépôt">Dépôt</option>';
        echo '<option value="Retrait">Retrait</option>';
        echo '</select>';

        echo '<button type="submit">Réaliser l\'opération</button>';
        echo '</form>';
    } 
    // Si le formulaire de réalisation de l'opération est soumis
    elseif (isset($_POST['idCompteClient'], $_POST['montant'], $_POST['typeOp'])) {
        $idCompteClient = $_POST['idCompteClient'];
        $montant = $_POST['montant'];
        $typeOp = $_POST['typeOp'];

        // Insertion de l'opération dans la table Operation
        $sql = "INSERT INTO Operation (montant, typeOp, dateOperation, idCompteClient) VALUES (?, ?, NOW(), ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute([$montant, $typeOp, $idCompteClient])) {
            echo '<script>alert("L\'opération a été réalisée avec succès.");</script>';
        } else {
            echo '<script>alert("Erreur lors de la réalisation de l\'opération. Veuillez réessayer.");</script>';
        }
    }
}
?>

<h2>Sélectionnez le compte client pour réaliser une opération</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="compteClient">Sélectionnez le compte client :</label>
    <select name="idCompteClient" id="compteClient">
        <?php foreach ($compteClients as $compteClient) : ?>
            <option value="<?php echo $compteClient['idCompteClient']; ?>">
                <?php echo "Client: " . $compteClient['nom'] . ' ' . $compteClient['prenom'] . ", N° Compte: " . $compteClient['idCompte']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Sélectionner le compte</button>
</form>

