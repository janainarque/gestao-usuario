<?php 

  // if(!isset($_SESSION)) {
  //   session_start();
  // }

  // if(!isset($_SESSION['id_usuario'])) {
  //   die("Você não pode acessar esta página porque não está logado.<p><a href=\"../views/logout.php\">Sair</a></p>");
  // }

  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../views/logout.php");
    exit();
  }

  function sanitize_input($data) {
      return htmlspecialchars(stripslashes(trim($data)));
  }

  function generate_csrf_token() {
      if (!isset($_SESSION['csrf_token'])) {
          $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
      }
      return $_SESSION['csrf_token'];
  }

  function validate_csrf_token($token) {
      return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
  }


?>