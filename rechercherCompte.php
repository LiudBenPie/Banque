<?php
// Inclure le fichier d'initialisation et vérifier les autorisations d'accès
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

// Fonction pour insérer une opération dans la base de données
function insertOperation($conn, $montant, $date_operation, $type_operation, $id_compte_client) {
    // Requête d'insertion
    $sql = "INSERT INTO Operation (montant, dateOperation, typeOp, idCompteClient) VALUES (?, ?, ?, ?)";
    
    // Préparation de la requête
    $stmt = $conn->prepare($sql);
    
    // Vérifier si la préparation de la requête a réussi
    if ($stmt) {
        // Binder les valeurs et exécuter la requête
        $stmt->bind_param("dsss", $montant, $date_operation, $type_operation, $id_compte_client);
        if ($stmt->execute()) {
            return true; // Opération ajoutée avec succès
        } else {
            return false; // Erreur lors de l'exécution de la requête
        }
    } else {
        return false; // Erreur lors de la préparation de la requête
    }
}

$createSuccessful = false;

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $montant = $_POST['montant'];
    $date_operation = $_POST['date_operation'];
    $type_operation = $_POST['type_operation'];
    $id_compte_client = $_POST['id_compte_client'];

    // Utiliser la connexion à la base de données existante depuis init.php
    global $conn;

    // Insérer l'opération dans la base de données en utilisant la fonction définie
    $createSuccessful = insertOperation($conn, $montant, $date_operation, $type_operation, $id_compte_client);

    // Afficher une alerte si l'opération a été ajoutée avec succès
    if ($createSuccessful) {
        echo '<script>alert("L\'opération a été ajoutée avec succès.");</script>';
    } else {
        echo '<script>alert("Erreur lors de l\'ajout de l\'opération. Veuillez réessayer.");</script>';
    }
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






