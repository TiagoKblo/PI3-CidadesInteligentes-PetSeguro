<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>

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
                  <li class="nav-item">
                    <a class="nav-link" href="dashboard_adm.php">Dashboard</a>
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
                    <a class="nav-link" href="index.html">Sair</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
      </nav>

<!-- Seção de Caixa de Mensagens -->
<section class="caixa-mensagens" id="caixa-mensagens">
    <div class="container">
        <div class="row justify-content-center" data-aos="fade-up">
            <div class="col-lg-8">
                <div class="caixa-mensagens-container">
                    <h2>Caixa de Mensagens</h2>

                  <!-- Ícones de mensagens com contadores -->
<div class="icones-mensagens">
    <div class="icone-mensagem" title="Mensagens Enviadas">
        <i class="bi bi-envelope"></i> <!-- Ícone para mensagens enviadas -->
        <span class="contador">5</span> <!-- Número de mensagens enviadas (substitua pelo valor real) -->
    </div>
    <div class="icone-mensagem" title="Total de Mensagens a Responder">
        <i class="bi bi-inbox"></i> <!-- Ícone para total de mensagens a responder -->
        <span class="contador">10</span> <!-- Número total de mensagens a responder (substitua pelo valor real) -->
    </div>
</div>


                    <!-- Formulário para enviar mensagem -->
                    <form id="mensagem-form" action="enviar_mensagem.php" method="post">
                        <div class="mb-3">
                            <label for="mensagem" class="form-label form-label-especial">Escreva sua mensagem:</label>
                            <textarea class="form-control" id="mensagem" name="mensagem" rows="4"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Enviar Mensagem</button>
                    </form>

                    <!-- Lista de mensagens recebidas -->
                    <div class="mensagens-recebidas">
                        <!-- Exemplo de mensagem recebida -->
                        <div class="mensagem">
                            <h3>Remetente:</h3>
                            <p>Conteúdo da mensagem...</p>
                        </div>

                        <!-- Outras mensagens recebidas aqui -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>





    <footer class="text-center">
        <div class="text-center p-3">
            <a href="https://github.com/TiagoKblo" class="custom-link">© 2023 PatSeguro - Todos os direitos
                reservados</a>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>


    <script src="scripts.js"></script>
</body>

</html>
