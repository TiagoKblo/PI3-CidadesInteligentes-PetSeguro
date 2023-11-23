<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/conexao.php';

// Verifica se a sessão está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Recupera o CPF do usuário autenticado a partir da sessão
$cpfProprietario = isset($_SESSION['cpf_usuario']) ? $_SESSION['cpf_usuario'] : null;

// Se o CPF não estiver disponível na sessão, redireciona para a página de login
if (!$cpfProprietario) {
    header("Location: login.php");
    exit;
}

try {
    $mongoManager = new MongoDBManager('mongo', '27017', 'PetSeguro');
    $usuariosCollection = $mongoManager->getCollection('proprietarios');

    // Consulta o usuário pelo CPF
    $usuarioEncontrado = $usuariosCollection->findOne(['cpf' => $cpfProprietario]);

    // Verifica se o usuário foi encontrado
    if (!$usuarioEncontrado) {
        // Redireciona para uma página de erro ou exibe uma mensagem amigável
        header("Location: erro.php");
        exit;
    }

} catch (Exception $e) {
    // Registra o erro de forma segura, não exibindo detalhes sensíveis na tela
    error_log('Erro ao conectar ao MongoDB: ' . $e->getMessage());
    // Redireciona para uma página de erro ou exibe uma mensagem amigável
    header("Location: erro.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Dados</title>

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
                                <a class="nav-link" href="index.html">Início</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="informacoes.html">Informações Públicas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="comunidade.html">Comunidade</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="meusdados.php">Meus Dados</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <section class="ficha-usuario" id="ficha-usuario">
        <div class="container">
            <h2 class="text-center">Meus Dados</h2>

            <?php
            // Verifica se há um usuário encontrado
            if ($usuarioEncontrado) {
            ?>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <!-- Dados Gerais -->
                        <h3>Dados Gerais</h3>

<form action="atualizar_dados.php" method="post">
    <table class="table">
        <tr>
            <th>Nome:</th>
            <td><?php echo $usuarioEncontrado['nome']; ?></td>
        </tr>
        <tr>
            <th>Email:</th>
            <td>
                <input type="text" name="email" value="<?php echo $usuarioEncontrado['email']; ?>">
            </td>
        </tr>
        <tr>
            <th>Username:</th>
            <td>
                <input type="text" name="username" value="<?php echo $usuarioEncontrado['username']; ?>">
            </td>
        </tr>
        <tr>
            <th>Senha:</th>
            <td>
                <input type="password" name="senha" placeholder="Digite a nova senha">
            </td>
        </tr>
        <th>Confirmar Senha:</th>
            <td>
                <input type="password" name="confirmar-senha" placeholder="Confirme a nova senha">
            </td>
        </tr>
        <tr>
        <tr>
            <th>Telefone:</th>
            <td>
                <input type="text" name="telefone" value="<?php echo $usuarioEncontrado['telefone']; ?>">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="submit">Atualizar Dados</button>
            </td>
        </tr>
    </table>
</form>
                            <tr>
                                <th>Nome:</th>
                                <td><?php echo $usuarioEncontrado['nome']; ?></td>
                            </tr>

                            <tr>
                                <th>Data de Nascimento:</th>
                                <td><?php echo $usuarioEncontrado['data-nascimento']; ?></td>
                            </tr>
                            <tr>
                                <th>CPF:</th>
                                <td><?php echo $usuarioEncontrado['cpf']; ?></td>
                            </tr>
                            <tr>
                                <th>Sexo:</th>
                                <td><?php echo $usuarioEncontrado['sexo']; ?></td>
                            </tr>
                            <tr>
                                <th>Quantidade de Animais:</th>
                                <td><?php echo $usuarioEncontrado['quantidade-animais']; ?></td>
                            </tr>
                        </table>

                        <!-- Endereço -->
                        <h3>Endereço</h3>
                        <table class="table">
                            <tr>
                                <th>CEP:</th>
                                <td><?php echo $usuarioEncontrado['cep']; ?></td>
                            </tr>
                            <tr>
                                <th>Estado:</th>
                                <td><?php echo $usuarioEncontrado['estado']; ?></td>
                            </tr>
                            <tr>
                                <th>Cidade:</th>
                                <td><?php echo $usuarioEncontrado['cidade']; ?></td>
                            </tr>
                            <tr>
                                <th>Bairro:</th>
                                <td><?php echo $usuarioEncontrado['bairro']; ?></td>
                            </tr>
                            <tr>
                                <th>Rua:</th>
                                <td><?php echo $usuarioEncontrado['rua']; ?></td>
                            </tr>
                            <tr>
                                <th>Número:</th>
                                <td><?php echo $usuarioEncontrado['numero']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            <?php
            } else {
                echo '<p>Nenhum usuário encontrado.</p>';
            }
            ?>
        </div>
    </section>

    <footer class="text-center">
        <div class="text-center p-3">
            <a href="https://github.com/TiagoKblo" class="custom-link">© 2023 PatSeguro - Todos os direitos reservados</a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="scripts.js"></script>
</body>

</html>
