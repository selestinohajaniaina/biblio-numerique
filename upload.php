<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $filiere = $_POST['filiere'];
    $niveau = $_POST['niveau'];
    
    $target_dir = "uploads/$filiere/$niveau/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

    $query = $pdo->prepare("INSERT INTO books (title, file_path, filiere, niveau, uploaded_by) VALUES (?, ?, ?, ?, ?)");
    $query->execute([$title, $target_file, $filiere, $niveau, $_SESSION['user']['id']]);
    
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Téléverser un livre</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Téléverser un livre</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Titre du livre" required>
        <select name="filiere" required>
            <option value="informatique">Informatique</option>
            <option value="gestion">Gestion</option>
            <option value="batiment">Bâtiment et Travaux Publics</option>
            <option value="hotelerie">Hôtellerie</option>
        </select>
        <select name="niveau" required>
            <option value="L2">L2</option>
            <option value="L3">L3</option>
            <option value="M1">M1</option>
            <option value="M2">M2</option>
        </select>
        <input type="file" name="file" required>
        <button type="submit">Téléverser</button>
    </form>
    <a href="index.php">Retour</a>
</body>

</html>