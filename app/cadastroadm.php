<?php

require_once __DIR__ . '/conexao.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta dados do formulário do administrador
    $dadosAdministrador = [
        'nome' => $_POST['nome'],
        'username' => $_POST['username'],
        'senha' => $_POST['senha'],
        'confirmar-senha' => $_POST['confirmar-senha'],
        'numero-registro' => $_POST['numero-registro'],

    ];

    // Validação de Campos
    $camposObrigatorios = ['nome', 'username', 'senha', 'confirmar-senha', 'numero-registro'];
    foreach ($camposObrigatorios as $campo) {
        if (empty($dadosAdministrador[$campo])) {
            exibirMensagem('Por favor, preencha todos os campos obrigatórios.');
            exit;
        }
    }

    // Verifica se as senhas coincidem
    if ($dadosAdministrador['senha'] !== $dadosAdministrador['confirmar-senha']) {
        exibirMensagem('As senhas não coincidem. Por favor, verifique.');
        exit;
    }

    // Conecta ao MongoDB usando a classe MongoDBManager
    try {
        $mongoManager = new MongoDBManager('mongo', '27017', 'PetSeguro');

        // Obtém a coleção de administradores
        $administradoresCollection = $mongoManager->getCollection('administradores');

        // Adiciona o hash da senha
        $dadosAdministrador['senha'] = password_hash($dadosAdministrador['senha'], PASSWORD_DEFAULT);

        // Remove a confirmação de senha antes de inserir no MongoDB
        unset($dadosAdministrador['confirmar-senha']);

        // Insere o documento do administrador na coleção
        $resultadoCadastroAdministrador = $administradoresCollection->insertOne($dadosAdministrador);

        // Verifica o resultado do cadastro do administrador
        if ($resultadoCadastroAdministrador->getInsertedCount() > 0) {
            exibirMensagem('Cadastro do administrador realizado com sucesso!', 'sucesso');
            // Redireciona para a página admin.html
            header('Location: dashboard_adm.php');
            exit;
        } else {
            exibirMensagem('Erro ao cadastrar o administrador. Por favor, tente novamente.');
        }

    } catch (Exception $e) {
        exibirMensagem('Erro ao conectar ao MongoDB: ' . $e->getMessage());
    }
} else {
    // Redireciona se o formulário não foi enviado
    header('Location: cadastroadm.html');
    exit;
}

function exibirMensagem($mensagem, $tipo = 'erro')
{
    echo "<script>";
    echo "alert('$mensagem');";
    if ($tipo === 'sucesso') {
        echo "window.location.href = 'dashboard_adm.php';";
    } else {
        echo "window.location.href = 'cadastroadm.html';";
    }
    echo "</script>";
    exit;
}
?>
