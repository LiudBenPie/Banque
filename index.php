<?php
require('connect.php');
require('auth.php');
// echo password_hash('password', PASSWORD_DEFAULT);
$auth = new Auth($conn);
if($auth->isLoggedIn()){
    include 'views/dashbord.php';
}
else{
    include 'views/login.php';
}
