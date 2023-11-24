<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/conexao.php';

// Verifica se a sessão está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


// Verifica se o CPF foi passado como parâmetro na URL
$cpfProprietario = isset($_GET['cpf']) ? $_GET['cpf'] : null;

// Se o CPF não estiver disponível, redireciona para alguma página de erro ou tratamento adequado
if (!$cpfProprietario) {
    header("Location: login.html");
    exit;
}

try {
    $mongoManager = new MongoDBManager('mongo', '27017', 'PetSeguro');
    $petsCollection = $mongoManager->getCollection('pets');

    // Consulta os animais cadastrados pelo CPF do proprietário
    $animaisCursor = $petsCollection->find(['cpf_proprietario' => $cpfProprietario]);

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
    <title>Meus Animais</title>

    <!-- Link para o ícone da página -->
    <link rel="icon" href="imagens/icone.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>

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
            <a class="navbar-brand" href="index.html" data-aos="flip-left" data-aos-duration="3000"
                data-aos-once="false">
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
                                <a class="nav-link" href="index.html">Início</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="dashboard_usuario.php">Funcionalidades</a>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Sair</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
    </nav>
    <section class="meus-animais-section" id="meus-animais">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Meus Animais</h1>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Espécie</th>
                            <th>Raça</th>
                            <th>Data de Nascimento</th>
                            <th>Visualizar</th> <!-- Nova coluna para o botão -->
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
                                <!-- Adicione mais células conforme necessário -->
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="scripts.js"></script>
    <script>
        document.getElementById('cpf-proprietario').addEventListener('blur', function () {
            document.getElementById('cpf-proprietario-hidden').value = this.value;
        });
    </script>
</body>

</html>
