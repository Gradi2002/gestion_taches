<?php
// Inclure le fichier de configuration de la base de données
require_once 'config.php';

// Vérifier si l'identifiant de la tâche est passé dans l'URL
if (isset($_GET['id'])) {
    $tacheID = $_GET['id'];

    // Vérifier si le formulaire de modification a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titre']) && isset($_POST['description']) && isset($_POST['priorite']) && isset($_POST['date_echeance']) && isset($_POST['categorie'])) {
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $priorite = $_POST['priorite'];
        $date_echeance = $_POST['date_echeance'];
        $categorie = $_POST['categorie'];

        // Mettre à jour la tâche dans la base de données
        $updateQuery = "UPDATE taches SET Titre = :titre, Description = :description, Priorité_ID = :priorite, Date_Échéance = :date_echeance, Catégorie_ID = :categorie WHERE ID = :tacheID";
        $stmt = $pdo->prepare($updateQuery);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':priorite', $priorite);
        $stmt->bindParam(':date_echeance', $date_echeance);
        $stmt->bindParam(':categorie', $categorie);
        $stmt->bindParam(':tacheID', $tacheID);

        if ($stmt->execute()) {
            // Rediriger vers la page de succès
            header('Location: success.php');
            exit();
        } else {
            echo "Une erreur est survenue lors de la mise à jour de la tâche.";
        }
    }

    // Récupérer les informations de la tâche à partir de la base de données
    $query = "SELECT * FROM taches WHERE ID = :tacheID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':tacheID', $tacheID);
    $stmt->execute();
    $tache = $stmt->fetch();

    // Vérifier si la tâche existe
    if (!$tache) {
        echo "La tâche spécifiée n'existe pas.";
        exit();
    }

    // Récupérer les priorités depuis la table "priorites" de la base de données
    $query = "SELECT * FROM priorites";
    $stmt = $pdo->query($query);
    $priorites = $stmt->fetchAll();

    // Récupérer les catégories depuis la table "categories" de la base de données
    $query = "SELECT * FROM categories";
    $stmt = $pdo->query($query);
    $categories = $stmt->fetchAll();
} else {
    echo "L'identifiant de la tâche n'a pas été spécifié.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier une tâche</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Ma To-Do List</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Accueil</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="edit.php?id=<?php echo $tacheID; ?>">Modifier une tâche</a>
                </li>
            </ul>
            <form class="form-inline ml-auto" method="GET" action="search.php">
                <input class="form-control mr-sm-2" type="search" placeholder="Rechercher une tâche" aria-label="Search" name="query">
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Rechercher</button>
            </form>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Modifier une tâche</h1>
        <form action="edit.php?id=<?php echo $tacheID; ?>" method="POST">
            <div class="form-group">
                <label for="titre">Titre :</label>
                <input type="text" class="form-control" id="titre" name="titre" value="<?php echo $tache['Titre']; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description :</label>
                <textarea class="form-control" id="description" name="description" required><?php echo $tache['Description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="priorite">Priorité :</label>
                <select class="form-control" id="priorite" name="priorite" required>
                    <option value="">Sélectionner une priorité</option>
                    <?php
                    foreach ($priorites as $priorite) {
                        $selected = ($tache['Priorité_ID'] == $priorite['ID']) ? 'selected' : '';
                        echo "<option value='" . $priorite['ID'] . "' " . $selected . ">" . $priorite['Nom'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="date_echeance">Date d'échéance :</label>
                <input type="date" class="form-control" id="date_echeance" name="date_echeance" value="<?php echo $tache['Date_Échéance']; ?>" required>
            </div>
            <div class="form-group">
                <label for="categorie">Catégorie :</label>
                <select class="form-control" id="categorie" name="categorie" required>
                    <option value="">Sélectionner une catégorie</option>
                    <?php
                    foreach ($categories as $categorie) {
                        $selected = ($tache['Catégorie_ID'] == $categorie['ID']) ? 'selected' : '';
                        echo "<option value='" . $categorie['ID'] . "' " . $selected . ">" . $categorie['Nom'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>
    </div>

</body>
</html>
