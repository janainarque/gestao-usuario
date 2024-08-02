<?php

$hostname = "localhost";
$bancodedados = "gestao_usuario";
$usuario = "root";
$senha = "";

// Conexão com o MySQL (sem especificar o banco de dados)
$mysqli = new mysqli($hostname, $usuario, $senha);

// Verifica conexão
if ($mysqli->connect_errno) {
    error_log("Falha ao conectar ao MySQL: " . $mysqli->connect_error);
    die("Falha ao conectar ao banco de dados.");
}

// Cria o banco de dados se não existir
if (!$mysqli->select_db($bancodedados)) {
    $sql = "CREATE DATABASE `$bancodedados`";
    if ($mysqli->query($sql) === TRUE) {
        echo "Banco de dados criado com sucesso.\n";
        // Seleciona o banco de dados recém-criado
        $mysqli->select_db($bancodedados);
    } else {
        error_log("Erro ao criar o banco de dados: " . $mysqli->error);
        die("Erro ao criar o banco de dados.");
    }
} else {
    // Banco de dados já existe, apenas seleciona
    $mysqli->select_db($bancodedados);
}

// Criação da tabela de usuários
$sql = "
    CREATE TABLE IF NOT EXISTS tab_usuarios (
        id_usuario INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(255) NOT NULL,
        email VARCHAR(140) NOT NULL UNIQUE,
        cpf VARCHAR(14) NOT NULL UNIQUE,
        telefone VARCHAR(20),
        senha VARCHAR(255) NOT NULL,
        data_nascimento DATE,
        data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
";

if ($mysqli->query($sql) === TRUE) {
    echo "Tabela de usuários criada com sucesso.\n";
} else {
    error_log("Erro ao criar a tabela de usuários: " . $mysqli->error);
    die("Erro ao criar a tabela de usuários.");
}

// Fecha a conexão
$mysqli->close();

?>
