<?php
require('init.php'); 
checkAcl('auth');
include VIEWS_DIR . '/menu.php';
try {
    if(isset($_POST['ventecon'], $_POST['date'], $_POST['tarif'], $_POST['nomcli'], $_POST['nomcon'])) {
        // Récupération des données du formulaire
        $datcon = $_POST['date'];
        $tarcon = $_POST['tarif'];
        $nomcli = $_POST['nomcli'];
        $nomcon = $_POST['nomcon'];

        // Recherche du numéro de client à partir du nom du client
        $sql = "SELECT numClient FROM client WHERE nom = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nomcli]);
        $rowcli = $stmt->fetch(PDO::FETCH_ASSOC);

        // Recherche du numéro de contrat à partir du nom du contrat
        $sql = "SELECT numContrat FROM contrat WHERE nomTypeContrat = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nomcon]);
        $rowcon = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($rowcli && $rowcon) {
            // Insertion des données dans la base de données
            $sql = "INSERT INTO ContratClient (dateOuvertureContrat, tarifMensuel, numClient, numContrat) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if($stmt->execute([$datcon, $tarcon, $rowcli['numClient'], $rowcon['numContrat']])) {
                echo '<script> alert ("Le contrat client a été ajouté à la base de données.");</script>';
            } else {
                echo '<script> alert("Une erreur est survenue lors de l\'ajout du contrat client.");</script>';
            }
        } else {
            echo '<script> alert("Le client ou le contrat spécifié n\'existe pas.");</script>';
        }
    }}
 catch(PDOException $e) {
    $msg = 'ERREUR dans ' . $e->getFile() . 'Ligne' . $e->getLine() . ':' . $e->getMessage();
}
?>
    <h2>Formulaire de Vente de Contrat</h2>
    <form action="vendreContrat.php" method="post">
        <p>
        <label for="date">Date d'ouverture :</label>
        <input type="date" id="date" name="date" required><br><br>
        </p>
        <p>
        <label for="tarif">Tarif mensuel :</label>
        <input type="number" id="tarif" name="tarif" min="0" step="5" required><br><br>
        </p>
        <p>
        <label for="nomcli">Nom du client :</label>
        <select id="nomcli" name="nomcli">
            <?php
                $sql = "SELECT nom  FROM Client";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $nomclients = $stmt->fetchAll();

                foreach ($nomclients as $nomclient) {
                    $selected = ($rowcli['nom'] == $nomclient['nom']) ? 'selected' : '';
                    echo "<option value=\"{$nomclient['nom']}\" $selected>{$nomclient['nom']}</option>";
                }                               
            ?>
            </select>
        </p>
        <p>
        <label for="nomcon">Nom du contrat :</label>
        <select id="nomcon" name="nomcon">
        <?php
            $sql = "SELECT nomTypeContrat FROM contrat";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $nomtypecontrats = $stmt->fetchAll();


                    foreach ($nomtypecontrats as $nomtypecontrat) {
                        $selected = ($rownomtype['nomTypeContrat'] == $nomtypecontrat['nomTypeContrat']) ? 'selected' : '';
                        echo "<option value=\"{$nomtypecontrat['nomTypeContrat']}\" $selected>{$nomtypecontrat['nomTypeContrat']}</option>";
                }                               
            ?>
            </select>
        <p>
        <input type="submit" name="ventecon" value="Vendre un contrat">
        </p>
    </form>'
