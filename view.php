<?php
session_start();
require 'db.php'; // Connexion à la base de données

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Récupérer l'ID du livre à partir de l'URL
if (isset($_GET['id'])) {
    $bookId = $_GET['id'];

    // Requête pour récupérer le fichier PDF
    $query = $pdo->prepare("SELECT * FROM books WHERE id = ?");
    $query->execute([$bookId]);
    $book = $query->fetch();

    if ($book) {
        $filePath = $book['file_path'];
    } else {
        echo "Livre non trouvé.";
        exit();
    }
} else {
    echo "Aucun livre spécifié.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualiser le livre - <?= htmlspecialchars($book['title']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1><?= htmlspecialchars($book['title']); ?></h1>

    <!-- Visionneuse PDF intégrée -->
    <div>
        <iframe src="<?= htmlspecialchars($filePath); ?>" width="600" height="800" style="border:none;"></iframe>
    </div>

    <a href="index.php">Retour à la liste des livres</a>
    <a href="<?= htmlspecialchars($filePath); ?>" download>Télécharger ce livre</a>
</body>
</html>
