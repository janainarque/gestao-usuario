<?php
// views/registrar.php

include('../config/config.php');
require_once('../controllers/AuthController.php');

$mensagemErro = '';
$successMessage = '';
$resultado = ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController = new AuthController($mysqli);
    $mensagemErro = $authController->register($_POST);

    if (strpos($resultado, 'Erro') !== false) {
      $mensagemErro = $resultado;
    } elseif (strpos($resultado, 'Cadastro realizado com sucesso!') !== false) {
        $successMessage = $resultado;
    }
}

// Fechar a conexão
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postalis | Registrar</title>
    <link rel="shortcut icon" href="../assets/img/logo_postalis.svg" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/registrar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@300;400;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <script src="../assets/js/registrar.js" defer></script>
</head>
<body>
    <div class="app">
        <div class="container">
            <div class="content">
                <div class="loginForm">
                    <div class="contentForm">
                        <form action="registrar.php" method="post">
                            <h2>Crie sua conta</h2>
                            <?php if (!empty($mensagemErro)): ?>
                                <div class="error-popup">
                                    <div class="error-popup-content">
                                        <?= htmlspecialchars($mensagemErro) ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($successMessage)): ?>
                                <div class="success-popup">
                                    <div class="success-popup-content">
                                        <?= htmlspecialchars($successMessage) ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <section>
                                <div class="customInput Nome">
                                    <!-- SVG and Input here -->
                                    <input type="text" name="nome" placeholder="Seu nome" autocomplete="off">
                                </div>
                                <div class="customInput Email">
                                    <!-- SVG and Input here -->
                                    <input type="text" name="email" placeholder="E-mail" autocomplete="off">
                                </div>
                                <div class="customInput cpf">
                                    <!-- SVG and Input here -->
                                    <input type="text" name="cpf" placeholder="Seu CPF" autocomplete="off">
                                </div>
                                <div class="customInput Password">
                                    <!-- SVG and Input here -->
                                    <input type="password" name="senha" placeholder="Senha">
                                </div>
                            </section>
                            <p>
                                Ao se registrar, você aceita nossos 
                                <a href="#" class="underline">termos de uso</a> e a
                                <br> 
                                <a href="#" class="underline">nossa política de privacidade</a>.
                            </p>
                            <button type="submit">CADASTRAR</button>
                        </form>
                        <div class="header">
                            <div class="logo-container">
                                <img src="../assets/img/logo_postalis.svg" alt="Logo">
                                <span class="logo-text">Postalis</span>
                            </div>
                            <h1>Com você no seu futuro </h1>
                            <span class="login-conta">Já tem conta? <a href="../index.php">Faça seu login<a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
