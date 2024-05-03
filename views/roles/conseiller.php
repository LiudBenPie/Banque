<nav class="navbar navbar-expand-lg bg-body-tertiary"  style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <a class="navbar-brand" href="/"><img src="/static/images/favicon.ico" width="60" alt="icon"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Gestion du planning-->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        RDV
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/rendez-vous/calendrier.php">Visualiser le calendrier</a></li>
                        <li><a class="dropdown-item" href="/rendez-vous/creerRDV.php">Prendre un rendez-vous pour un client</a></li>
                        <li><a class="dropdown-item" href="/rendez-vous/rechercherRDV.php">Gérer un rendez-vous pour un client</a></li>
                    </ul>
                </li>
                <!-- Gestion des clients -->
                <li class="nav-item">
                    <a class="nav-link" href="/clients/ajouterClient.php">Inscrire un nouveau client</a>
                </li>
                <!-- Gestion des contrats -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Contrats
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/contrats/vendreContrat.php">Vendre un contrat à un client</a></li>
                        <li><a class="dropdown-item" href="/contrats/rechercherContrat.php">Résilier un contrat</a></li>
                    </ul>
                </li>
                <!-- Gestion des comptes -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Comptes
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/comptes/ouvrirCompte.php">Ouvrir un ou plusieurs comptes pour un client</a></li>
                        <li><a class="dropdown-item" href="/comptes/supprimerCompteClient.php">Résilier un compte</a></li>
                        <li><a class="dropdown-item" href="/comptes/gestionDecouvert.php">Modifier la valeur d'un découvert</a></li>
                    </ul>
                </li>
            </ul>
            <a class="btn btn-primary" style="background-color: #003580;" href="/utilisateurs/deconnexion.php">Deconnexion</a>
        </div>
    </div>
</nav>