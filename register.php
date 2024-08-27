<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    
    $query = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $query->execute([$username, $password, $role]);
    
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Créer un compte</h1>
    <form action="register.php" method="post">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <select name="role" required>
            <option value="user">Utilisateur</option>
            <option value="admin">Administrateur</option>
        </select>
        <button type="submit">S'inscrire</button>
    </form>
    <a href="login.php">Se connecter</a>
</body>

</html>