<?php

require_once __DIR__ . '/conexao.php';

// Inicia a sessão
session_start();

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $userType = isset($_POST['userType']) ? $_POST['userType'] : '';

    // Validação básica dos campos
    if (empty($username) || empty($password) || empty($userType) || !in_array($userType, ['proprietario', 'veterinario', 'administrador'])) {
        echo 'Por favor, preencha todos os campos corretamente.';
        exit;
    }

    try {
        // Conecta ao MongoDB
        $mongoManager = new MongoDBManager('mongo', '27017', 'PetSeguro');

        // Configurações específicas para cada tipo de usuário
        if ($userType === 'proprietario') {
            $collectionName = 'proprietarios';
            $redirectPage = 'dashboard_usuario.php';
        } elseif ($userType === 'veterinario') {
            $collectionName = 'veterinarios'; // Substitua pelo nome correto da coleção de veterinários
            $redirectPage = 'dashboard_veterinario.php'; // Substitua pelo nome correto da página para veterinários
        } elseif ($userType === 'administrador') {
            $collectionName = 'administradores'; // Substitua pelo nome correto da coleção de administradores
            $redirectPage = 'dashboard_adm.php'; // Substitua pelo nome correto da página para administradores
        }

       // Consulta o usuário pelo nome de usuário
$usuarioEncontrado = $mongoManager->getCollection($collectionName)->findOne(['username' => $username]);

// Verifica se o usuário foi encontrado e a senha está correta
if ($usuarioEncontrado && password_verify($password, $usuarioEncontrado['senha'])) {
    // Armazena algumas informações do usuário na sessão
    $_SESSION['nome_usuario'] = $usuarioEncontrado['nome'];

    // Adiciona lógica específica para administradores, veterinários ou proprietários
    if ($userType === 'administrador') {
        // Lógica adicional para administradores, se necessário
    } elseif ($userType === 'veterinario') {
        // Lógica adicional para veterinários, se necessário
    } elseif ($userType === 'proprietario') {
        // Armazena o CPF na sessão para proprietários
        $_SESSION['cpf_usuario'] = $usuarioEncontrado['cpf'];
    }

    // Redireciona para a página de dashboard após o login bem-sucedido
    header("Location: $redirectPage");
    exit;
} else {
    echo 'Nome de usuário ou senha incorretos.';
    exit;
}

    } catch (Exception $e) {
        // Registra o erro de forma segura, não exibindo detalhes sensíveis na tela
        error_log('Erro ao conectar ao MongoDB: ' . $e->getMessage());
        // Redireciona para uma página de erro ou exibe uma mensagem amigável
        header("Location: erro.php");
        exit;
    }
}
?>
