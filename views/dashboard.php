<?php 

  require_once ('../config/protecao.php');
  require_once '../models/UserModel.php';

if (!isset($_SESSION['id_usuario'])) {
    die("Você não pode acessar esta página porque não está logado.");
}

// Conecte-se ao banco de dados
$mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados);
if ($mysqli->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $mysqli->connect_error);
}

// Instancie o modelo do usuário e obtenha os dados do usuário
$userModel = new UserModel($mysqli);
$user = $userModel->getUserById($_SESSION['id_usuario']);

if (!$user) {
    die("Usuário não encontrado.");
}

// Feche a conexão com o banco de dados
$mysqli->close();

// Função para obter as iniciais do nome
function getInitials($name) {
  $words = explode(' ', $name);
  $initials = '';
  foreach ($words as $word) {
      if (!empty($word)) {
          $initials .= strtoupper($word[0]);
      }
  }
  return $initials;
}

// Obtem o nome do usuário e gera as iniciais
$nomeCompleto = $user['nome'];
$iniciais = getInitials($nomeCompleto);

// Função para formatar o CPF
function formatCPF($cpf) {
  if (strlen($cpf) == 11) {
      return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9);
  }
  return $cpf;
}

// // Função para formatar a data de nascimento
// function formatDate($date) {
//   $dateObj = DateTime::createFromFormat('Y-m-d', $date);
//   if ($dateObj) {
//       return $dateObj->format('d/m/Y');
//   }
//   return $date;
// }

// Função para formatar a data de nascimento
function formatDate($date) {
  if (empty($date) || $date === '0000-00-00') {
      return '';
  }

  $dateObj = DateTime::createFromFormat('Y-m-d', $date);
  if ($dateObj && $dateObj->format('Y-m-d') === $date) {
      return $dateObj->format('d/m/Y');
  }
  return '';
}

// Use essas funções para formatar os dados
$formattedCPF = formatCPF($user['cpf']);
$formattedDate = formatDate($user['data_nascimento']);


