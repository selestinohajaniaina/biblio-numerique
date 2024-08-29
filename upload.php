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
    <script src="lottie-player.js"></script>
</head>

<body>
    <h1 class="text-center text-2xl font-bold bg-blue-800 text-white p-5">Téléverser un livre</h1>

    <div class="flex flex-1 items-center justify-center p-6">
        <div class="w-full max-w-2xl">
            <h2 class="font-bold text-xl m-2">Description du livre à téléverser</h2>
            <form class="flex flex-col gap-2 justify-center items-center" action="upload.php" method="post" enctype="multipart/form-data">
                <label for="" class="text-start  w-full">Donner une titre de ce livre</label>
                <input type="text" placeholder="titre du livre" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                <label for="" class="text-start  w-full">Filière correspondant</label>
                <select id="filiere" name="filiere" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="informatique">Informatique</option>
                    <option value="gestion">Gestion</option>
                    <option value="batiment">Bâtiment et Travaux Publics</option>
                    <option value="hotelerie">Hôtellerie</option>
                </select>
                
                <label for="" class="text-start  w-full">Niveau d'etude pour ce livre</label>
                <select id="niveau" name="niveau" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="L2">L2</option>
                    <option value="L3">L3</option>
                    <option value="M1">M1</option>
                    <option value="M2">M2</option>
                </select>

                
                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-blue-800 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <lottie-player src="upload-file.json" background="transparent" class="w-12" loop autoplay></lottie-player>
                            
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Cliquer pour téléverser</span> ou glisser et deposer ici.</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Fichier PDF (MAX. 10Mo)</p>
                        </div>
                        <input name="file" required id="dropzone-file" type="file" class="hidden" />
                        <span id="fileName"></span>
                    </label>
                </div> 

                <div class="flex w-full">
                <a href="/" class="inline-block rounded-md w-1/2 border-2 border-blue-800 mx-2 px-6 pb-[6px] pt-2 text-xs font-medium uppercase leading-normal text-blue transition duration-150 ease-in-out hover:border-blue-accent-300 hover:bg-blue-50/50 hover:text-blue-accent-300 focus:border-blue-600 focus:bg-blue-50/50 focus:text-blue-600 focus:outline-none focus:ring-0 active:border-blue-700 active:text-blue-700 motion-reduce:transition-none dark:text-blue-500 dark:hover:bg-blue-950 dark:focus:bg-blue-950">Annuler et retour vers la page d'accueil</a>
                <button type="submit" class="inline-flex w-1/2 h-full flex-1 items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Téléverser</button>
                </div>
                 </form>
        </div>
    </div>

    <script>
        document.getElementById('dropzone-file').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                document.getElementById('fileName').textContent = `Livre choisit: ${file.name}`;
            }
        });
    </script>
    
</body>

</html>