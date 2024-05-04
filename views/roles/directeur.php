<!DOCTYPE html> 
<html lang="en"> 

<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Méta-informations pour la mise en page sur les appareils mobiles -->
    <title>Page du directeur</title> 
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><img src="/static/images/favicon.ico" width="60" alt="icon"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Liste des éléments de navigation -->
                    <!-- Gérer les employés -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;">
                            Employés
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/employes/creerEmploye.php">Créer les login et mot de passe des employés</a></li>
                            <li><a class="dropdown-item" href="/employes/rechercherEmploye.php">Gérer les informations des employés</a></li>
                        </ul>
                    </li>
                    <!-- Gérer les contrats -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;">
                            Contrats
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/contrats/creerContrat.php">Créer la liste des contrats</a></li>
                            <li><a class="dropdown-item" href="/contrats/rechercherTypeContrat.php">Gérer la liste des contrats existants</a></li>
                        </ul>
                    </li>
                    <!-- Gérer les comptes bancaires -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;">
                            Comptes
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/comptes/creerCompte.php">Créer la liste des comptes</a></li>
                            <li><a class="dropdown-item" href="/comptes/rechercherTypeCompte.php">Gérer la liste des comptes existants</a></li>
                        </ul>
                    </li>
                    <!-- Gérer les pièces à fournir -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;">
                            Pièces à fournir
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/rendez-vous/creerMotif.php">Créer un motif avec la liste des pièces à fournir</a></li>
                            <li><a class="dropdown-item" href="/rendez-vous/rechercherPiece.php">Gérer les motifs existants</a></li>
                        </ul>
                    </li>
                    <!-- Visualiser les statistiques de la banque -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;">
                            Statistiques
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/contrats/statContrat.php">Visualiser les statistiques des contrats souscris</a></li>
                            <li><a class="dropdown-item" href="/rendez-vous/statRdv.php">Visualiser les statistiques des rdv pris</a></li>
                            <li><a class="dropdown-item" href="/clients/statClient.php">Visualiser le nombre total de clients de la banque</a></li>
                            <li><a class="dropdown-item" href="/comptes/statSolde.php">Visualiser le solde total de tous les clients</a></li>
                        </ul>
                    </li>
                </ul>
                <?php
                include VIEWS_DIR . '/themeswitcher.php';
                ?>
                <a type="button" class="btn btn-outline-warning" href="/utilisateurs/deconnexion.php">Déconnexion</a>
            </div>
        </div>
    </nav>

    <!-- Liens vers les scripts Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>