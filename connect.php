<?php
define("SERVEUR", "localhost");
define("USER", "root");
define("PASSWORD", "");
define("BDD", "banque");
session_start();
// Créer la connexion
$conn = new PDO('mysql:host=' . SERVEUR . ';dbname=' . BDD, USER, PASSWORD);
