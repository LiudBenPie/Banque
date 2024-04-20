<?php
define("SERVEUR", "localhost");
define("USER", "root");
define("PASSWORD", "");
define("BDD", "banque");
// Créer la connexion
$conn = new PDO('mysql:host=' . SERVEUR . ';dbname=' . BDD, USER, PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn->query('SET NAMES UTF8');
