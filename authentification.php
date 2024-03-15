<?php
require('connect.php');
require('auth.php');

$login = $_POST['login'];
$password = $_POST['motDePasse'];
$auth = new Auth($conn);
$auth->login($login, $password);
header("Location: /");


