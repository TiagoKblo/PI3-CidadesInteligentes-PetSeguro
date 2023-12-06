<?php
require_once __DIR__ . '/conexao.php';

// Função para buscar em todas as coleções com base em um filtro
function buscarEmTodasColecoes($filtro) {
    global $mongoManager;

    $colecoes = ['veterinarios', 'pets', 'proprietarios', 'dados_animais'];
    $resultados = [];

    foreach ($colecoes as $colecao) {
        $registros = $mongoManager->buscar($colecao, $filtro);

        foreach ($registros as $registro) {
            $resultados[] = [
                'colecao' => $colecao,
                'dados' => $registro,
            ];
        }
    }

    return $resultados;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomePet = isset($_POST['nome-pet']) ? $_POST['nome-pet'] : '';
    $cpfProprietario = isset($_POST['cpf-proprietario']) ? $_POST['cpf-proprietario'] : '';
    $especie = isset($_POST['especie']) ? $_POST['especie'] : '';
    $outraEspecie = isset($_POST['outra-especie']) ? $_POST['outra-especie'] : '';
    $raca = isset($_POST['raca']) ? $_POST['raca'] : '';
    $dataNascimento = isset($_POST['data-nascimento']) ? $_POST['data-nascimento'] : '';
    $cor = isset($_POST['cor']) ? $_POST['cor'] : '';
    $sexo = isset($_POST['sexo']) ? $_POST['sexo'] : '';
    $porte = isset($_POST['porte']) ? $_POST['porte'] : '';
    $peso = isset($_POST['peso']) ? $_POST['peso'] : '';
    $foto = isset($_POST['foto']) ? $_POST['foto'] : null;
    $animalPerdido = isset($_POST['animal-perdido']) ? $_POST['animal-perdido'] : '';
    $possuiMicrochip = isset($_POST['possui-microchip']) ? $_POST['possui-microchip'] : '';
    $numeroDoChip = isset($_POST['numero-do-chip']) ? $_POST['numero-do-chip'] : '';
    $tipoSanguineo = isset($_POST['tipo-sanguineo']) ? $_POST['tipo-sanguineo'] : '';
    $castrado = isset($_POST['castrado']) ? $_POST['castrado'] : '';
    $doencasConhecidas = isset($_POST['doencas-conhecidas']) ? $_POST['doencas-conhecidas'] : '';
    $qualDoenca = isset($_POST['qual-doenca']) ? $_POST['qual-doenca'] : '';
    $examesMedicos = isset($_POST['exames-medicos']) ? $_POST['exames-medicos'] : null;
    $animalVacinado = isset($_POST['animal-vacinado']) ? $_POST['animal-vacinado'] : '';

    $filtro = [];

    if (!empty($nomePet)) {
        $filtro['nome'] = $nomePet;
    }

    if (!empty($cpfProprietario)) {
        $filtro['cpf_proprietario'] = $cpfProprietario;
    }

    if (!empty($especie)) {
        $filtro['especie'] = $especie;
    }

    if (!empty($outraEspecie)) {
        $filtro['outra-especie'] = $outraEspecie;
    }

    if (!empty($raca)) {
        $filtro['raca'] = $raca;
    }

    if (!empty($dataNascimento)) {
        $filtro['data-nascimento'] = $dataNascimento;
    }

    if (!empty($cor)) {
        $filtro['cor'] = $cor;
    }

    if (!empty($sexo)) {
        $filtro['sexo'] = $sexo;
    }

    if (!empty($porte)) {
        $filtro['porte'] = $porte;
    }

    if (!empty($peso)) {
        $filtro['peso'] = $peso;
    }

    if ($foto !== null) {
        $filtro['foto'] = $foto;
    }

    if (!empty($animalPerdido)) {
        $filtro['animal-perdido'] = $animalPerdido;
    }

    if (!empty($possuiMicrochip)) {
        $filtro['possui-microchip'] = $possuiMicrochip;
    }

    if (!empty($numeroDoChip)) {
        $filtro['numero-do-chip'] = $numeroDoChip;
    }

    if (!empty($tipoSanguineo)) {
        $filtro['tipo-sanguineo'] = $tipoSanguineo;
    }

    if (!empty($castrado)) {
        $filtro['castrado'] = $castrado;
    }

    if (!empty($doencasConhecidas)) {
        $filtro['doencas-conhecidas'] = $doencasConhecidas;
    }

    if (!empty($qualDoenca)) {
        $filtro['qual-doenca'] = $qualDoenca;
    }

    if ($examesMedicos !== null) {
        $filtro['exames-medicos'] = $examesMedicos;
    }

    if (!empty($animalVacinado)) {
        $filtro['animal-vacinado'] = $animalVacinado;
    }

    // Executar a busca usando a função buscarEmTodasColecoes
    $resultados = buscarEmTodasColecoes($filtro);
}
?>
<?php
// Se a busca retornar resultados
if (!empty($resultados)) {
    echo '<h2>Resultados da Busca:</h2>';

    // Iterar pelos resultados
    foreach ($resultados as $resultado) {
        // Exibir informações com base na coleção
        if ($resultado['colecao'] === 'veterinarios') {
            echo '<p>';
            echo 'Nome do Veterinário: ' . $resultado['dados']['nome'] . '<br>';
            echo 'Email: ' . $resultado['dados']['email'] . '<br>';
            // Adicione mais informações específicas de veterinário, se necessário
            echo '</p>';
        } elseif ($resultado['colecao'] === 'proprietarios') {
            echo '<p>';
            echo 'Nome do Proprietário: ' . $resultado['dados']['nome'] . '<br>';
            echo 'Email: ' . $resultado['dados']['email'] . '<br>';
            // Adicione mais informações específicas de proprietário, se necessário
            echo '</p>';
        } elseif ($resultado['colecao'] === 'pets') {
            echo '<p>';
            echo 'Nome do Animal: ' . $resultado['dados']['nome'] . '<br>';
            echo 'Espécie: ' . $resultado['dados']['especie'] . '<br>';
            echo 'Raça: ' . $resultado['dados']['raca'] . '<br>';
            echo 'Cor: ' . $resultado['dados']['cor'] . '<br>';
            echo 'Sexo: ' . $resultado['dados']['sexo'] . '<br>';
            echo 'Porte: ' . $resultado['dados']['porte'] . '<br>';
            echo 'Peso: ' . $resultado['dados']['peso'] . '<br>';
            // Adicione mais informações específicas de animal, se necessário
            echo '</p>';
        }
    }
} else {
    // Se não houver resultados
    echo '<p>Nenhum resultado encontrado.</p>';
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
    </div>
  </nav>

  <section class="estatisticas-section" id="estatisticas">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2 class="text-center">Busca em Todas as Coleções</h2>

          <!-- Formulário de Busca -->
          <form action="busca_global.php" method="post" class="mb-3">
              <label for="campoBusca">Buscar em Todas as Coleções:</label>
              <input type="text" id="campoBusca" name="consulta" required>
              <button type="submit" class="btn btn-primary">Buscar</button>
          </form>

          <!-- Exibição dos Resultados da Busca -->
          <?php
          if (isset($resultados) && !empty($resultados)) {
              echo '<h2>Resultados da Busca:</h2>';
              foreach ($resultados as $resultado) {
                  echo '<p>';
                  echo 'Coleção: ' . $resultado['colecao'] . '<br>';
                  echo 'Dados: ' . json_encode($resultado['dados']);
                  echo '</p>';
              }
          } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
              echo '<p>Nenhum resultado encontrado.</p>';
          }
          ?>

        </div>
      </div>


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
