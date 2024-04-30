<?php
require('init.php'); 
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

try {
    if (isset($_POST['ventecon'], $_POST['date'], $_POST['tarif'], $_POST['nomcli'], $_POST['nomcon'])) {
        // Récupération des données du formulaire
        $datcon = $_POST['date'];
        $tarcon = $_POST['tarif'];
        $nomcli = $_POST['nomcli'];
        $nomcon = $_POST['nomcon'];

        // Recherche du numéro de client à partir du nom du client
        $sql = "SELECT numClient FROM Client WHERE nom = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nomcli]);
        $rowcli = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($rowcli) {
            // Insertion du contrat client dans la table ContratClient
            $sql = "INSERT INTO ContratClient (dateOuvertureContrat, tarifMensuel, numClient, numContrat) VALUES (?, ?, ?, (SELECT numContrat FROM Contrat WHERE nomTypeContrat = ?))";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute([$datcon, $tarcon, $rowcli['numClient'], $nomcon])) {
                // Récupération de l'ID du Compte Client associé au Client
                $sql = "SELECT idCompteClient FROM CompteClient WHERE numClient = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$rowcli['numClient']]);
                $rowCompteClient = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($rowCompteClient) {
                    // Insertion de l'opération dans la table Operation
                    $montant = floatval($tarcon); // Conversion en float
                    $typeOp = 'Vente Contrat'; // Type d'opération pour une vente de contrat
                    $sql = "INSERT INTO Operation (montant, dateOperation, typeOp, idCompteClient) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    if ($stmt->execute([$montant, $datcon, $typeOp, $rowCompteClient['idCompteClient']])) {
                        echo '<script>alert("L\'opération a été réalisée avec succès.");</script>';
                    } else {
                        echo '<script>alert("Une erreur est survenue lors de l\'ajout de l\'opération.");</script>';
                    }
                } else {
                    echo '<script>alert("Aucun compte client trouvé pour ce client.");</script>';
                }
            } else {
                echo '<script>alert("Une erreur est survenue lors de l\'ajout du contrat client.");</script>';
            }
        } else {
            echo '<script>alert("Le client spécifié n\'existe pas.");</script>';
        }
    }
} catch (PDOException $e) {
    echo 'ERREUR dans ' . $e->getFile() . ' Ligne ' . $e->getLine() . ': ' . $e->getMessage();
}
?>

<h2>Formulaire de Vente de Contrat</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <p>
        <label for="date">Date d'ouverture :</label>
        <input type="date" id="date" name="date" required><br><br>
    </p>
    <p>
        <label for="tarif">Tarif mensuel :</label>
        <input type="text" id="tarif" name="tarif" required><br><br>
    </p>
    <p>
        <label for="nomcli">Nom du client :</label>
        <select id="nomcli" name="nomcli">
            <?php
            $sql = "SELECT nom FROM Client";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $nomclients = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($nomclients as $nomclient) {
                echo "<option value=\"{$nomclient['nom']}\">{$nomclient['nom']}</option>";
            }
            ?>
        </select>
    </p>
    <p>
        <label for="nomcon">Nom du contrat :</label>
        <select id="nomcon" name="nomcon">
            <?php
            $sql = "SELECT nomTypeContrat FROM Contrat";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $nomtypecontrats = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($nomtypecontrats as $nomtypecontrat) {
                echo "<option value=\"{$nomtypecontrat['nomTypeContrat']}\">{$nomtypecontrat['nomTypeContrat']}</option>";
            }
            ?>
        </select>
    </p>
    <p>
        <input type="submit" name="ventecon" value="Vendre un contrat">
    </p>
</form>

