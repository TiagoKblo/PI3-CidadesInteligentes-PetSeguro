<?php
session_start();
// Verifica se a sessão está iniciada
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/conexao.php';

function exibirMensagem($mensagem, $tipo = 'erro', $paginaDestino = 'meusdados.php') {
    $urlDestino = $paginaDestino;
    if ($mensagem !== '') {
        $urlDestino .= '?erro=' . urlencode($mensagem);
    }
    echo "<script>";
    echo "alert('$mensagem');";
    echo "window.location.href = '$urlDestino';";
    echo "</script>";
    exit;
}

// Inicializa a mensagem de erro como vazia
$mensagemErro = '';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta dados do formulário do proprietário
    $dadosAtualizados = [
        'email' => htmlspecialchars($_POST['email']),
        'username' => htmlspecialchars($_POST['username']),
        'senha' => $_POST['senha'],
        'telefone' => htmlspecialchars($_POST['telefone']),
        // Adicione outros campos que deseja atualizar
    ];

    // Verifica se as senhas coincidem
    if ($dadosAtualizados['senha'] !== $_POST['confirmar-senha']) {
        exibirMensagem('As senhas não coincidem. Por favor, verifique.');
        exit;
    }

    // Adiciona o hash da senha se ela estiver presente
    if (!empty($dadosAtualizados['senha'])) {
        $dadosAtualizados['senha'] = password_hash($dadosAtualizados['senha'], PASSWORD_DEFAULT);
    } else {
        // Remove a senha se ela não estiver presente nos dados atualizados
        unset($dadosAtualizados['senha']);
    }

    // Conecta ao MongoDB usando a classe MongoDBManager
    try {
        $mongoManager = new MongoDBManager('mongo', '27017', 'PetSeguro');

        // Obtém a coleção de proprietários
        $proprietariosCollection = $mongoManager->getCollection('proprietarios');

        // Atualiza o documento do proprietário na coleção
        $filtro = ['cpf' => $_SESSION['cpf_usuario']]; // Utiliza o CPF da sessão para identificar o proprietário
        $atualizacao = ['$set' => $dadosAtualizados];
        $resultadoAtualizacao = $proprietariosCollection->updateOne($filtro, $atualizacao);

        // Verifica o resultado da atualização do proprietário
        if ($resultadoAtualizacao->getMatchedCount() > 0 && $resultadoAtualizacao->getModifiedCount() > 0) {
            exibirMensagem('Dados atualizados com sucesso!', 'sucesso', 'dashboard_usuario.php');
            exit;
        } else {
            exibirMensagem('Nenhum dado foi atualizado. Por favor, tente novamente.', 'erro', 'meusdados.php');
        }
    } catch (Exception $e) {
        $mensagemErro = 'Erro ao conectar ao MongoDB: ' . htmlspecialchars($e->getMessage());
        exibirMensagem($mensagemErro, 'erro', 'meusdados.php');
    }
} else {
    // Redireciona se o formulário não foi enviado
    header('Location: meusdados.php');
    exit;
}
?>
