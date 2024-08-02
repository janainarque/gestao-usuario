<?php
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    if (!isset($_SESSION['id_usuario'])) {
        // Responder com erro se o usuário não estiver logado
        header('Content-Type: application/json');
        echo json_encode(array('success' => false, 'message' => 'Você não pode acessar esta página porque não está logado.'));
        exit();
    }

    $id_usuario = $_POST['id_usuario'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'] ?? '';
    $data_nascimento = $_POST['data_nascimento'] ?? '';

    // Conecte-se ao banco de dados
    $mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados);
    if ($mysqli->connect_error) {
        // Responder com erro se não conseguir conectar ao banco de dados
        header('Content-Type: application/json');
        echo json_encode(array('success' => false, 'message' => 'Erro ao conectar ao banco de dados: ' . $mysqli->connect_error));
        exit();
    }

    // Atualiza as informações no banco de dados
    $stmt = $mysqli->prepare("UPDATE tab_usuarios SET nome = ?, email = ?, cpf = ?, telefone = ?, data_nascimento = ? WHERE id_usuario = ?");
    $stmt->bind_param("sssssi", $nome, $email, $cpf, $telefone, $data_nascimento, $id_usuario);

    if ($stmt->execute()) {
        $response = array(
            'success' => true,
            'user' => array(
                'nome' => $nome,
                'email' => $email,
                'telefone' => $telefone,
                'cpf' => $cpf,
                'data_nascimento' => $data_nascimento
            )
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Erro ao atualizar perfil. Tente novamente.'
        );
    }

    $stmt->close();
    $mysqli->close();

    // Responder com JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
