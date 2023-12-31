<?php
// Inicia a sessão
session_start();

// Verifica se a sessão do CPF não está definida, redireciona para a página de login
if (!isset($_SESSION['nome_usuario'])) {
    header("Location: login.html");
    exit;
}

// Obtém o nome do usuário a partir da sessão
$nomeUsuario = $_SESSION['nome_usuario'];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Link para o ícone da página -->
  <link rel="icon" href="imagens/icone.png" type="image/x-icon">

  <!-- Link para o Bootstrap CSS  -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">

  <!-- Link para a biblioteca AOS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <!-- Link para a biblioteca Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <!-- Arquivo CSS personalizado para estilos específicos -->
  <link rel="stylesheet" href="styles.css">

  <title>Administrador</title>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
    <div class="container">
      <a class="navbar-brand" href="index.html" data-aos="flip-left" data-aos-duration="3000" data-aos-once="false">
        PetSeguro
      </a>

      <div>
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item current-page">
                <a class="nav-link" href="admin.html">Dashboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="relatorio.php">Relatórios</a>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  Cadastrar
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item" href="cadastro.html">Usuários</a>
                  <a class="dropdown-item" href="cadastropet.html">Animal</a>
                  <a class="dropdown-item" href="cadastro_vet.html">Veteninário</a>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="cadastroadm.html">Novo ADM</a>
              <li class="nav-item">
                <a class="nav-link" href="index.html">Sair</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
  </nav>
<!-- Seção do Gerenciar Usuários -->
<section class="gerenciar-usuarios-section" id="gerenciar-usuarios">
  <div class="container">
      <div class="row justify-content-center text-center mb-5">
          <div class="col-md-8" data-aos="fade-up" data-aos-delay="500">
          <h2 class="section-heading">Bem-vindo, <?php echo $nomeUsuario; ?>!</h2>
              <p class="section-subheading">Gerenciamento e Funcionalidades</p>
          </div>
      </div>

      <div class="row">
        <!-- Gerenciar Veterinários -->
        <div class="col-md-3 mb-3">
          <div class="gerenciar-usuarios-feature text-center">
              <div class="gerenciar-usuarios-icon">
                  <a href="gerenciar_veterinarios.php">
                    <i class="bi bi-person-vcard"></i>
                  </a>
              </div>
              <h3 class="mb-3">Veterinários</h3>

          </div>
      </div>
          <!-- Gerenciar Tutores -->
          <div class="col-md-3 mb-3">
              <div class="gerenciar-usuarios-feature text-center">
                  <div class="gerenciar-usuarios-icon">
                      <a href="gerenciar_usuarios.php">
                          <i class="bi bi-person"></i>
                      </a>
                  </div>
                  <h3 class="mb-3">Tutores</h3>

              </div>
          </div>
          <!-- Gerenciar Animais -->
          <div class="col-md-3 mb-3">
              <div class="gerenciar-usuarios-feature text-center">
                  <div class="gerenciar-usuarios-icon">
                      <a href="gerenciar_animais.php">
                        <i class="bi bi-github"></i>
                      </a>
                  </div>
                  <h3 class="mb-3">Animais</h3>

              </div>
          </div>
          <!-- Caixa de Mensagens e Denúncias -->
          <div class="col-md-3 mb-3">
              <div class="gerenciar-usuarios-feature text-center">
                  <div class="gerenciar-usuarios-icon">
                      <a href="caixa_mensagens.php">
                        <i class="bi bi-envelope"></i>
                      </a>
                  </div>
                  <h3 class="mb-3">Mensagens e Denúncias</h3>

              </div>
          </div>
      </div>
  </div>
</section>





<!-- Rodapé -->
<footer class="text-center">
  <div class="text-center p-3">
      <a href="https://github.com/TiagoKblo" class="custom-link">© 2023 PatSeguro - Todos os direitos reservados</a>
  </div>
</footer>

<!-- Os scripts do Bootstrap e outros scripts necessários -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script src="scripts.js"></script>
</body>

</html>
