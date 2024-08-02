<?php 

$hostname = "localhost";
$bancodedados = "gestao_usuario";
$usuario = "root";
$senha = "";

// Conexão com o MySQL
$mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados);

// Verifica conexão
if ($mysqli->connect_errno) {
  error_log("Falha ao conectar ao banco de dados: " . $mysqli->connect_error);
  die("Falha ao conectar ao banco de dados.");
}


$mysqli->set_charset("utf8");

?>

