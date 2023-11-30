<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/conexao.php';

// Função para formatar o CPF
function formatarCPF($cpf)
{
    // Remove caracteres não numéricos
    $cpf = preg_replace("/[^0-9]/", "", $cpf);

    // Adiciona os pontos e traço
    $cpfFormatado = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);

    return $cpfFormatado;
}

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
            exibirMensagem('Dados atualizados com sucesso!', 'sucesso');
            // Redireciona para a página de dashboard após a atualização
            header('Location: dashboard_usuario.php');
            exit;
        } else {
            exibirMensagem('Nenhum dado foi atualizado. Por favor, tente novamente.');
        }
    } catch (Exception $e) {
        exibirMensagem('Erro ao conectar ao MongoDB: ' . $e->getMessage());
    }
} else {
    // Redireciona se o formulário não foi enviado
    header('Location: meusdados.php');
    exit;
}

function exibirMensagem($mensagem, $tipo = 'erro')
{
    echo "<script>";
    echo "alert('$mensagem');";
    if ($tipo === 'sucesso') {
        echo "window.location.href = 'dashboard_usuario.php';";
    } else {
        echo "window.location.href = 'meusdados.php';";
    }
    echo "</script>";
    exit;
}
