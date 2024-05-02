<?php
//записуємо в рут дір змінну нашу головну папкуб будемо використовувати як інпутитемо файли щоб не вписувати за кожним разом
//__DIR__ це наша папка
//ROOT_DIR constanta в яку ми зберіг нашу папку
GLOBAL $RUN_DIR;
$RUN_DIR = __DIR__ .'/';
define('ROOT_DIR', __DIR__ .'/pages/' );
define('VIEWS_DIR', __DIR__ .'/views/' );
require('connect.php');
require('auth.php');
session_start();

$auth = new Auth($conn);

// access control list

function checkAcl($acl = null) {
    global $auth; 
    // Define paths for redirection
    $loginPath = '/utilisateurs/connexion.php';
    $dashboardPath = '/pages/dashboard.php';

    // Define a function to handle redirection
    $redirect = function ($path) {
        header("Location: $path");
        exit;
    };

    // Handle authentication based on ACL
    if ($acl === 'guest' && $auth->isLoggedIn()) {
        $redirect($dashboardPath);
    } elseif ($acl === 'auth' && !$auth->isLoggedIn()) {
        $redirect($loginPath);
    } elseif ($acl !== 'guest' && $acl !== 'auth') {
        // Default behavior for unrecognized roles or no role specified
        $auth->isLoggedIn() ? $redirect($dashboardPath) : $redirect($loginPath);
    }
}

