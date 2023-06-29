<!DOCTYPE html>
<html>
<head>
    <title>Ajouter une tâche</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

    <div class="container">
        <h1>Ajouter une tâche</h1>
        <form action="ajouter_tache.php" method="POST">
            <div class="form-group">
                <label for="titre">Titre :</label>
                <input type="text" class="form-control" id="titre" name="titre" required>
            </div>
            <div class="form-group">
                <label for="description">Description :</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="priorite">Priorité :</label>
                <select class="form-control" id="priorite" name="priorite" required>
                    <option value="">Sélectionner une priorité</option>
                    <?php
                    // Inclure le fichier de configuration de la base de données
                    require_once 'config.php';

                    // Récupérer les priorités depuis la table "priorites" de la base de données
                    $query = "SELECT * FROM priorites";
                    $stmt = $pdo->query($query);
                    $priorites = $stmt->fetchAll();

                    foreach ($priorites as $priorite) {
                        echo "<option value='" . $priorite['ID'] . "'>" . $priorite['Nom'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="date_echeance">Date d'échéance :</label>
                <input type="date" class="form-control" id="date_echeance" name="date_echeance" required>
            </div>
            <div class="form-group">
                <label for="categorie">Catégorie :</label>
                <select class="form-control" id="categorie" name="categorie" required>
                    <option value="">Sélectionner une catégorie</option>
                    <?php
                    // Récupérer les catégories depuis la table "categories" de la base de données
                    $query = "SELECT * FROM categories";
                    $stmt = $pdo->query($query);
                    $categories = $stmt->fetchAll();

                    foreach ($categories as $categorie) {
                        echo "<option value='" . $categorie['ID'] . "'>" . $categorie['Nom'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>

</body>
</html>
