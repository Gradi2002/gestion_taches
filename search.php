<?php
// Inclure le fichier de configuration de la base de données
require_once 'config.php';

if (isset($_GET['q'])) {
    $searchTerm = $_GET['q'];

    // Requête de recherche
    $query = "SELECT * FROM nom_de_la_table WHERE column_name LIKE :searchTerm";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
    $stmt->execute();
    $results = $stmt->fetchAll();

    // Afficher les résultats
    if (count($results) > 0) {
        foreach ($results as $result) {
            echo "<p>" . $result['column_name'] . "</p>";
        }
    } else {
        echo "Aucun résultat trouvé.";
    }
} else {
    echo "Aucun terme de recherche spécifié.";
}
?>
