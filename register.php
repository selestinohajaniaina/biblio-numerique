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
    <script src="lottie-player.js"></script>
</head>

<body>

    <section class="h-screen">
        <div class="h-full flex flex-col">
            <!-- Left column container with background-->
            <h1 class="text-center text-2xl font-bold bg-blue-800 text-white p-5">Inscription au Bibliotheque Virtuel</h1>
            
            <div
            class="flex h-full items-center justify-center md:justify-between">
      <div
        class="shrink-1 md:w-6/12 xl:w-6/12">
        <lottie-player src="book-sign.json" background="transparent" class="w-[80%] my-1 mx-auto hidden md:block" loop autoplay></lottie-player>

      </div>

      <!-- Right column container -->
      <div class="mb-12 md:mb-0 w-4/5 md:w-8/12 lg:w-5/12 xl:w-5/12 p-4">
        <form action="register.php" method="post" class="border p-10 w-full rounded">
          <!--Sign in section-->
          <div
            class="flex flex-row items-center justify-center lg:justify-start">
            <p class="mb-0 me-4 text-xl text-blue-800 font-bold">S'inscrir au biblio</p>
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

          <div class="hidden">
            <select name="role" required>
                <option value="user" selected>Utilisateur</option>
                <option value="admin">Administrateur</option>
            </select>
          </div>

          <!-- Login button -->
          <div class="text-center lg:text-left">
            <button
              type="submit"
              class="inline-block w-full rounded bg-blue-800 px-7 pb-2 pt-3 text-sm font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
              data-twe-ripple-init
              data-twe-ripple-color="light">
              S'inscrir
            </button>

            <!-- Register link -->
            <p class="mb-0 mt-2 pt-1 text-sm font-semibold">
              Vous avez de compte?
              <a
                href="login.php"
                class="text-danger transition duration-150 ease-in-out hover:text-danger-600 focus:text-danger-600 active:text-danger-700"
                >Se Connecter</a
              >
            </p>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

</body>

</html>