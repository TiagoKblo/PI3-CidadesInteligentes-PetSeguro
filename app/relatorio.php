<?php
// Incluir o arquivo de conexão e verificar a sessão
require_once __DIR__ . '/conexao.php';

// Adicione a chamada da função para buscarAnimaisComEndereco
buscarAnimaisComEndereco();

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

// Consultar estatísticas gerais
try {
  // Total de animais registrados
  $totalAnimais = $animaisCollection->countDocuments();

  // Total animais perdidos
  $totalPerdidos = $animaisCollection->countDocuments(['animal-perdido' => 'sim']);

  // Total de animais castrados
  $totalCastrados = $animaisCollection->countDocuments(['castrado' => 'sim']);

  // Total de animais vacinados
  $totalVacinados = $animaisCollection->countDocuments(['animal-vacinado' => 'sim']);

  // Animais por espécie
  $especiesCursor = $animaisCollection->distinct('especie');
} catch (Exception $e) {
  echo 'Erro ao consultar estatísticas: ' . $e->getMessage();
  exit;
}

try {
  // Lê o conteúdo do arquivo JSON
  $conteudoJson = file_get_contents('dados_animais.json');

  // Decodifica o JSON para um array associativo
  $dadosAnimais = json_decode($conteudoJson, true);

  // Array para armazenar bairros únicos
  $bairrosUnicos = [];

  // Itera sobre os documentos para obter bairros únicos
  foreach ($dadosAnimais as $animal) {
    if (!in_array($animal['bairro'], $bairrosUnicos)) {
      $bairrosUnicos[] = $animal['bairro'];
    }
  }

  // Recupera a data e hora do primeiro documento (índice 0)
  $dataHoraAtual = $dadosAnimais[0]['data_hora_atual'];
} catch (Exception $e) {
  // Trate a exceção conforme necessário
  echo 'Erro: ' . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Link para o ícone da página -->
  <link rel="icon" href="imagens/icone.png" type="image/x-icon">

  <!-- Link para o Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">

  <!-- Link para a biblioteca AOS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <!-- Link para a biblioteca Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <!-- Arquivo CSS personalizado para estilos específicos -->
  <link rel="stylesheet" href="styles.css">

  <!-- Importação da biblioteca jsPDF e html2canvas -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>

  <title>Administrador</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="gerarpdf.js" defer></script>
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
                <a class="nav-link" href="admin.html">Dashboard</a>
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
  </nav>

  <!-- Adicione as estatísticas à tabela -->
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

                    // Conta os documentos com a espécie específica
                    $count = $animaisCollection->countDocuments(['especie' => $especie]);

                    // Se a espécie for "outro", verifica e exibe "outra-especie" se existir
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
    </div>



    <div class="container">
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
                  <td><?= getTotalAnimaisPorBairro($dadosAnimais, $bairro) ?></td>
                  <td><?= getTotalAnimaisPerdidosPorBairro($dadosAnimais, $bairro) ?></td>
                  <td><?= getTotalAnimaisCastradosPorBairro($dadosAnimais, $bairro) ?></td>
                  <td><?= getTotalAnimaisVacinadosPorBairro($dadosAnimais, $bairro) ?></td>
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

<?php
function getTotalAnimaisPorBairro($dadosAnimais, $bairro)
{
  return count(array_filter($dadosAnimais, function ($animal) use ($bairro) {
    return $animal['bairro'] == $bairro;
  }));
}

function getTotalAnimaisPerdidosPorBairro($dadosAnimais, $bairro)
{
  return count(array_filter($dadosAnimais, function ($animal) use ($bairro) {
    return $animal['bairro'] == $bairro && $animal['animal-perdido'] == 'sim';
  }));
}

function getTotalAnimaisCastradosPorBairro($dadosAnimais, $bairro)
{
  return count(array_filter($dadosAnimais, function ($animal) use ($bairro) {
    return $animal['bairro'] == $bairro && $animal['castrado'] == 'sim';
  }));
}

function getTotalAnimaisVacinadosPorBairro($dadosAnimais, $bairro)
{
  return count(array_filter($dadosAnimais, function ($animal) use ($bairro) {
    return $animal['bairro'] == $bairro && $animal['animal-vacinado'] == 'sim';
  }));
}
?>
