<?php
// Informations de connexion à la base de données
$hostname = 'localhost'; // Adresse du serveur MySQL
$username = 'root'; // Nom d'utilisateur de la base de données
$password = ''; // Mot de passe de la base de données
$database = 'gradi'; // Nom de la base de données

try {
    // Créer une instance de la classe PDO pour la connexion à la base de données
    $pdo = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8mb4", $username, $password);
    
    // Définir le mode d'erreur PDO sur Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Activer le mode de récupération des résultats sous forme de tableau associatif
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // En cas d'erreur de connexion, afficher un message d'erreur
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit();
}
