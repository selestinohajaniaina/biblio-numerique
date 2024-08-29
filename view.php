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
<body class="h-screen overflow-hidden">
    
  <div class="flex items-center justify-between border-b bg-blue-400 p-3">
    <a href="/" class="flex items-center space-x-2 rounded bg-gray-100 py-1 px-2 text-slate-500 shadow-md">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
      </svg>
      <span>Retour</span>
    </a>
    <div class="text-lg font-bold text-gray-100"><?= htmlspecialchars($book['filiere']) . " > " . htmlspecialchars($book['niveau']) . " > " . htmlspecialchars($book['title']) . ".pdf"; ?></div>
    <div class="flex items-center space-x-5 text-gray-100">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
        <path fill-rule="evenodd" d="M6.32 2.577a49.255 49.255 0 0111.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 01-1.085.67L12 18.089l-7.165 3.583A.75.75 0 013.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93z" clip-rule="evenodd" />
      </svg>
      <a href="<?= htmlspecialchars($filePath); ?>" class="flex items-center border rounded-full px-2" download>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
              <path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 013.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 013.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 01-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875zm5.845 17.03a.75.75 0 001.06 0l3-3a.75.75 0 10-1.06-1.06l-1.72 1.72V12a.75.75 0 00-1.5 0v4.19l-1.72-1.72a.75.75 0 00-1.06 1.06l3 3z" clip-rule="evenodd" />
              <path d="M14.25 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963A5.23 5.23 0 0016.5 7.5h-1.875a.375.375 0 01-.375-.375V5.25z" />
            </svg>
            Télécharger
        </a>
    </div>
  </div>

    <!-- Visionneuse PDF intégrée -->
    <div class="h-full">
        <iframe src="<?= htmlspecialchars($filePath); ?>" width="100%" height="100%"></iframe>
    </div>
</body>
</html>
