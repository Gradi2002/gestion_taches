<?php
// Inclure le fichier de configuration de la base de données
require_once 'config.php';

// Récupérer toutes les tâches de la base de données
$query = "SELECT * FROM taches";
$stmt = $pdo->query($query);
$taches = $stmt->fetchAll();

// Vérifier si le formulaire de suppression a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $tacheID = $_POST['tacheID'];

    // Supprimer la tâche de la base de données
    $deleteQuery = "DELETE FROM taches WHERE ID = :tacheID";
    $stmt = $pdo->prepare($deleteQuery);
    $stmt->bindParam(':tacheID', $tacheID);

    if ($stmt->execute()) {
        // Rediriger vers la page de succès
        header('Location: success.php');
        exit();
    } else {
        echo "Une erreur est survenue lors de la suppression de la tâche.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des tâches</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

    <div class="container">
        <h1>Liste des tâches</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Priorité</th>
                    <th>Date d'échéance</th>
                    <th>Catégorie</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($taches as $tache) : ?>
                <tr>
                    <td><?php echo $tache['ID']; ?></td>
                    <td><?php echo $tache['Titre']; ?></td>
                    <td><?php echo $tache['Description']; ?></td>
                    <td><?php echo $tache['Priorité_ID']; ?></td>
                    <td><?php echo $tache['Date_Échéance']; ?></td>
                    <td><?php echo $tache['Catégorie_ID']; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $tache['ID']; ?>" class="btn btn-primary">Modifier</a>
                        <form method="POST" style="display: inline-block;">
                            <input type="hidden" name="tacheID" value="<?php echo $tache['ID']; ?>">
                            <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
