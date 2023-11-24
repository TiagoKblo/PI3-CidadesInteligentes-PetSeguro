<?php
// Inicia a sessão
session_start();

// Verifica se a sessão do CPF não está definida, redireciona para a página de login
if (!isset($_SESSION['cpf_usuario'])) {
    header("Location: login.php");
    exit;
}

// Obtém o CPF e o nome do usuário a partir da sessão
$cpfUsuario = $_SESSION['cpf_usuario'];
$nomeUsuario = $_SESSION['nome_usuario'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Usuario</title>

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
                                <a class="nav-link" href="meusanimais.php?cpf=<?= $cpfUsuario ?>">Meus Animais</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="meusdados.php?cpf=<?= $cpfUsuario ?>"><Main>Atualizar Dados</Main></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Sair</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
    </nav>
<!-- Seção do Dashboard -->
<section class="dashboard-section" id="dashboard">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-md-8" data-aos="fade-up" data-aos-delay="500">
            <h2 class="section-heading">Bem-vindo, <?php echo $nomeUsuario; ?>!</h2>
                <p class="section-subheading">Gerencie suas informações e interaja com as funcionalidades do PetSeguro.</p>
            </div>
        </div>

        <div class="row">
            <!-- Meus animais Cadastrados -->
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="dashboard-feature text-center">
                    <div class="dashboard-icon">
                    <a href="meusanimais.php?cpf=<?= $cpfUsuario ?>">
                            <i class="bi bi-card-checklist"></i>
                        </a>
                    </div>
                    <h3 class="mb-3">Meus Animais Cadastrados</h3>
                    <p>Visualize e gerencie informações detalhadas sobre os animais que você cadastrou.</p>
                </div>
            </div>

            <!-- Meus dados Cadastrais -->
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="dashboard-feature text-center">
                    <div class="dashboard-icon">
                        <a href="meusdados.php?cpf=<?= $cpfUsuario ?>">
                            <i class="bi bi-person"></i>
                        </a>
                    </div>
                    <h3 class="mb-3">Meus Dados Cadastrais</h3>
                    <p>Atualize suas informações cadastrais e mantenha-se informado sobre seu perfil no PetSeguro.</p>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="scripts.js"></script>
</body>

</html>
