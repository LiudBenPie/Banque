<?php
require('connect.php');
require('auth.php');
session_start();

$auth = new Auth($conn);

// access control list
function checkAcl($acl = null) {
    global $auth;  // Make $auth available inside the function

    switch ($acl) {
        case 'guest':
            // Allow access to guests; typically, no action needed unless you want to redirect logged-in users
            if ($auth->isLoggedIn()) {
                // Redirect if a logged-in user should not access guest pages
                header("Location: /views/dashboard.php");
                exit;
            }
            break;
        case 'auth':
            // Require the user to be logged in
            if (!$auth->isLoggedIn()) {
                header("Location: /views/login.php");
                exit;
            }
            break;
        default:
            // Default case to handle unrecognized roles or if no role is specified
            // Redirect users based on their authentication status
            if ($auth->isLoggedIn()) {
                header("Location: /views/dashboard.php");
                exit;
            } else {
                header("Location: /views/login.php");
                exit;
            }
            break;
    }
}
