
<nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #e3f2fd;">
<div class="container-fluid">
<a class="navbar-brand" href="/"><img src="/favicon.ico" width="50" alt="icon"></a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
    <!-- Gestion des clients -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Gestion des clients
        </a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/rechercherClient.php">Modifier les informations du client</a></li>
            <li><a class="dropdown-item" href="/ajouterClient.php">Inscrire un nouveau client</a></li>
        </ul>
    </li>
    <!-- Gestion des syntheses -->
    <li class="nav-item">
        <a class="nav-link" href="/rechercheSyntheseClient.php">Consulter la synthèse d'un client</a>
    </li>
    <!-- Gestion des dépôts et des retraits -->
    <li class="nav-item">
        <a class="nav-link" href="/rechercherCompte.php">Réaliser un dépôt ou un retrait</a>
    </li>
    <!-- Gestion des rdv -->
    <li class="nav-item">
        <a class="nav-link" href="/pages/newrdv.php">Prendre un rendez-vous pour un client</a>
    </li>
    </ul>
    <a class="btn btn-primary" style="background-color: #003580;" href="/logout.php">Deconnexion</a>
</div>
</div>
</nav>
