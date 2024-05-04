<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Création d'opération</title>
    <link rel="stylesheet" href="/static/css/formstyle.css">
</head>

<body>

    <?php
    require('../../init.php');
    checkAcl('auth');
    include VIEWS_DIR . '/menu.php';

    $createSuccessful = false;

    if (isset($_POST['action'])) {
        $montant = $_POST['montant'];
        $dateOperation = $_POST['dateOperation'];
        $typeOp = $_POST['typeOp'];
        $idCompteClient = $_POST['idCompteClient'];

        $sql = "INSERT INTO operation (montant, dateOperation, typeOp, idCompteClient) VALUES (?, ?, ?, ?)";
        $res = $conn->prepare($sql);
        $res->execute([$montant, $dateOperation, $typeOp, $idCompteClient]);
        $createSuccessful = true;
    }

    $sql = "UPDATE banque.compteclient SET solde = solde + ? WHERE idCompteClient = ?"; 
    $res = $conn->prepare($sql);
    $res->execute([$montant, $idCompteClient]);
    $createSuccessful = true;

    // Affiche une alerte si la création a été réussie
    if ($createSuccessful) {
        echo '<script>alert("L\'opération a été créée avec succès.");</script>';
    }
    ?>

    <!-- Formulaire pour la création du contrat -->
    <div class="container mt-5" style="max-width: 700px;">
        <form action="rechercherCompte.php" method="post" name="monForm" class="row g-3 rounded shadow">
            <legend>Realisation d'un depot ou d'un retrait</legend>
            <div class="form-group">
                <label for="montant" class="form-label">Montant :</label>
                <input type="number" class="form-control" name="montant" id="montant" required>
            </div>
            <div class="form-group">
                <label for="dateOperation" class="form-label">Date de l'opération :</label>
                <input type="date" class="form-control" name="dateOperation" id="dateOperation" required>
            </div>
            <div class="form-group">
                <label for="typeOp" class="form-label">Type de l'opération :</label>
                <select name="typeOp" id="typeOp" class="form-control">
                    <option value="Dépôt">Dépôt</option>
                    <option value="Retrait">Retrait</option>
                </select>
            </div>
            <div class="form-group">
                <?php
                $sql = "SELECT idCompteClient, prenom, nom FROM client JOIN compteclient ON client.numClient = compteclient.numClient";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $comptes = $stmt->fetchAll();
                ?>
                <div class="form-group">
                <label for="idCompteClient" class="form-label">Id du compte client :</label>
                <select name="idCompteClient" id="idCompteClient" class="form-control">
                    <?php foreach ($comptes as $compte) : ?>
                        <option value="<?php echo $compte['idCompteClient']; ?>">
                            <?php echo "Compte n°" . $compte['idCompteClient'] . " - " . " Client: " . $compte['nom'] . ' ' . $compte['prenom']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button type="submit" name="action" value="Créer" class="btn">Créer</button>
            </div>
        </form>
</body>

</html>