<?php
define("SERVEUR", "localhost");
define("USER", "root");
define("PASSWORD", "");
define("BDD", "banque");
session_start();
// Créer la connexion
$conn = new PDO('mysql:host=' . SERVEUR . ';dbname=' . BDD, USER, PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn->query('SET NAMES UTF8');
