<?php


require_once __DIR__ . '/conexao.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta dados do formulário
    $dadosVeterinario = [
        'nome' => $_POST['nome'],
        'email' => $_POST['email'],
        'username' => $_POST['username'],
        'senha' => $_POST['senha'],
        'confirmar-senha' => $_POST['confirmar-senha'],
        'celular' => $_POST['celular'],
        'crmv' => $_POST['crmv'],
        'nome_estabelecimento' => $_POST['nome_estabelecimento'],
        'telefone' => $_POST['telefone'],
        'cnpj' => $_POST['cnpj'],
        'cep' => $_POST['cep'],
        'estado' => $_POST['estado'],
        'cidade' => $_POST['cidade'],
        'bairro' => $_POST['bairro'],
        'rua' => $_POST['rua'],
        'numero' => $_POST['numero'],
    ];

    // Verifica se as senhas coincidem
    if ($dadosVeterinario['senha'] !== $dadosVeterinario['confirmar-senha']) {
        echo "As senhas não coincidem. Por favor, verifique.";
        exit;
    }

    // Conecta ao MongoDB usando a classe MongoDBManager
    $mongoManager = new MongoDBManager('mongo', '27017', 'PetSeguro');

    // Acesso à coleção 'veterinarios'
    $collection = $mongoManager->getCollection('veterinarios');

    // Adiciona o hash da senha
    $dadosVeterinario['senha'] = password_hash($dadosVeterinario['senha'], PASSWORD_DEFAULT);

    // Remove a confirmação de senha antes de inserir no MongoDB
    unset($dadosVeterinario['confirmar-senha']);

    // Insere o documento na coleção
    $resultadoCadastro = $collection->insertOne($dadosVeterinario);

    // Verifica o resultado do cadastro
    if ($resultadoCadastro->getInsertedCount() > 0) {
        echo "Cadastro realizado com sucesso!";
        // Redireciona para a página admin.html
        header('Location: admin.html');
        exit;
    } else {
        echo "Erro ao cadastrar. Por favor, tente novamente.";
    }
} else {
    // Redireciona se o formulário não foi enviado
    header('Location: cadastro_vet.html');
    exit;
}
?>
