<?php


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
    $dadosProprietario = [
        'nome' => $_POST['nome'],
        'email' => $_POST['email'],
        'username' => $_POST['username'],
        'senha' => $_POST['senha'],
        'confirmar-senha' => $_POST['confirmar-senha'],
        'telefone' => $_POST['telefone'],
        'data-nascimento' => $_POST['data-nascimento'],
        'cpf' => formatarCPF($_POST['cpf']), // Formata o CPF antes de salvar
        'sexo' => $_POST['sexo'],
        'cep' => $_POST['cep'],
        'estado' => $_POST['estado'],
        'cidade' => $_POST['cidade'],
        'bairro' => $_POST['bairro'],
        'rua' => $_POST['rua'],
        'numero' => $_POST['numero'],
    ];

    // Validação de Campos
    $camposObrigatorios = ['nome', 'email', 'username', 'senha', 'confirmar-senha', 'cpf'];
    foreach ($camposObrigatorios as $campo) {
        if (empty($dadosProprietario[$campo])) {
            exibirMensagem('Por favor, preencha todos os campos obrigatórios.');
            exit;
        }
    }

    // Verifica se as senhas coincidem
    if ($dadosProprietario['senha'] !== $dadosProprietario['confirmar-senha']) {
        exibirMensagem('As senhas não coincidem. Por favor, verifique.');
        exit;
    }

    // Conecta ao MongoDB usando a classe MongoDBManager
    try {
        $mongoManager = new MongoDBManager('mongo', '27017', 'PetSeguro');

        // Obtém a coleção de proprietários
        $proprietariosCollection = $mongoManager->getCollection('proprietarios');

        // Adiciona o hash da senha
        $dadosProprietario['senha'] = password_hash($dadosProprietario['senha'], PASSWORD_DEFAULT);

        // Remove a confirmação de senha antes de inserir no MongoDB
        unset($dadosProprietario['confirmar-senha']);

        // Insere o documento do proprietário na coleção
        $resultadoCadastroProprietario = $proprietariosCollection->insertOne($dadosProprietario);

        // Verifica o resultado do cadastro do proprietário
        if ($resultadoCadastroProprietario->getInsertedCount() > 0) {
            exibirMensagem('Cadastro do proprietário realizado com sucesso!', 'sucesso');
            // Redireciona para a página admin.html
            header('Location: admin.html');
            exit;
        } else {
            exibirMensagem('Erro ao cadastrar o proprietário. Por favor, tente novamente.');
        }

    } catch (Exception $e) {
        exibirMensagem('Erro ao conectar ao MongoDB: ' . $e->getMessage());
    }
} else {
    // Redireciona se o formulário não foi enviado
    header('Location: cadastro.html');
    exit;
}

function exibirMensagem($mensagem, $tipo = 'erro')
{
    echo "<script>";
    echo "alert('$mensagem');";
    if ($tipo === 'sucesso') {
        echo "window.location.href = 'admin.html';";
    } else {
        echo "window.location.href = 'cadastro.html';";
    }
    echo "</script>";
    exit;
}
?>
