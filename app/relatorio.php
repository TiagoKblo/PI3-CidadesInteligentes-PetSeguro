<?php
require_once __DIR__ . '/conexao.php';

// Adicione a chamada da função para buscarAnimaisComEndereco
buscarAnimaisComEndereco();

try {
  $mongoManager = new MongoDBManager('mongo', '27017', 'PetSeguro');
  $animaisCollection = $mongoManager->getCollection('pets');

  $totalAnimais = $animaisCollection->countDocuments();
  $totalPerdidos = $animaisCollection->countDocuments(['animal-perdido' => 'sim']);
  $totalCastrados = $animaisCollection->countDocuments(['castrado' => 'sim']);
  $totalVacinados = $animaisCollection->countDocuments(['animal-vacinado' => 'sim']);
  $especiesCursor = $animaisCollection->distinct('especie');
} catch (Exception $e) {
  echo 'Erro ao consultar estatísticas: ' . $e->getMessage();
  exit;
}

try {
  $dadosAnimaisCollection = $mongoManager->getCollection('dados_animais');
  $bairrosUnicos = $dadosAnimaisCollection->distinct('bairro');
  $dataHoraAtual = $dadosAnimaisCollection->findOne([], ['projection' => ['data_hora_atual' => 1]])['data_hora_atual'];
} catch (Exception $e) {
  echo 'Erro ao consultar estatísticas por bairro: ' . $e->getMessage();
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="imagens/icone.png" type="image/x-icon">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="styles.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="gerarpdf.js" defer></script>
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
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="dashboard_adm.php">Dashboard</a>
              </li>
              <li class="nav-item current-page">
                <a class="nav-link" href="relatorio.php">Relatórios</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
    </div>
  </nav>

  <section class="estatisticas-section" id="estatisticas">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2 class="text-center">Estatísticas Gerais</h2>
          <table class="table">
            <thead>
              <tr>
                <th>Descrição</th>
                <th>Quantidade</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Total de animais registrados</td>
                <td><?= $totalAnimais ?></td>
              </tr>
              <tr>
                <td>Total de animais perdidos</td>
                <td><?= $totalPerdidos ?></td>
              </tr>
              <tr>
                <td>Total de animais castrados</td>
                <td><?= $totalCastrados ?></td>
              </tr>
              <tr>
                <td>Total de animais vacinados</td>
                <td><?= $totalVacinados ?></td>
              </tr>
              <tr>
                <td>Animais por espécie</td>
                <td>
                  <?php foreach ($especiesCursor as $especie) : ?>
                    <?php
                    echo $especie . ': ';
                    $count = $animaisCollection->countDocuments(['especie' => $especie]);

                    if ($especie === 'outro' && !empty($animaisCollection->findOne(['especie' => $especie, 'outra-especie' => ['$exists' => true]])['outra-especie'])) {
                      echo $count . ' - ' . $animaisCollection->findOne(['especie' => $especie])['outra-especie'];
                    } else {
                      echo $count;
                    }

                    echo ', ';
                    ?>
                  <?php endforeach; ?>
                </td>
              </tr>
              <tr>
                <td>Data e hora da última atualização dos dados</td>
                <td><?= $dataHoraAtual ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <h2 class="text-center">Estatísticas por Bairro</h2>
          <table class="table">
            <thead>
              <tr>
                <th>Bairro</th>
                <th>Total de Animais</th>
                <th>Total de Animais Perdidos</th>
                <th>Total de Animais Castrados</th>
                <th>Total de Animais Vacinados</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($bairrosUnicos as $bairro) : ?>
                <tr>
                  <td><?= $bairro ?></td>
                  <td><?= $dadosAnimaisCollection->countDocuments(['bairro' => $bairro]) ?></td>
                  <td><?= $dadosAnimaisCollection->countDocuments(['bairro' => $bairro, 'animal-perdido' => 'sim']) ?></td>
                  <td><?= $dadosAnimaisCollection->countDocuments(['bairro' => $bairro, 'castrado' => 'sim']) ?></td>
                  <td><?= $dadosAnimaisCollection->countDocuments(['bairro' => $bairro, 'animal-vacinado' => 'sim']) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

  <div id="botaopdf">
    <button id="btnGeneratePDF" class="btn btn-primary">Gerar PDF</button>
  </div>

  <footer class="text-center">
    <div class="text-center p-3">
      <a href="https://github.com/TiagoKblo" class="custom-link">© 2023 PatSeguro - Todos os direitos reservados</a>
    </div>
  </footer>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="scripts.js"></script>
</body>

</html>
