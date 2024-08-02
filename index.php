<?php

session_start();

if (isset($_SESSION['id_usuario'])) {
    header("Location: views/dashboard.php");
    exit;
}

include 'config/config.php';
require_once 'controllers/AuthController.php';

// $authController = new AuthController($mysqli);
$mensagemErro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController = new AuthController($mysqli);
    $authController->login($_POST);
}

$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);

?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postalis | Login</title>
    <link rel="shortcut icon" href="assets/img/logo_postalis.svg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@300;400;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <script src="assets/js/script.js" defer></script>
  </head>
  <body>
    <div class="app">
      <div class="container">
        <div class="content">
          <div class="loginForm">
            <div class="contentForm">
              <div class="header">
                  <div class="logo-container">
                      <img src="assets/img/logo_postalis.svg" alt="Logo">
                      <span class="logo-text">Postalis</span>
                  </div>
                  <h1>Gestão do usuário</h1>
              </div>

              <form id="login-form" action="index.php" method="POST">
                <h2>Login</h2>
                <!-- Mensagem de erro -->
                <p id="error-message" class="error" style="<?= $error ? 'display: block;' : 'display: none;' ?>">
                    <?= htmlspecialchars($error) ?>
                </p>
                <section>
                  <div class="customInput Email">
                      <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z"></path></svg>
                      <input type="email" id="email" name="email" placeholder="E-mail" autocomplete="off">
                  </div>
                  <div class="customInput Password">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zm-104 0H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z"></path></svg>
                    <input type="password" id="senha" name="senha" placeholder="Senha">
                    <svg class="icon-right" id="toggle-password"  stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" width="24" height="24" xmlns="http://www.w3.org/2000/svg"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                  </div>
                </section>
                <p><a href="#">Esqueci minha senha</a></p>
                <button type="submit">ENTRAR</button>
                <div class="lineSeparation">
                    <p>________________________________________________________</p>
                </div>
                <div class="register">
                    <p>Não tem uma conta?</p>
                    <p><a href="views/registrar.php">Registre-se</a></p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>


