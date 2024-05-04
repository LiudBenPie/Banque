<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Création d'un client</title>
    <link rel="stylesheet" href="/static/css/formstyle.css">
</head>

<body>
    <?php
    require('../../init.php');
    checkAcl('auth');
    include VIEWS_DIR . '/menu.php';
    try {
        if (isset($_POST['ajouterclient']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['adresse']) && !empty($_POST['adressemail']) && !empty($_POST['numtel']) && !empty($_POST['datedenaissance'])) {
            $nomemploye = $_POST['nomemploye'];

            // Recherche du numéro de l'employé à partir de son nom
            $sqlEmploye = "SELECT numEmploye FROM employe WHERE nom = ?";
            $stmtEmploye = $conn->prepare($sqlEmploye);
            $stmtEmploye->execute([$nomemploye]);
            $rowEmploye = $stmtEmploye->fetch(PDO::FETCH_ASSOC);

            $situation = $_POST['situation'];

            // Recherche de l'ID de la situation à partir de sa description
            $sqlSituation = "SELECT idSituation FROM situation WHERE description = ?";
            $stmtSituation = $conn->prepare($sqlSituation);
            $stmtSituation->execute([$situation]);
            $rowSituation = $stmtSituation->fetch(PDO::FETCH_ASSOC);

            $search1 = $_POST['nom'];
            $search2 = $_POST['prenom'];
            $search3 = $_POST['numtel'];
            $search4 = $_POST['datedenaissance'];

            // Vérification si le client existe déjà dans la base de données
            $sqlCheckClient = "SELECT * FROM client WHERE nom LIKE ? AND prenom LIKE ? AND numTel LIKE ? AND dateNaissance LIKE ?";
            $stmtCheckClient = $conn->prepare($sqlCheckClient);
            $stmtCheckClient->execute(["%$search1%", "%$search2%", "%$search3%", "%$search4%"]);

            if ($stmtCheckClient->rowCount() > 0) {
                echo "Le client existe déjà dans la base de données";
            } else {
                $nomclient = $_POST['nom'];
                $prenomclient = $_POST['prenom'];
                $adresseclient = $_POST['adresse'];
                $adressemailclient = $_POST['adressemail'];
                $numerotelclient = $_POST['numtel'];
                $datedenaissance = $_POST['datedenaissance'];

                // Insertion du client dans la base de données
                $sqlInsertClient = "INSERT INTO client (nom, prenom, adresse, mail, numTel, dateNaissance, idSituation, numEmploye) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmtInsertClient = $conn->prepare($sqlInsertClient);

                if ($stmtInsertClient->execute([$nomclient, $prenomclient, $adresseclient, $adressemailclient, $numerotelclient, $datedenaissance, $rowSituation['idSituation'], $rowEmploye['numEmploye']])) {
                    echo '<script>alert("Le client a été ajouté à la base de données.");</script>';
                } else {
                    echo '<script>alert("Une erreur est survenue lors de l\'ajout du client.");</script>';
                }
            }
        }
    } catch (PDOException $e) {
        $msg = 'ERREUR dans ' . $e->getFile() . 'Ligne' . $e->getLine() . ':' . $e->getMessage();
    }
    ?>
    <div class="container mt-5" style="max-width: 700px;">
        <form action="ajouterClient.php" method="post" class="row g-3 rounded shadow">
            <legend class="text-warning">Les clients de la banque</legend>
            <div class="form-group col-md-6">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" name="nom" id="nom" size="12" maxlength="25" required>
            </div>
            <div class="form-group col-md-6">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" name="prenom" id="prenom" size="12" maxlength="25" required>
            </div>
            <div class="form-group">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" class="form-control" name="adresse" id="adresse" size="12" maxlength="25" required>
            </div>
            <div class="form-group">
                <label for="adressemail" class="form-label">Adresse email</label>
                <input type="text" class="form-control" name="adressemail" id="adressemail" size="50" maxlength="50" required>
            </div>
            <div class="form-group">
                <label for="numtel" class="form-label">Numéro de téléphone</label>
                <input type="text" class="form-control" name="numtel" id="numtel" size="10" maxlength="25" required>
            </div>
            <div class="form-group">
                <label for="datedenaissance" class="form-label">Date de naissance : </label>
                <input type="date" class="form-control" name="datedenaissance" id="datedenaissance" required>
            </div>
            <div class="form-group">
                <label for="nomemploye" class="form-label">Nom du conseiller</label>
                <select id="nomemploye" name="nomemploye" class="form-control">
                    <?php
                    $sql = "SELECT nom FROM employe WHERE categorie='Conseiller'";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $nomconseillers = $stmt->fetchAll();

                    foreach ($nomconseillers as $nomconseiller) {
                        $selected = ($rowemploye['nom'] == $nomconseiller['nom']) ? 'selected' : '';
                        echo "<option value=\"{$nomconseiller['nom']}\" $selected>{$nomconseiller['nom']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="situation" class="form-label">Situation</label>
                <select id="situation" name="situation" class="form-control">
                    <?php
                    $sql = "SELECT description FROM situation";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $nomsituations = $stmt->fetchAll();

                    foreach ($nomsituations as $nomsituation) {
                        $selected = ($rowemploye['description'] == $nomsituation['description']) ? 'selected' : '';
                        echo "<option value=\"{$nomsituation['description']}\" $selected>{$nomsituation['description']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button type="reset" name="reset" value="Effacer les valeurs saisies" class="btn btn-outline-warning">Effacer les valeurs saisies</button>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button type="submit" name="ajouterclient" value="Ajouter un client" class="btn btn-outline-warning">Ajouter un client</button>
            </div>
        </form>
    </div>
</body>

</html>