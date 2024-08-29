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
    <script src="lottie-player.js"></script>
</head>

<body class="dark:bg-gray-900 dark:text-white">
    <h1 class="text-center relative text-2xl font-bold bg-blue-800 text-white p-5">Bienvenue à la bibliothèque numérique

    <button class="absolute right-0 top-[10px] m-2 p-1 border" id='dark-mode'>
        <svg class="w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g clip-path="url(#a)" stroke="#000000" stroke-width="1.5" stroke-miterlimit="10"> <path d="M5 12H1M23 12h-4M7.05 7.05 4.222 4.222M19.778 19.778 16.95 16.95M7.05 16.95l-2.828 2.828M19.778 4.222 16.95 7.05" stroke-linecap="round"></path> <path d="M12 16a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" fill="#000000" fill-opacity=".16"></path> <path d="M12 19v4M12 1v4" stroke-linecap="round"></path> </g> <defs> <clipPath id="a"> <path fill="#ffffff" d="M0 0h24v24H0z"></path> </clipPath> </defs> </g></svg>
    </button>
    </h1>

    
    <div class="flex flex-1 items-center justify-center p-6">
        <div class="w-full max-w-2xl">
            <h2 class="font-bold text-xl m-2">Recherche de livres</h2>
            <form class="flex flex-col md:flex-row gap-2 justify-center items-center" action="/" method="GET">

                <select id="filiere" name="filiere" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">Toutes les filières</option>
                    <option value="informatique" <?= $filiere == 'informatique' ? 'selected' : '' ?>>Informatique</option>
                    <option value="gestion" <?= $filiere == 'gestion' ? 'selected' : '' ?>>Gestion</option>
                    <option value="batiment" <?= $filiere == 'batiment' ? 'selected' : '' ?>>Bâtiment et Travaux Publics</option>
                    <option value="hotelerie" <?= $filiere == 'hotelerie' ? 'selected' : '' ?>>Hôtellerie</option>
                </select>
                
                <select id="niveau" name="niveau" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">Tous les niveaux</option>
                    <option value="L2" <?= $niveau == 'L2' ? 'selected' : '' ?>>L2</option>
                    <option value="L3" <?= $niveau == 'L3' ? 'selected' : '' ?>>L3</option>
                    <option value="M1" <?= $niveau == 'M1' ? 'selected' : '' ?>>M1</option>
                    <option value="M2" <?= $niveau == 'M2' ? 'selected' : '' ?>>M2</option>
                </select>

                <button type="submit" class="mt-3 inline-flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Rechercher</button>
            </form>
        </div>
    </div>

    
    <div class="flex flex-col items-center p-4">
        <h2 class="text-2xl m-1">Liste des livres disponibles</h2>
        <table
          class="w-full md:w-4/5 border border-neutral-200 text-center text-sm font-light text-surface dark:border-white/10 dark:text-white">
          <thead
            class="border-b border-neutral-200 bg-blue-800 text-white font-medium dark:border-white/10">
            <tr>
              <th
                scope="col"
                class="border-e border-neutral-200 px-6 py-4 dark:border-white/10">
                Titre
              </th>
              <th
                scope="col"
                class="border-e border-neutral-200 px-6 py-4 dark:border-white/10">
                Filière
              </th>
              <th
                scope="col"
                class="border-e border-neutral-200 px-6 py-4 dark:border-white/10">
                Niveau
              </th>
              <th scope="col" class="px-6 py-4">Actions</th>
            </tr>
          </thead>
          <tbody>

              
              <?php if ($books): ?>
                <?php foreach ($books as $book): ?>
                    
                    <tr class="border-b border-neutral-200 dark:border-white/10">
                    <td
                        class="whitespace-nowrap border-e border-neutral-200 px-6 py-4 font-medium dark:border-white/10 text-start">
                        <?= htmlspecialchars($book['title']); ?>
                    </td>
                    <td
                        class="whitespace-nowrap border-e border-neutral-200 px-6 py-4 dark:border-white/10">
                        <?= htmlspecialchars($book['filiere']); ?>
                    </td>
                    <td
                        class="whitespace-nowrap border-e border-neutral-200 px-6 py-4 dark:border-white/10">
                        <?= htmlspecialchars($book['niveau']); ?>
                    </td>
                    <td class="whitespace-nowrap flex justify-center gap-2 px-6 py-4">
                        <a href="view.php?id=<?= $book['id']; ?>" class="flex items-center gap-2 w-fit bg-blue-200 p-1 rounded">
                        <svg version="1.1" class="w-4" id="Uploaded to svgrepo.com" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" xml:space="preserve" fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <style type="text/css"> .cubies_twaalf{fill:#FFF2DF;} .cubies_elf{fill:#E3D4C0;} .cubies_dertien{fill:#A4C83F;} .cubies_veertien{fill:#BCD269;} .cubies_drie{fill:#837F79;} .st0{fill:#F2C99E;} .st1{fill:#F9E0BD;} .st2{fill:#65C3AB;} .st3{fill:#725A48;} .st4{fill:#8E7866;} .st5{fill:#D97360;} .st6{fill:#98D3BC;} .st7{fill:#C9483A;} .st8{fill:#CCE2CD;} .st9{fill:#EDB57E;} .st10{fill:#EC9B5A;} .st11{fill:#4C4842;} .st12{fill:#67625D;} .st13{fill:#C9C6C0;} .st14{fill:#EDEAE5;} .st15{fill:#D1DE8B;} .st16{fill:#E69D8A;} .st17{fill:#C6B5A2;} .st18{fill:#A5A29C;} .st19{fill:#2EB39A;} .st20{fill:#AB9784;} </style>
                                <g>
                                    <path class="cubies_dertien" d="M29,32H3c-1.657,0-3-1.343-3-3V3c0-1.657,1.343-3,3-3h26c1.657,0,3,1.343,3,3v26 C32,30.657,30.657,32,29,32z"></path>
                                    <path class="cubies_veertien" d="M27,32H3c-1.657,0-3-1.343-3-3V3c0-1.657,1.343-3,3-3h24c1.657,0,3,1.343,3,3v26 C30,30.657,28.657,32,27,32z"></path>
                                    <path class="cubies_elf" d="M25,4H5C4.448,4,4,4.448,4,5v22c0,0.552,0.448,1,1,1h20c0.552,0,1-0.448,1-1V5C26,4.448,25.552,4,25,4z "></path>
                                    <path class="cubies_twaalf" d="M24,28H5c-0.552,0-1-0.448-1-1V5c0-0.552,0.448-1,1-1h19c0.552,0,1,0.448,1,1v22 C25,27.552,24.552,28,24,28z"></path>
                                    <path class="cubies_drie" d="M20.5,9h-12C8.224,9,8,8.776,8,8.5S8.224,8,8.5,8h12C20.776,8,21,8.224,21,8.5S20.776,9,20.5,9z M21,10.5c0-0.276-0.224-0.5-0.5-0.5h-12C8.224,10,8,10.224,8,10.5S8.224,11,8.5,11h12C20.776,11,21,10.776,21,10.5z M21,12.5 c0-0.276-0.224-0.5-0.5-0.5h-12C8.224,12,8,12.224,8,12.5S8.224,13,8.5,13h12C20.776,13,21,12.776,21,12.5z M21,14.5 c0-0.276-0.224-0.5-0.5-0.5h-12C8.224,14,8,14.224,8,14.5S8.224,15,8.5,15h12C20.776,15,21,14.776,21,14.5z M21,16.5 c0-0.276-0.224-0.5-0.5-0.5h-12C8.224,16,8,16.224,8,16.5S8.224,17,8.5,17h12C20.776,17,21,16.776,21,16.5z M21,18.5 c0-0.276-0.224-0.5-0.5-0.5h-12C8.224,18,8,18.224,8,18.5S8.224,19,8.5,19h12C20.776,19,21,18.776,21,18.5z M21,20.5 c0-0.276-0.224-0.5-0.5-0.5h-12C8.224,20,8,20.224,8,20.5S8.224,21,8.5,21h12C20.776,21,21,20.776,21,20.5z M16,22.5 c0-0.276-0.224-0.5-0.5-0.5h-7C8.224,22,8,22.224,8,22.5S8.224,23,8.5,23h7C15.776,23,16,22.776,16,22.5z"></path>
                                </g>
                            </g>
                        </svg>    
                        Voir</a>
                        <a href="<?= htmlspecialchars($book['file_path']); ?>" class="flex items-center gap-2 w-fit bg-blue-200 p-1 rounded" download>Télécharger
                            <lottie-player src="download.json" background="transparent" class="w-8" loop autoplay></lottie-player>
                        </a>
                    </td>
                    </tr>

                <?php endforeach; ?>
                <?php else: ?>
                    <tr class="border-b border-neutral-200 dark:border-white/10">
                        <td
                            colspan="4"
                            class="whitespace-nowrap border-e border-neutral-200 px-6 py-4 font-medium dark:border-white/10">
                            Aucun livre trouvé pour les critères de recherche spécifiés.
                        </td>
                    </tr>
                <?php endif; ?>


          </tbody>
        </table>
</div>


<div class="flex justify-center">
        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
            <a
            href="upload.php"
            class="inline-block rounded-full border-2 border-blue-800 mx-2 px-6 pb-[6px] pt-2 text-xs font-medium uppercase leading-normal text-blue transition duration-150 ease-in-out hover:border-blue-accent-300 hover:bg-blue-50/50 hover:text-blue-accent-300 focus:border-blue-600 focus:bg-blue-50/50 focus:text-blue-600 focus:outline-none focus:ring-0 active:border-blue-700 active:text-blue-700 motion-reduce:transition-none dark:text-blue-500 dark:hover:bg-blue-950 dark:focus:bg-blue-950"
            >
            Téléverser un livre
            </a>
        <?php endif; ?>

        <a
        href="logout.php"
        class="inline-block rounded-full bg-blue-800 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-blue-3 transition duration-150 ease-in-out hover:bg-blue-accent-300 hover:shadow-blue-2 focus:bg-blue-accent-300 focus:shadow-blue-2 focus:outline-none focus:ring-0 active:bg-blue-600 active:shadow-blue-2 motion-reduce:transition-none dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
        >
            Se déconnecter
        </a>
    </div>
</body>

<script>
        document.getElementById('dark-mode').addEventListener('click', function(event) {
            const light_icon = `
             <svg fill="#000000" class="w-6" viewBox="0 0 35 35" data-name="Layer 2" id="Layer_2" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M18.44,34.68a18.22,18.22,0,0,1-2.94-.24,18.18,18.18,0,0,1-15-20.86A18.06,18.06,0,0,1,9.59.63,2.42,2.42,0,0,1,12.2.79a2.39,2.39,0,0,1,1,2.41L11.9,3.1l1.23.22A15.66,15.66,0,0,0,23.34,21h0a15.82,15.82,0,0,0,8.47.53A2.44,2.44,0,0,1,34.47,25,18.18,18.18,0,0,1,18.44,34.68ZM10.67,2.89a15.67,15.67,0,0,0-5,22.77A15.66,15.66,0,0,0,32.18,24a18.49,18.49,0,0,1-9.65-.64A18.18,18.18,0,0,1,10.67,2.89Z"></path></g></svg>
            `;
            const dark_icon = `
        <svg class="w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g clip-path="url(#a)" stroke="#000000" stroke-width="1.5" stroke-miterlimit="10"> <path d="M5 12H1M23 12h-4M7.05 7.05 4.222 4.222M19.778 19.778 16.95 16.95M7.05 16.95l-2.828 2.828M19.778 4.222 16.95 7.05" stroke-linecap="round"></path> <path d="M12 16a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" fill="#000000" fill-opacity=".16"></path> <path d="M12 19v4M12 1v4" stroke-linecap="round"></path> </g> <defs> <clipPath id="a"> <path fill="#ffffff" d="M0 0h24v24H0z"></path> </clipPath> </defs> </g></svg>
            
            `;
            if(document.querySelector('html').className == `dark`) {
                document.querySelector('html').className = 'light';
                document.getElementById('dark-mode').innerHTML = dark_icon;
            } else {
                document.querySelector('html').className = 'dark';
                document.getElementById('dark-mode').innerHTML = light_icon;
            }
        });
</script>

</html>
