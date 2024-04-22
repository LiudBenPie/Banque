<nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Banque</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!--Gérer les employés-->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Employés
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="">Créer les login et mot de passe des employés</a></li>
                        <li><a class="dropdown-item" href="/rechercherEmploye.php">Modifier les login et mot de passe des employés</a></li>
                        <li><a class="dropdown-item" href="/rechercherEmployeASupprimer.php">Supprimer des employés</a></li>
                    </ul>
                </li>
                <!--Gérer les contrats-->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Contrats
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/vendreContrat.php">Créer la liste des contrats</a></li>
                        <li><a class="dropdown-item" href="/rechercherContrat.php">Gérer la liste des contrats existants</a></li>
                    </ul>
                </li>
                <!--Gérer les comptes bancaires-->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Comptes
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/creerCompte.php">Créer la liste des comptes</a></li>
                        <li><a class="dropdown-item" href="/rechercherCompte.php">Gérer la liste des comptes existants</a></li>
                    </ul>
                </li>
                <!-- Gérer les pièces à fournir -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Pièces à fournir
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="">Créer la liste des pièces à fournir</a></li>
                        <li><a class="dropdown-item" href="/rechercherPiece.php">Modifier la liste des pièces à fournir</a></li>
                        <li><a class="dropdown-item" href="">Supprimer la liste des pièces à fournir</a></li>
                    </ul>
                </li>
                <!-- Visualiser les statistiques de la banque -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Statistiques
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="">Visualiser les statistiques des contrats souscris</a></li>
                        <li><a class="dropdown-item" href="">Visualiser les statistiques des rdv pris</a></li>
                        <li><a class="dropdown-item" href="">Visualiser le nombre total de clients de la banque</a></li>
                        <li><a class="dropdown-item" href="">Visualiser le solde total de tous les clients</a></li>
                    </ul>
                </li>
            </ul>
            <a class="btn btn-outline-success" class="btn btn-dark" href="/logout.php">Deconnexion</a>
        </div>
    </div>
</nav>