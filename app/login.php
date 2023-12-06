<?php

require_once __DIR__ . '/conexao.php';

// Inicia a sessão
session_start();

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Validação básica dos campos (você pode adicionar mais validações conforme necessário)
    if (empty($username) || empty($password)) {
        echo 'Por favor, preencha todos os campos.';
        exit;
    }

    try {
        // Conecta ao MongoDB
        $mongoManager = new MongoDBManager('mongo', '27017', 'PetSeguro');
        $proprietariosCollection = $mongoManager->getCollection('proprietarios');

        // Consulta o proprietário pelo nome de usuário
        $proprietarioEncontrado = $proprietariosCollection->findOne(['username' => $username]);

        // Verifica se o proprietário foi encontrado e a senha está correta
        if ($proprietarioEncontrado && password_verify($password, $proprietarioEncontrado['senha'])) {
            // Armazena algumas informações do usuário na sessão
            $_SESSION['cpf_usuario'] = $proprietarioEncontrado['cpf'];
            $_SESSION['nome_usuario'] = $proprietarioEncontrado['nome'];

            // Redireciona para a página de dashboard após o login bem-sucedido
            header("Location: dashboard_usuario.php");
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
