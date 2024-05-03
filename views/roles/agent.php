<!DOCTYPE html> 
<html lang="en"> 

<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Méta-informations pour la mise en page sur les appareils mobiles -->
    <title>Page de l'agent</title> 
    <style>
        
        li:hover {
            background-color: black; 
            color: yellow; 
            text-decoration: underline; 
            text-decoration-color: #9f9c92; 
        }

        .btn {
            background: linear-gradient(to bottom, #cfc09f 27%, #ffecb3 40%, #3a2c0f 78%); 
            text-transform: uppercase; 
        }

        .btn:hover {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg" style="background-color: #191F1D;">
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><img src="/static/images/cochon.png" width="80" alt="icon"></a> 
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span> 
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Liste des éléments de navigation -->
                    <!-- Gestion des clients -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white;">
                            Gestion des clients
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/clients/rechercherClient.php">Modifier les informations du client</a></li>
                            <li><a class="dropdown-item" href="/clients/ajouterClient.php">Inscrire un nouveau client</a></li>
                        </ul>
                    </li>
                    <!-- Gestion des syntheses -->
                    <li class="nav-item">
                        <a class="nav-link" href="/clients/rechercheSyntheseClient.php" style="color: white;">Consulter la synthèse d'un client</a>
                    </li>
                    <!-- Gestion des dépôts et des retraits -->
                    <li class="nav-item">
                        <a class="nav-link" href="/comptes/rechercherCompte.php" style="color: white;">Réaliser un dépôt ou un retrait</a>
                    </li>
                    <!-- Gestion des rdv -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Rendez-vous
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="/rendez-vous/creerRDV.php" style="color: white;">Prendre un rendez-vous pour un client</a></li>
                            <li><a class="dropdown-item" href="/rendez-vous/rechercherRDV.php">Gérer un rendez-vous pour un client</a></li>
                            <li><a class="dropdown-item" href="/rendez-vous/calendrier.php">Visualiser le calendrier</a></li>
                        </ul>
                    </li>
                </ul>
                <a class="btn" href="/utilisateurs/deconnexion.php">Deconnexion</a> <!-- Bouton de déconnexion -->
            </div>
        </div>
    </nav>

</body>

</html>