// Mensagens de sucesso e erro
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciar perfil | Postalis</title>
  <link rel="stylesheet" href="../assets/css/dashboard.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>
  <main>
    <aside class="sidebar" data-sidebar>
      <div class="sidebar-info">
      <div class="profile-circle">
          <span class="profile-initials"><?php echo htmlspecialchars($iniciais); ?></span>
      </div>
      <div class="info-content">
          <h1 class="name"><?php echo htmlspecialchars($user['nome']); ?></h1>
          <p class="title">Developer</p>
      </div>
      <div class="sidebar-info_more">
          <ul class="contacts-list">
              <li class="contact-item">
                  <div class="icon-box">
                      <ion-icon name="person-outline"></ion-icon>
                  </div>
                  <div class="contact-info">
                      <p class="contact-title">CPF</p>
                      <a href="#" class="contact-link cpf"><?php echo htmlspecialchars(formatCPF($user['cpf'])); ?></a>
                  </div>
              </li>
              <li class="contact-item">
                  <div class="icon-box">
                      <ion-icon name="mail-outline"></ion-icon>
                  </div>
                  <div class="contact-info">
                      <p class="contact-title">Email</p>
                      <a href="#" class="contact-link email"><?php echo htmlspecialchars($user['email']); ?></a>
                  </div>
              </li>
              <li class="contact-item">
                  <div class="icon-box">
                      <ion-icon name="phone-portrait-outline"></ion-icon>
                  </div>
                  <div class="contact-info">
                      <p class="contact-title">Telefone</p>
                      <a href="#" class="contact-link telefone"><?php echo htmlspecialchars($user['telefone']); ?></a>
                  </div>
              </li>
              <li class="contact-item">
                  <div class="icon-box">
                      <ion-icon name="calendar-outline"></ion-icon>
                  </div>
                  <div class="contact-info">
                      <p class="contact-title">Aniversário</p>
                      <time class="aniversario"><?php echo htmlspecialchars(formatDate($user['data_nascimento'])); ?></time>
                  </div>
              </li>
          </ul>
      </div>

    </aside>


    <div class="main-content">

      <!--#NAVBAR-->
      <nav class="navbar">
        <ul class="navbar-list">
          <li class="navbar-item">
            <button class="navbar-link  active" data-nav-link>Sobre</button>
          </li>
          <li class="navbar-item">
            <button class="navbar-link" data-nav-link>Editar</button>
          </li>
          <li> <a href="logout.php" title="Sair">
            <button class="modal-close-btn">
              <ion-icon name="close-outline" role="img" class="md hydrated" aria-label="close outline"></ion-icon>
            </button></a>
          </li>
        </ul>
      </nav>

      <article class="about  active" data-page="sobre">
        <header>
          <h2 class="h2 article-title">Sobre mim</h2>
        </header>
        <section class="about-text">
          <p>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since
            the 1500s, when an unknown printer took a galley of type and scrambled it to a make a type specimen book. It has survived not only five centuries, but
            also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets 
          </p>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pretium tortor nulla, ac rutrum dui porttitor a. Orci a varius natoque penatibus
            et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque eleifend feugiat auctor. Cras elementum tellus urna, sed venenatis
            lacus placerat id. Nam quis sagittis arcu. Integer eget risus. Ut a pulvinar mi, quis sollicitudin sem. Integer eget tempor nibh, id malesuada mauris. Suspendisse potenti.
          </p>
        </section>

        <section class="service">
          <h3 class="h3 service-title">Estudando</h3>
          <ul class="service-list">
            <li class="service-item">
              <div class="service-icon-box">
                <img src="../assets/img/react.svg
                " alt="design icon" width="40">
              </div>
              <div class="service-content-box">
                <h4 class="h4 service-item-title">React</h4>
                <p class="service-item-text">
                  Biblioteca front-end JavaScript de código aberto com foco em criar interfaces de usuário em páginas web
                </p>
              </div>
            </li>
            <li class="service-item">
              <div class="service-icon-box">
                <img src="../assets/img/figma.svg" alt="Web development icon" width="40">
              </div>
              <div class="service-content-box">
                <h4 class="h4 service-item-title">Figma</h4>
                <p class="service-item-text">
                  Editor gráfico de vetor e prototipagem de projetos de design baseado principalmente no navegador web
                </p>
              </div>
            </li>
          </ul>

        </section>


        <section class="ability">
          <h3 class="h3 ability-title">Habilidades</h3>
          <ul class="ability-list has-scrollbar">
            <li class="ability-item">
              <div class="content-card" data-ability-item>
                <h4 class="h4 ability-item-title" data-ability-title>Liderança de Equipe</h4>
                <div class="ability-text" data-ability-text>
                  <p>
                    Experiência: Coordenar e motivar equipes de desenvolvimento de software.
                  </p>
                  <p>
                    Habilidades: Planejamento de projetos, delegação de tarefas, gerenciamento de conflitos e facilitação de comunicação eficaz.
                  </p>
                  <p>
                    Resultados: Garantir a entrega pontual de projetos e a melhoria contínua do desempenho da equipe.
                  </p>
                </div>
              </div>
            </li>
            <li class="ability-item">
              <div class="content-card" data-ability-item>
                <h4 class="h4 ability-item-title" data-ability-title>Desenvolvimento</h4>
                <div class="ability-text" data-ability-text>
                  <p>
                    Desenvolvimento de aplicações web robustas utilizando frameworks populares como Laravel e CodeIgniter.
                  </p>
                  <p>
                    JavaScript: Criação de interfaces dinâmicas e interativas, incluindo o uso de bibliotecas e frameworks como React, Angular e jQuery.
                  </p>
                  <p>
                    Projetos: Implementação de funcionalidades do lado do servidor e do cliente, garantindo uma experiência de usuário eficiente e responsiva.
                  </p>
                </div>
              </div>
            </li>
            <li class="ability-item">
              <div class="content-card" data-ability-item>
                <h4 class="h4 ability-item-title" data-ability-title>HTML e CSS</h4>
                <div class="ability-text" data-ability-text>
                  <p>
                    Estruturação de páginas web de forma semântica e acessível.
                  </p>
                  <p>
                    Estilização de interfaces de usuário utilizando CSS3 e pré-processadores como SASS e LESS.
                  </p>
                  <p>
                    Design Responsivo: Desenvolvimento de layouts adaptáveis para diferentes dispositivos, garantindo uma experiência de usuário consistente.
                </div>
              </div>
            </li>
            <li class="ability-item">
              <div class="content-card" data-ability-item>
                <h4 class="h4 ability-item-title" data-ability-title>Bancos de Dados</h4>
                <div class="ability-text" data-ability-text>
                  <p>
                    SQL Server, PostgreSQL e MySQL: Modelagem de dados, escrita de consultas SQL eficientes e otimização de desempenho.
                  </p>
                  <p>
                    Administração de Banco de Dados: Manutenção, backup e recuperação de dados, além de garantir a segurança e integridade das informações.
                  </p>
                  <p>
                    Integração: Conectar e gerenciar bancos de dados em aplicações web, assegurando uma comunicação fluida entre o frontend e o backend.
                  </p>
                </div>

              </div>
            </li>
          </ul>
        </section>

        <div class="modal-container" data-modal-container>
          <div class="overlay" data-overlay></div>
          <section class="ability-modal">
            <button class="modal-close-btn" data-modal-close-btn>
              <ion-icon name="close-outline"></ion-icon>
            </button>
            <div class="modal-img-wrapper">
              <img src="../assets/img/icon-quote.svg" alt="quote icon">
            </div>
            <div class="modal-content">
              <h4 class="h3 modal-title" data-modal-title>Liderança de Equipe</h4>
              <div data-modal-text>
                <p>
                  Experiência: Coordenar e motivar equipes de desenvolvimento de software.
                </p>
              </div>
            </div>

          </section>

        </div>

      </article>


      <article class="edit" data-page="editar">

        <header>
          <h2 class="h2 article-title">Editar perfil</h2>
        </header>

        <section class="edit-form">
          <form id="editProfileForm" action="../controllers/UpdateProfile.php" method="POST" class="form" data-form>
            <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($_SESSION['id_usuario']); ?>">
            <br>
            <div class="input-wrapper">
              <label>Nome:</label>
              <input type="text" class="form-input" id="nome" name="nome" value="<?php echo htmlspecialchars($user['nome']); ?>" required data-form-input>
            </div>
            <div class="input-wrapper">
              <label>CPF:</label>
              <input type="text" class="form-input" id="cpf" name="cpf" value="<?php echo htmlspecialchars($user['cpf']); ?>" required data-form-input>
            </div>
            <div class="input-wrapper">
              <label>Email:</label>
              <input type="email" class="form-input" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required data-form-input>
            </div>
            <div class="input-wrapper">
              <label>Telefone:</label>
              <input type="text" class="form-input" id="telefone" name="telefone" value="<?php echo htmlspecialchars($user['telefone']); ?>">
            </div>
            <div class="input-wrapper">
              <label>Data de aniversário:</label>
              <input type="date" class="form-input" id="data_nascimento" name="data_nascimento" value="<?php echo htmlspecialchars($user['data_nascimento']); ?>">
            </div>
            <button class="form-btn" type="submit">
              <ion-icon name="pencil-outline"></ion-icon>
              <span>Salvar</span>
            </button>
          </form>
        </section>

      </article>

    </div>

  </main>


  <!-- <script src="../assets/js/dashboard.js"></script> -->
  <script src="../assets/js/editar.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>