<?php
require('connect.php');
require('auth.php');
$auth = new Auth($conn);
if($auth->isLoggedIn()){
    include 'views/dashbord.php';
}
else{
    include 'views/login.php';
}
