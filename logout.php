<?php
require('connect.php');
require('auth.php');

$auth = new Auth($conn);
$auth->logout();
header("Location: /");


