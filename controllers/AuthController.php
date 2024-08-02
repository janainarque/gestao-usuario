<?php

require_once dirname(__DIR__) . '/config/config.php';  // Corrigir o caminho para o config.php
require_once dirname(__DIR__) . '/models/UserModel.php'; // Corrigir o caminho para o UserModel.php

class AuthController {

    private $userModel;

    public function __construct($mysqli) {
        $this->userModel = new UserModel($mysqli);
    }

    // Método para login de usuário
    public function login($postData) {
        $email = $postData['email'] ?? '';
        $senha = $postData['senha'] ?? '';

        if (empty($email)) {
            $_SESSION['error'] = 'Preencha seu e-mail';
            return;
        }

        if (empty($senha)) {
            $_SESSION['error'] = 'Preencha sua senha';
            return;
        }

        $email = $this->userModel->escapeString($email); 
        $senha = $this->userModel->escapeString($senha);

        $usuario = $this->userModel->getUserByEmail($email);

        if (!$usuario || !password_verify($senha, $usuario['senha'])) {
            $_SESSION['error'] = 'Falha ao logar! E-mail ou senha incorretos';
            return;
        }

        session_start();
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nome'] = $usuario['nome'];

        header("Location: views/dashboard.php");
        exit;
    }

    // Método para registro de usuário
    public function register($postData) {
        $nome = $postData['nome'] ?? '';
        $email = $postData['email'] ?? '';
        $cpf = $postData['cpf'] ?? '';
        $senha = $postData['senha'] ?? '';

        if (empty($nome) || empty($email) || empty($cpf) || empty($senha)) {
            return "Por favor, preencha todos os campos.";
        }

        if ($this->userModel->registerUser($nome, $email, $cpf, $senha)) {
            return "Cadastro realizado com sucesso!";
        } else {
            return "Erro ao cadastrar. Por favor, tente novamente.";
        }
    }
}
