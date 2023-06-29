<?php
// Inclure le fichier de configuration de la base de données
require_once 'config.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs du formulaire
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $prioriteID = $_POST['priorite'];
    $dateEcheance = $_POST['date_echeance'];
    $categorieID = $_POST['categorie'];

    // Préparer la requête d'insertion dans la table "taches"
    $insertQuery = "INSERT INTO taches (Titre, Description, Priorité_ID, Date_Échéance, Catégorie_ID) 
                    VALUES (:titre, :description, :prioriteID, :dateEcheance, :categorieID)";

    // Préparer et exécuter la requête avec les valeurs des paramètres
    $stmt = $pdo->prepare($insertQuery);
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':prioriteID', $prioriteID);
    $stmt->bindParam(':dateEcheance', $dateEcheance);
    $stmt->bindParam(':categorieID', $categorieID);

    // Vérifier si l'insertion a réussi
    if ($stmt->execute()) {
        // Rediriger vers une page de succès ou afficher un message de réussite
        header('Location: success.php');
        exit();
    } else {
        // Afficher un message d'erreur en cas d'échec de l'insertion
        echo "Une erreur est survenue lors de l'ajout de la tâche.";
    }
}
?>
