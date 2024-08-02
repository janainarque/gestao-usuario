<?php

require_once dirname(__DIR__) . '/config/config.php';  // Corrigir o caminho para o config.php

class UserModel {

    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function registerUser($nome, $email, $cpf, $senha) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $this->mysqli->prepare("INSERT INTO tab_usuarios (nome, email, cpf, senha) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssss", $nome, $email, $cpf, $senhaHash);
            $success = $stmt->execute();
            $stmt->close();
            return $success;
        }
        return false;
    }

    public function getUserByEmail($email) {
        $stmt = $this->mysqli->prepare("SELECT * FROM tab_usuarios WHERE email = ? LIMIT 1");
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();
            return $user;
        }
        return null;
    }

    public function escapeString($string) {
        return $this->mysqli->real_escape_string($string);
    }

    public function getUserById($id_usuario) {
        $stmt = $this->mysqli->prepare("SELECT * FROM tab_usuarios WHERE id_usuario = ? LIMIT 1");
        if ($stmt) {
            $stmt->bind_param("i", $id_usuario);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();
            return $user;
        }
        return null;
    }

    public function updateProfile($id_usuario, $nome, $email, $cpf, $telefone, $data_nascimento) {
        $stmt = $this->mysqli->prepare("UPDATE tab_usuarios SET nome = ?, email = ?, cpf = ?, telefone = ?, data_nascimento = ? WHERE id_usuario = ?");
        $stmt->bind_param("sssssi", $nome, $email, $cpf, $telefone, $data_nascimento, $id_usuario);

        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }

}
