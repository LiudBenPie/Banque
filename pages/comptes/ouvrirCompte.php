<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Formulaire d'ouverture de compte</title>
</head>

<body>

<?php
require('../../init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

try {
    if (isset($_POST['ventecom'], $_POST['date'], $_POST['solde'], $_POST['decouvert'], $_POST['nomclient'], $_POST['nomcompte'])) {
        // Récupération des données du formulaire
        $datcompte = $_POST['date'];
        $soldecompte = $_POST['solde'];
        $decouvertcompte = $_POST['decouvert'];
        $nomclient = $_POST['nomclient'];
        $nomcompte = $_POST['nomcompte'];

        // Recherche du numéro de client à partir du nom
        $sql = "SELECT numClient FROM client WHERE nom = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nomclient]);
        $rowclient = $stmt->fetch(PDO::FETCH_ASSOC);

        // Recherche du numéro de compte à partir du nom du compte
        $sql = "SELECT idCompte FROM compte WHERE nomTypeCompte = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nomcompte]);
        $rowcompte = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($rowclient && $rowcompte) {
            // Insertion des données dans la base de données
            $sql = "INSERT INTO Compteclient (dateouverture, solde, montantDecouvert, numClient, idCompte) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute([$datcompte, $soldecompte, $decouvertcompte, $rowclient['numClient'], $rowcompte['idCompte']])) {
                echo '<script> alert ("Le compte client a été ajouté à la base de données.");</script>';
            } else {
                echo '<script> alert("Une erreur est survenue lors de l\'ajout du compte client.");</script>';
            }
        } else {
            echo '<script> alert("Le client ou le compte spécifié n\'existe pas.");</script>';
        }
    }
} catch (PDOException $e) {
    $msg = 'ERREUR dans ' . $e->getFile() . 'Ligne' . $e->getLine() . ':' . $e->getMessage();
}
?>

    <h2>Formulaire d'ouverture de compte</h2>
    <form action="ouvrirCompte.php" method="post">
        <p>
            <label for="date">Date d'ouverture :</label>
            <input type="date" id="date" name="date" required>
        </p>
        <p>
            <label for="solde">Solde :</label>
            <input type="text" id="solde" name="solde" value="0" readonly>
        </p>
        <p>
            <label for="decouvert">Montant du découvert :</label>
            <input type="text" id="decouvert" name="decouvert" required>
        </p>
        <p>
            <label for="nomclient">Nom du client :</label>
            <select id="nomclient" name="nomclient">
                <?php
                $sql = "SELECT nom FROM Client";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $nomclients = $stmt->fetchAll();

                foreach ($nomclients as $nomclient) {
                    echo "<option value=\"{$nomclient['nom']}\">{$nomclient['nom']}</option>";
                }
                ?>
            </select>
        </p>
        <p>
            <label for="nomcompte">Nom du compte :</label>
            <select id="nomcompte" name="nomcompte">
                <?php
                $sql = "SELECT nomTypeCompte FROM compte";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $nomtypecomptes = $stmt->fetchAll();

                foreach ($nomtypecomptes as $nomtypecompte) {
                    echo "<option value=\"{$nomtypecompte['nomTypeCompte']}\">{$nomtypecompte['nomTypeCompte']}</option>";
                }
                ?>
            </select>
        </p>
        <p>
            <input type="submit" name="ventecom" value="Vendre un compte">
        </p>
    </form>
</body>

</html>