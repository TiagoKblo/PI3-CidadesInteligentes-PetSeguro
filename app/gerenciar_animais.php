<?php
// Incluir o arquivo de conexão e verificar a sessão
require_once __DIR__ . '/conexao.php';

// Consultar todos os animais cadastrados
try {
    $mongoManager = new MongoDBManager('mongo', '27017', 'PetSeguro');
    $animaisCollection = $mongoManager->getCollection('pets');

    // Consulta todos os animais
    $animaisCursor = $animaisCollection->find();
} catch (Exception $e) {
    echo 'Erro ao conectar ao MongoDB: ' . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Animais</title>

    <!-- Link para o Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">

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
                <a class="nav-link" href="admin.html">Dashboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="relatorio.html">Relatórios</a>
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

    <section class="gerenciar-animais-section" id="gerenciar-animais">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center">Gerenciar Animais</h1>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Espécie</th>
                                <th>Raça</th>
                                <th>Data de Nascimento</th>
                                <th>Ficha do Animal</th>
                                <th>Opções</th>
                                <th>Comunicar Tutor</th>

                                <!-- Adicione mais colunas conforme necessário -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($animaisCursor as $animal) : ?>
                                <tr>
                                    <td><?= $animal['nome'] ?></td>
                                    <td><?= $animal['especie'] ?></td>
                                    <td><?= $animal['raca'] ?></td>
                                    <td><?= $animal['data-nascimento'] ?></td>
                                    <td><a href="fichapet.php?id=<?= $animal['_id'] ?>">Visualizar</a></td>
                                    <td><a href="editarpet.php?id=<?= $animal['_id'] ?>">Perda</a>
                                        <a href="excluirpet.php?id=<?= $animal['_id'] ?>">Óbito</a></td>
                                        <td><a href="comunicar_tutor.php?id=<?= $animal['_id'] ?>">Enviar Mensagem</a></td>
                                    <!-- Adicione mais colunas conforme necessário -->
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <footer class="text-center">
        <!-- ... (seu código de rodapé) ... -->
    </footer>

    <!-- Os scripts do Bootstrap e outros scripts necessários -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
