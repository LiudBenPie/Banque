<?php
// Définir la variable ROOT_DIR pour notre répertoire racine, qui sera utilisée comme un chemin d'entrée pour les fichiers afin de ne pas le spécifier à chaque fois
// __DIR__ représente notre répertoire actuel
// ROOT_DIR est une constante dans laquelle nous stockons notre répertoire
define('ROOT_DIR', __DIR__ .'/' );
define('VIEWS_DIR', __DIR__ .'/views/' );
require('connect.php');
require('auth.php');
session_start();

$auth = new Auth($conn);

// Liste de contrôle d'accès

function checkAcl($acl = null) {
    global $auth; 
    // Définir les chemins pour la redirection
    $loginPath = '/pages/login.php';
    $dashboardPath = '/pages/dashboard.php';

    // Définir une fonction pour gérer la redirection
    $redirect = function ($path) {
        header("Location: $path");
        exit;
    };

    // Gérer l'authentification en fonction de la liste de contrôle d'accès (ACL)
    if ($acl === 'guest' && $auth->isLoggedIn()) {
        $redirect($dashboardPath);
    } elseif ($acl === 'auth' && !$auth->isLoggedIn()) {
        $redirect($loginPath);
    } elseif ($acl !== 'guest' && $acl !== 'auth') {
        // Comportement par défaut pour les rôles non reconnus ou non spécifiés
        $auth->isLoggedIn() ? $redirect($dashboardPath) : $redirect($loginPath);
    }
}

