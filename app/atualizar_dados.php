<?php

require_once __DIR__ . '/conexao.php';

// Inicializa a mensagem de erro como vazia
$mensagemErro = '';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta dados do formulário do proprietário
    $dadosAtualizados = [
        'email' => $_POST['email'],
        'username' => $_POST['username'],
        'senha' => $_POST['senha'],
        'confirmar-senha' => $_POST['confirmar-senha'],
        'telefone' => $_POST['telefone'],
        // Adicione outros campos que deseja atualizar
    ];

    // Verifica se as senhas coincidem
    if ($dadosAtualizados['senha'] !== $dadosAtualizados['confirmar-senha']) {
        exibirMensagem('As senhas não coincidem. Por favor, verifique.');
        exit;
    }

    // Conecta ao MongoDB usando a classe MongoDBManager
    try {
        $mongoManager = new MongoDBManager('mongo', '27017', 'PetSeguro');

        // Obtém a coleção de proprietários
        $proprietariosCollection = $mongoManager->getCollection('proprietarios');

        // Adiciona o hash da senha
        $dadosAtualizados['senha'] = password_hash($dadosAtualizados['senha'], PASSWORD_DEFAULT);

        // Remove a confirmação de senha antes de atualizar no MongoDB
        unset($dadosAtualizados['confirmar-senha']);

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
        $mensagemErro = 'Erro ao conectar ao MongoDB: ' . $e->getMessage();
    }
} else {
    // Redireciona se o formulário não foi enviado
    header('Location: meusdados.php');
    exit;
}

