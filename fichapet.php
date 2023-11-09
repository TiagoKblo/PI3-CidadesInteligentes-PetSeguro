<?php

require_once 'Classes/Usuario.php';
$usuario = new Usuario($conexao);

// Verifica a autenticação (se necessário)
// $usuario->verificarAutenticacao();

// Obtém a lista de pets
$pets = $usuario->listarPets();
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
                                <a class="nav-link" href="informacoes.html">Informações Públicas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="comunidade.html">Comunidade</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Minha Conta</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
    </nav>

    <section class="ficha-pet" id="ficha-pet">
    <div class="container">
        <h2 class="text-center">Ficha do Pet</h2>

        <?php
        // Verifica se há pets para exibir
        if ($pets) {
            foreach ($pets as $pet) {
        ?>
                <div class="primeiro-elemento">
                    <img src="<?php echo $pet['fotoPet']; ?>" alt="Foto do Pet" class="img-fluid imagem-pet">
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <!-- Dados Gerais -->
                        <h3>Dados Gerais</h3>
                        <table class="table">
                            <tr>
                                <th>Nome:</th>
                                <td><?php echo $pet['nomePet']; ?></td>
                            </tr>
                            <tr>
                                <th>Espécie:</th>
                                <td><?php echo $pet['especie']; ?></td>
                            </tr>
                            <tr>
                                <th>Raça:</th>
                                <td><?php echo $pet['raca']; ?></td>
                            </tr>
                            <tr>
                                <th>Data de Nascimento:</th>
                                <td><?php echo $pet['dataNascimento']; ?></td>
                            </tr>
                        </table>

                        <!-- Informações de Rastreamento -->
                        <h3>Informações de Rastreamento</h3>
                        <table class="table">
                            <tr>
                                <th>Possui Microchip?</th>
                                <td><?php echo $pet['possuiMicrochip'] ? 'Sim' : 'Não'; ?></td>
                            </tr>
                            <tr>
                                <th>Número do Chip:</th>
                                <td><?php echo $pet['numeroChip']; ?></td>
                            </tr>
                        </table>

                        <!-- Informações de Saúde -->
                        <h3>Informações de Saúde</h3>
                        <table class="table">
                            <tr>
                                <th>Tipo Sanguíneo:</th>
                                <td><?php echo $pet['tipoSanguineo']; ?></td>
                            </tr>
                            <tr>
                                <th>Animal é Castrado?</th>
                                <td><?php echo $pet['castrado'] ? 'Sim' : 'Não'; ?></td>
                            </tr>
                            <tr>
                                <th>Doenças Conhecidas:</th>
                                <td><?php echo $pet['doencasConhecidas'] ? 'Sim' : 'Não'; ?></td>
                            </tr>
                            <tr>
                                <th>Qual doença?</th>
                                <td><?php echo $pet['qualDoenca']; ?></td>
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
                                <td><?php echo $pet['animalVacinado'] ? 'Sim' : 'Não'; ?></td>
                            </tr>
                        </table>

                        <!-- Campos de Vacinação (se aplicável) -->
                        <h3>Detalhes da Vacina</h3>
                        <table class="table">
                            <tr>
                                <th>Tipo de Vacina</th>
                                <th>Data da Vacina</th>
                                <th>Validade da Vacina</th>
                                <th>Número do Lote</th>
                                <th>Fabricante da Vacina</th>
                                <th>Número da Dose</th>
                            </tr>
                            <tr>
                                <td><?php echo $pet['tipoVacina']; ?></td>
                                <td><?php echo $pet['dataVacina']; ?></td>
                                <td><?php echo $pet['validadeVacina']; ?></td>
                                <td><?php echo $pet['loteVacina']; ?></td>
                                <td><?php echo $pet['fabricanteVacina']; ?></td>
                                <td><?php echo $pet['doseVacina']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
        <?php
            }
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
