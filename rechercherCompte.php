<?php
// Inclure le fichier d'initialisation et vérifier les autorisations d'accès
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

$createSuccessful = false;

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $montant = $_POST['montant'];
    $date_operation = $_POST['date_operation'];
    $type_operation = $_POST['type_operation'];
    $id_compte_client = $_POST['id_compte_client'];

    // Connexion à la base de données (à adapter avec vos paramètres de connexion)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "banque";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connexion échouée : " . $conn->connect_error);
    }

    // Requête d'insertion
    $sql = "INSERT INTO Operation (montant, dateOperation, typeOp, idCompteClient) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Vérifier si la préparation de la requête a réussi
    if ($stmt) {
        // Binder les valeurs et exécuter la requête
        $stmt->bind_param("dsss", $montant, $date_operation, $type_operation, $id_compte_client);
        if ($stmt->execute()) {
            $createSuccessful = true;
        } else {
            echo "Erreur lors de l'ajout de l'opération : " . $stmt->error;
        }
    } else {
        echo "Erreur lors de la préparation de la requête : " . $conn->error;
    }

    // Fermer la connexion
    $conn->close();
}

// Afficher une alerte si la création a été réussie
if ($createSuccessful) {
    echo '<script>alert("L\'opération a été ajoutée avec succès.");</script>';
}
?>

<!-- Formulaire pour l'ajout d'une opération -->
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <p>
        <label for="montant">Montant :</label>
        <input type="text" name="montant" required>
    </p>
    <p>
        <label for="date_operation">Date de l'opération :</label>
        <input type="date" name="date_operation" required>
    </p>
    <p>
        <label for="type_operation">Type d'opération :</label>
        <select name="type_operation" required>
            <option value="Dépôt">Dépôt</option>
            <option value="Retrait">Retrait</option>
        </select>
    </p>
    <p>
        <label for="id_compte_client">ID du compte client :</label>
        <input type="text" name="id_compte_client" required>
    </p>
    <p>
        <button type="submit" name="action" value="Ajouter">Ajouter l'opération</button>
    </p>
</form>





