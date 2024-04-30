<?php
<<<<<<< HEAD
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
        
        // Recherche du nom du client par son compte client
        $sql = "SELECT idCompteClient FROM CompteClient WHERE idCompteClient = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$idCompteClient]);
        $rowidcompteclient = $stmt->fetch(PDO::FETCH_ASSOC);

        // Insertion de l'opération dans la base de données
        $sql = "INSERT INTO Operation (montant,dateOperation,typeOp,idCompteClient) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute([$montant, $dateOperation, $typeOp, $idCompteClient])) {
            echo "L'opération a été enregistrée avec succès.";
        } else {
            echo "Une erreur s'est produite lors de l'enregistrement de l'opération.";
        }
    }
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<form action="rechercherCompte.php" method="post">
    <label for="compteClient">Sélectionnez le compte client pour l'opération :</label>
    <select name="compteClient" id="compteClient">
        <?php
        // Récupération de la liste des comptes clients avec les informations sur le client
        $sql = "SELECT cc.idCompteClient, c.nom, c.prenom FROM CompteClient AS cc JOIN Client AS c ON cc.numClient = c.numClient";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $compteClients = $stmt->fetchAll();

        foreach ($compteClients as $compteClient) {
            $selected = ($rowidcompteclient['idCompteClient'] == $compteClient['idCompteClient']) ? 'selected' : '';
            echo "<option value=\"{$compteClient['idCompteClient']}\" $selected>{$compteClient['nom']} {$compteClient['prenom']}</option>";
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
=======
// Inclusion du fichier d'initialisation de la base de données
require('init.php');

// Vérification des autorisations (fonction non définie dans l'extrait)
checkAcl('auth');

// Inclusion du fichier de menu (constante VIEWS_DIR non définie dans l'extrait)
include VIEWS_DIR . '/menu.php';

// Activation de l'affichage des erreurs PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Traitement du formulaire lorsqu'il est soumis
        if (isset($_POST['montant'], $_POST['date_operation'], $_POST['type_operation'], $_POST['id_compte_client'])) {
            // Récupération des données du formulaire
            $montant = $_POST['montant'];
            $dateOperation = $_POST['date_operation'];
            $typeOperation = $_POST['type_operation'];
            $idCompteClient = $_POST['id_compte_client'];

            // Insertion des données dans la table Operation
            $sql = "INSERT INTO Operation (montant, dateOperation, typeOp, idCompteClient) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            // Exécution de la requête d'insertion avec gestion des erreurs PDO
            if ($stmt->execute([$montant, $dateOperation, $typeOperation, $idCompteClient])) {
                echo '<script> alert ("L\'opération a été ajoutée à la base de données.");</script>';
            } else {
                // Affichage d'une alerte JavaScript avec le message d'erreur PDO
                echo '<script> alert("Une erreur est survenue lors de l\'ajout de l\'opération : ' . $stmt->errorInfo()[2] . '");</script>';
            }
        }
    }
} catch (PDOException $e) {
    // Gestion des erreurs PDO
    $msg = 'ERREUR dans ' . $e->getFile() . 'Ligne' . $e->getLine() . ':' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une opération</title>
</head>
<body>
    <h2>Ajouter une nouvelle opération</h2>
    <form method="post" action="rechercherCompte.php">
        <label for="montant">Montant :</label>
        <input type="number" id="montant" name="montant" required><br><br>

        <label for="date_operation">Date de l'opération :</label>
        <input type="date" id="date_operation" name="date_operation" required><br><br>

        <label for="type_operation">Type d'opération :</label>
        <input type="text" id="type_operation" name="type_operation" required><br><br>

        <label for="id_compte_client">Identifiant du compte client :</label>
        <input type="number" id="id_compte_client" name="id_compte_client" required><br><br>

        <button type="submit">Ajouter Opération</button>
    </form>
</body>
</html>






>>>>>>> 25a357fe533bc7a44b2a7539741d2cead6d31241
