<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';
?>

<form action="syntheseClient.php" method="post">
    <label for="numClient">Sélectionnez le client :</label>
    <select name="numClient" id="numClient">
        <?php
        try {
            $sql = "SELECT numClient, nom, prenom, dateNaissance FROM client";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($clients as $client) {
                echo "<option value=\"{$client['numClient']}\">{$client['nom']} {$client['prenom']} (né(e) le {$client['dateNaissance']})</option>";
            }
        } catch (PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
        }
        ?>
    </select>
    <button type="submit">Afficher la synthèse du client</button>
</form>
