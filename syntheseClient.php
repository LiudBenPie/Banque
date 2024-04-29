<?php
require('init.php');
checkAcl('auth');
include VIEWS_DIR . '/menu.php';

// Vérifie si le formulaire a été soumis et que numClient est défini
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['numClient'])) {
    // Récupération du numéro de client sélectionné
    $numClient = $_POST['numClient'];

    // Requête SQL pour récupérer les informations du client, ses comptes, contrats, opérations et rendez-vous
    $sql = "SELECT c.numClient, c.nom, c.prenom, c.adresse, c.mail, c.numtel, s.description AS situation, c.dateNaissance,
            cc.idCompteClient, co.idCompte, co.nomTypeCompte, cc.solde, cc.montantDecouvert, cc.dateOuverture,
            ct.numContrat, ct.nomTypeContrat,
            o.numOp, o.montant, o.typeOp,
            r.dateRdv, r.heureRdv, m.libelleMotif
            FROM client c
            LEFT JOIN situation s ON c.idSituation = s.idSituation
            LEFT JOIN compteclient cc ON c.numClient = cc.numClient
            LEFT JOIN compte co ON cc.idCompte = co.idCompte
            LEFT JOIN contratclient cr ON c.numClient = cr.numClient
            LEFT JOIN contrat ct ON cr.numContrat = ct.numContrat
            LEFT JOIN operation o ON cc.idCompteClient = o.idCompteClient
            LEFT JOIN rdv r ON c.numClient = r.numClient
            LEFT JOIN motif m ON r.idMotif = m.idMotif
            WHERE c.numClient = :numClient";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':numClient', $numClient, PDO::PARAM_INT);
        $stmt->execute();

        $clientInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($clientInfo) {
            echo "<h2>Synthèse du client : {$clientInfo[0]['nom']} {$clientInfo[0]['prenom']}</h2>";
            echo "<p><strong>IdClient :</strong> {$clientInfo[0]['numClient']}</p>";
            echo "<p><strong>Adresse :</strong> {$clientInfo[0]['adresse']}</p>";
            echo "<p><strong>Email :</strong> {$clientInfo[0]['mail']}</p>";
            echo "<p><strong>Téléphone :</strong> {$clientInfo[0]['numtel']}</p>";
            echo "<p><strong>Situation :</strong> {$clientInfo[0]['situation']}</p>";
            echo "<p><strong>Date de naissance :</strong> {$clientInfo[0]['dateNaissance']}</p>";

            // Stocker les informations des comptes dans un tableau associatif pour les traiter
            $comptes = [];
            foreach ($clientInfo as $info) {
                $idCompteClient = $info['idCompteClient'];
                if (!isset($comptes[$idCompteClient])) {
                    $comptes[$idCompteClient] = [
                        'nomTypeCompte' => $info['nomTypeCompte'],
                        'idCompteClient' => $idCompteClient,
                        'dateOuverture' => $info['dateOuverture'],
                        'solde' => $info['solde'],
                        'montantDecouvert' => $info['montantDecouvert'],
                        'operations' => [] // Initialiser un tableau pour stocker les opérations
                    ];
                }

                // Ajouter les opérations associées à ce compte
                if (!empty($info['numOp'])) {
                    $comptes[$idCompteClient]['operations'][] = [
                        'typeOp' => $info['typeOp'],
                        'montant' => $info['montant']
                    ];
                }
            }

            // Affichage des détails pour chaque compte du client
            echo "<h3>Comptes :</h3>";
            foreach ($comptes as $compte) {
                echo "<h4>{$compte['nomTypeCompte']}</h4>";
                echo "<ul>";
                echo "<li><strong>IdCompte :</strong> {$compte['idCompteClient']}</li>";
                echo "<li><strong>Date d'ouverture :</strong> {$compte['dateOuverture']}</li>";
                echo "<li><strong>Solde :</strong> {$compte['solde']} €</li>";
                echo "<li><strong>Montant autorisé de découvert :</strong> {$compte['montantDecouvert']} €</li>";

                // Affichage des opérations pour ce compte
                echo "<li><strong>Opérations :</strong>";
                echo "<ul>";
                foreach ($compte['operations'] as $operation) {
                    echo "<li>{$operation['typeOp']} de {$operation['montant']} €</li>";
                }
                echo "</ul>";
                echo "</li>";

                echo "</ul>";
            }

            // Affichage des contrats du client
            echo "<h3>Contrats :</h3>";
            foreach ($clientInfo as $info) {
                if ($info['numContrat']) {
                    echo "<ul>";
                    echo "<li><strong>IdContrat :</strong> {$info['numContrat']}</li>";
                    echo "<li><strong>Type de contrat :</strong> {$info['nomTypeContrat']}</li>";
                    echo "<li><strong>Tarif mensuel :</strong> {$info['tarifMensuel']} €</li>";
                    echo "<li><strong>Date d'ouverture du contrat :</strong> {$info['dateOuvertureContrat']}</li>";
                    echo "</ul>";
                } else {
                    echo "<p>Aucun contrat trouvé pour ce client.</p>";
                }
            }

            // Affichage de l'historique des rendez-vous du client avec le motif
            echo "<h3>Historique des Rendez-vous :</h3>";
            if (!empty($clientInfo[0]['dateRdv'])) {
                echo "<ul>";
                foreach ($clientInfo as $rdv) {
                    echo "<li>Rendez-vous le {$rdv['dateRdv']} à {$rdv['heureRdv']}h, Motif : {$rdv['libelleMotif']}</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Aucun rendez-vous trouvé pour ce client.</p>";
            }
        } else {
            echo "<p>Client non trouvé.</p>";
        }
    } catch (PDOException $e) {
        // Gestion des erreurs PDO
        echo "Erreur de base de données : " . $e->getMessage();
    }
} else {
    // Redirection ou message d'erreur si le formulaire n'est pas soumis correctement
    echo "<p>Une erreur s'est produite. Veuillez réessayer.</p>";
}
?>

