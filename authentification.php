<?php
require('init.php');

$login = $_POST['login'];
$password = $_POST['motDePasse'];
// створення екземпляру класу аутх
$auth = new Auth($conn);
// використовуємо метод класу аутх
$auth->login($login, $password);
// перекидує на головну сторінку
header("Location: /");


