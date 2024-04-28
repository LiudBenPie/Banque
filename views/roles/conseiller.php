<nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Banque</a>
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
                        <li><a class="dropdown-item" href="/calendrier.php">Visualiser le calendrier</a></li>
                        <li><a class="dropdown-item" href="/pages/newrdv.php">Prendre un rendez-vous pour un client</a></li>
                    </ul>
                </li>
                <!-- Gestion des clients -->
                <li class="nav-item">
                    <a class="nav-link" href="/ajouterClient.php">Inscrire un nouveau client</a>
                </li>
                <!-- Gestion des contrats -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Contrats
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/vendreContrat.php">Vendre un contrat à un client</a></li>
                        <li><a class="dropdown-item" href="">Résilier un contrat</a></li>
                    </ul>
                </li>
                <!-- Gestion des comptes -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Comptes
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/ouvrirCompte.php">Ouvrir un ou plusieurs comptes pour un client</a></li>
                        <li><a class="dropdown-item" href="">Résilier un compte</a></li>
                        <li><a class="dropdown-item" href="/rechercherDecouvert.php">Modifier la valeur d'un découvert</a></li>
                    </ul>
                </li>
            </ul>
            <a class="btn btn-primary" style="background-color: #483D8B;" href="/logout.php">Deconnexion</a>
        </div>
    </div>
</nav>