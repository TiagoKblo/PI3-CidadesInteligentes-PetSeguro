<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'conexao.php';

// Verifica se o ID do animal de estimação foi fornecido
if (isset($_GET['id'])) {
    $petId = $_GET['id'];
    $petEncontrado = buscarPetPorId($petId);

    if (!$petEncontrado) {
        echo '<p>Animal de estimação não encontrado.</p>';
        // Você pode redirecionar para uma página de erro ou tomar outra ação, se necessário
    }
} else {
    echo '<p>ID do animal de estimação não fornecido.</p>';
    // Você pode redirecionar para uma página de erro ou tomar outra ação, se necessário
}

function buscarPetPorId($petId)
{
    global $mongoManager;

    try {
        // Converte o ID hexadecimal para o formato ObjectId do MongoDB
        $petId = new MongoDB\BSON\ObjectId($petId);

        // Consulta no MongoDB
        $petEncontrado = $mongoManager->findOne('pets', ['_id' => $petId]);

        return $petEncontrado;
    } catch (Exception $e) {
        // Trate a exceção, por exemplo, registrando em logs ou retornando uma mensagem de erro
        return null;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pet</title>

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

    <section class="ficha-pet" id="ficha-pet">
    <div class="container">

        <?php
        // Verifica se há um animal de estimação encontrado
        if ($petEncontrado) {
        ?>
<h2 class="text-center"><?php echo $petEncontrado['nome']; ?></h2>
                <div class="primeiro-elemento">
                    <img src="imagens/golfinho.webp" alt="Foto do Pet" class="img-fluid imagem-pet">
                </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <!-- Dados Gerais -->
                    <h3>Dados Gerais</h3>
                    <table class="table">
                        <tr>
                            <th>Nome do Proprietario:</th>
                            <td><?php echo $petEncontrado['nome']; ?></td>
                        </tr>
                        <tr>
                            <th>Espécie:</th>
                            <td>
                                <?php
                                echo $petEncontrado['especie'];

                                // Verifica se a espécie é "outro" e se há um valor em "outra-especie"
                                if ($petEncontrado['especie'] === 'outro' && !empty($petEncontrado['outra-especie'])) {
                                    echo ' - ' . $petEncontrado['outra-especie'];
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Raça:</th>
                            <td><?php echo $petEncontrado['raca']; ?></td>
                        </tr>
                        <tr>
                            <th>Data de Nascimento:</th>
                            <td><?php echo $petEncontrado['data-nascimento']; ?></td>
                        </tr>
                    </table>

                    <!-- Informações de Rastreamento -->
                    <h3>Informações de Rastreamento</h3>
                    <table class="table">
                        <tr>
                            <th>Possui Microchip?</th>
                            <td><?php echo $petEncontrado['possui-microchip'] ? 'Sim' : 'Não'; ?></td>
                        </tr>
                        <tr>
                            <th>Número do Chip:</th>
                            <td><?php echo $petEncontrado['numero-do-chip']; ?></td>
                        </tr>
                    </table>

                    <!-- Informações de Saúde -->
                        <h3>Informações de Saúde</h3>
                        <table class="table">
                            <tr>
                                <th>Tipo Sanguíneo:</th>
                                <td><?php echo $petEncontrado['tipo-sanguineo']; ?></td>
                            </tr>
                            <tr>
                                <th>Animal é Castrado?</th>
                                <td><?php echo $petEncontrado['castrado'] ? 'Sim' : 'Não'; ?></td>
                            </tr>
                            <tr>
                                <th>Doenças Conhecidas:</th>
                                <td><?php echo $petEncontrado['doencas-conhecidas'] ? 'Sim' : 'Não'; ?></td>
                            </tr>
                            <tr>
                                <th>Qual doença?</th>
                                <td><?php echo $petEncontrado['qual-doenca']; ?></td>
                            </tr>
                        </table>

                        <!-- Exames Médicos -->
                        <h3>Exames Médicos</h3>
                        <p><strong>Anexar Exames Médicos:</strong> [Inserir link ou imagem dos exames médicos, se aplicável]</p>

                        <!-- Vacinas -->
                        <h3>Vacinas</h3>
                        <table class="table">
                            <tr>
                                <th>O animal está Vacinado?</th>
                                <td><?php echo $petEncontrado['animal-vacinado'] ? 'Sim' : 'Não'; ?></td>
                            </tr>
                        </table>

                        <!-- Campos de Vacinação (se aplicável) -->
                        <h3>Detalhes da Vacina</h3>
<table class="table">
    <tr>
        <th>Tipo de Vacina</th>
        <td><?php echo $petEncontrado['tipo-vacina']; ?></td>
    </tr>
    <tr>
        <th>Data da Vacina</th>
        <td><?php echo $petEncontrado['data-vacina']; ?></td>
    </tr>
    <tr>
        <th>Validade da Vacina</th>
        <td><?php echo $petEncontrado['validade-vacina']; ?></td>
    </tr>
    <tr>
        <th>Número do Lote</th>
        <td><?php echo $petEncontrado['lote-vacina']; ?></td>
    </tr>
    <tr>
        <th>Fabricante da Vacina</th>
        <td><?php echo $petEncontrado['fabricante-vacina']; ?></td>
    </tr>
    <tr>
        <th>Número da Dose</th>
        <td><?php echo $petEncontrado['dose-vacina']; ?></td>
    </tr>
</table>

                    </div>
            </div>
        <?php
        } else {
            echo '<p>Nenhum pet encontrado.</p>';
        }
        ?>
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
</body>

</html>
