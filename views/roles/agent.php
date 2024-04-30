<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        li:hover {
            background-color: #005841;
            color: #CCB33B;
        }

        .btn {
            background: linear-gradient(to bottom, #cfc09f 27%, #ffecb3 40%, #3a2c0f 78%);
            text-transform: uppercase;
        }

        .btn:hover {
            font-weight: bold;
            color: black;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #003924;">
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><img src="/image/cochon.png" width="80" alt="icon"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Gestion des clients -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white;">
                            Gestion des clients
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/rechercherClient.php">Modifier les informations du client</a></li>
                            <li><a class="dropdown-item" href="/creerClient.php">Inscrire un nouveau client</a></li>
                        </ul>
                    </li>
                    <!-- Gestion des syntheses -->
                    <li class="nav-item">
                        <a class="nav-link" href="/rechercheSyntheseClient.php" style="color: white;">Consulter la synthèse d'un client</a>
                    </li>
                    <!-- Gestion des dépôts et des retraits -->
                    <li class="nav-item">
                        <a class="nav-link" href="/rechercherCompte.php" style="color: white;">Réaliser un dépôt ou un retrait</a>
                    </li>
                    <!-- Gestion des rdv -->
                    <li class="nav-item">
                        <a class="nav-link" href="/pages/creerRDV.php" style="color: white;">Prendre un rendez-vous pour un client</a>
                    </li>
                </ul>
                <a class="btn" href="/logout.php">Deconnexion</a>
            </div>
        </div>
    </nav>
</body>

</html>