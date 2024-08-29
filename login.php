<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $query = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $query->execute([$username]);
    $user = $query->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        header('Location: /');
        exit();
    } else {
        $error = "Identifiants incorrects";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
    <script src="lottie-player.js"></script>
    </head>

<body class="dark:bg-gray-900 dark:text-white">
    <section class="h-screen">
        <div class="h-full flex flex-col">
            <!-- Left column container with background-->
            <h1 class="text-center text-2xl font-bold bg-blue-800 text-white p-5">Connexion au Bibliotheque Virtuel</h1>
            
            <div
            class="flex h-full items-center justify-center md:justify-between">
      <div
        class="shrink-1 md:w-6/12 xl:w-6/12">
        <lottie-player src="book.json" background="transparent" class="w-[80%] my-1 mx-auto hidden md:block" loop autoplay></lottie-player>
      </div>

    <?php if (isset($error)): ?>
        <div class="fixed rounded-md bg-red-50 p-4 bottom-0 w-sm m-2 border-2 border-red-200" :class="success ? '' : 'hidden'">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <!-- Heroicon name: solid/check-circle -->
          <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
          </svg>
        </div>
        <div class="ml-3">
          <p class="text-sm font-medium text-red-800"><?= $error; ?></p>
        </div>
        <div class="ml-auto pl-3">
          <div class="-mx-1.5 -my-1.5">
            <button type="button" onClick='return this.parentNode.parentNode.parentNode.parentNode.remove()' class="inline-flex bg-red-50 rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-50 focus:ring-red-600">
              <span class="sr-only">Dismiss</span>
              <!-- Heroicon name: solid/x -->
              <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>

      <!-- Right column container -->
      <div class="mb-12 md:mb-0 w-4/5 md:w-8/12 lg:w-5/12 xl:w-5/12 p-4">
        <form action="login.php" method="post" class="border p-10 w-full rounded">
          <!--Sign in section-->
          <div
            class="flex flex-row items-center justify-center lg:justify-start">
            <p class="mb-0 me-4 text-2xl text-blue-800 font-bold">Se connecter au biblio</p>
          </div>

          <!-- Email input -->
          <div class="relative mb-6" data-twe-input-wrapper-init>
            <label
              for="exampleFormControlInput2"
              >Code d'identification
            </label>
            <input
              type="text"
              name="username"
              class="peer block min-h-[auto] w-full text-gray-800 rounded border border-blue-800 bg-transparent px-3 py-[0.32rem] leading-[2.15] outline-none transition-all duration-200 ease-linear  peer-focus:text-primary data-[twe-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:placeholder:text-neutral-300 dark:autofill:shadow-autofill z-10"
              id="exampleFormControlInput2"
              placeholder="ex: GM3-2024/123" required/>
          </div>

          <!-- Password input -->
          <div class="relative mb-6" data-twe-input-wrapper-init>
            <label
              for="exampleFormControlInput22"
              >Mot de passe
            </label>
            <input
              type="password"
              name="password"
              class="peer block min-h-[auto] w-full text-gray-800 rounded border border-blue-800 bg-transparent px-3 py-[0.32rem] leading-[2.15] outline-none transition-all duration-200 ease-linear  peer-focus:text-primary data-[twe-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none  dark:placeholder:text-neutral-300 dark:autofill:shadow-autofill dark:peer-focus:text-primary"
              id="exampleFormControlInput22"
              placeholder="******" required/>
          </div>

          <!-- Login button -->
          <div class="text-center lg:text-left">
            <button
              type="submit"
              class="inline-block w-full rounded bg-blue-800 px-7 pb-2 pt-3 text-sm font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
              data-twe-ripple-init
              data-twe-ripple-color="light">
              Se connecter
            </button>

            <!-- Register link -->
            <p class="mb-0 mt-2 pt-1 text-sm font-semibold">
              Pas de compte?
              <a
                href="register.php"
                class="text-danger transition duration-150 ease-in-out hover:text-danger-600 focus:text-danger-600 active:text-danger-700"
                >S'inscrir</a
              >
            </p>
          </div>
          <p class="m-1 text-sm text-gray-500">Ce plateforme est une Bibliotheque numerique pour vous aider à trouver vos livre. Rechercher ici les programmes du cours à l'IFT</p>

        </form>
      </div>
    </div>
  </div>
  <div>
  </div>
</section>
</body>

</html>