<?php
session_start();
require 'db.php'; // Connexion à la base de données

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Vérification des paramètres de recherche
$filiere = isset($_GET['filiere']) ? $_GET['filiere'] : '';
$niveau = isset($_GET['niveau']) ? $_GET['niveau'] : '';

$sql = "SELECT * FROM books WHERE 1=1"; // La condition "1=1" permet d'ajouter dynamiquement des conditions

$params = [];

if ($filiere) {
    $sql .= " AND filiere = :filiere";
    $params[':filiere'] = $filiere;
}

if ($niveau) {
    $sql .= " AND niveau = :niveau";
    $params[':niveau'] = $niveau;
}

$query = $pdo->prepare($sql);
$query->execute($params);
$books = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque Numérique</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Bienvenue à la bibliothèque numérique</h1>

    <h2>Recherche de livres</h2>
    <form action="index.php" method="GET">
        <select name="filiere">
            <option value="">Toutes les filières</option>
            <option value="informatique" <?= $filiere == 'informatique' ? 'selected' : '' ?>>Informatique</option>
            <option value="gestion" <?= $filiere == 'gestion' ? 'selected' : '' ?>>Gestion</option>
            <option value="batiment" <?= $filiere == 'batiment' ? 'selected' : '' ?>>Bâtiment et Travaux Publics</option>
            <option value="hotelerie" <?= $filiere == 'hotelerie' ? 'selected' : '' ?>>Hôtellerie</option>
        </select>
        <select name="niveau">
            <option value="">Tous les niveaux</option>
            <option value="L2" <?= $niveau == 'L2' ? 'selected' : '' ?>>L2</option>
            <option value="L3" <?= $niveau == 'L3' ? 'selected' : '' ?>>L3</option>
            <option value="M1" <?= $niveau == 'M1' ? 'selected' : '' ?>>M1</option>
            <option value="M2" <?= $niveau == 'M2' ? 'selected' : '' ?>>M2</option>
        </select>
        <button type="submit">Rechercher</button>
    </form>

    <h2>Liste des livres disponibles</h2>
    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Filière</th>
                <th>Niveau</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($books): ?>
                <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= htmlspecialchars($book['title']); ?></td>
                    <td><?= htmlspecialchars($book['filiere']); ?></td>
                    <td><?= htmlspecialchars($book['niveau']); ?></td>
                    <td>
                        <a href="view.php?id=<?= $book['id']; ?>">Voir</a> |
                        <a href="<?= htmlspecialchars($book['file_path']); ?>" download>Télécharger</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Aucun livre trouvé pour les critères de recherche spécifiés.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
    <a href="upload.php">Téléverser un livre</a>
    <?php endif; ?>

    <a href="logout.php">Se déconnecter</a>
</body>

</html>
