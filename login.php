<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "banque";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$login = $conn->real_escape_string($_POST['login']);
$motDePasse = $conn->real_escape_string($_POST['motDePasse']);

$sql = "SELECT categorie FROM Employe WHERE login='$login' AND motDePasse='$motDePasse'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Utilisateur authentifié
    $row = $result->fetch_assoc();
    $categorie = $row["categorie"];
    
    // Redirection basée sur la catégorie
    if ($categorie == "directeur") {
        header("Location: directeur.php");
    } elseif ($categorie == "conseiller") {
        header("Location: conseiller.php");
    } elseif ($categorie == "agent") {
        header("Location: agent.php");
    }
} else {
    echo "Identifiant ou mot de passe incorrect.";
}
$conn->close();
?>
