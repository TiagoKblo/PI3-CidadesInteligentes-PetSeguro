<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/conexao.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém o CPF do proprietário diretamente do formulário
    $cpfProprietario = $_POST['cpf-proprietario'];

    // Coleta dados do formulário do animal de estimação
    $dadosPet = [
        'cpf_proprietario' => $cpfProprietario,
        'nome' => $_POST['nome-pet'],
        'especie' => $_POST['especie'],
        'outra-especie' => isset($_POST['outra-especie']) ? $_POST['outra-especie'] : null,
        'raca' => $_POST['raca'],
        'data-nascimento' => $_POST['data-nascimento'],
        'cor' => $_POST['cor'],
        'sexo' => $_POST['sexo-animal'],
        'porte' => $_POST['porte'],
        'peso' => isset($_POST['peso']) ? $_POST['peso'] : null,
        'foto' => $_FILES['foto-pet']['name'], // Nome do arquivo da foto (será preciso mover o arquivo para um diretório)
        'possui-microchip' => $_POST['possui-microchip'],
        'numero-do-chip' => isset($_POST['numero-do-chip']) ? $_POST['numero-do-chip'] : null,
        'tipo-sanguineo' => $_POST['tipo-sanguineo'],
        'castrado' => $_POST['castrado'],
        'doencas-conhecidas' => $_POST['doencas-conhecidas'],
        'qual-doenca' => isset($_POST['qual-doenca']) ? $_POST['qual-doenca'] : null,
        'exames-medicos' => $_FILES['exames-medicos']['name'], // Nome do arquivo dos exames médicos
        'animal-vacinado' => $_POST['animal-vacinado'],
        'tipo-vacina' => isset($_POST['tipo-vacina']) ? $_POST['tipo-vacina'] : null,
        'data-vacina' => isset($_POST['data-vacina']) ? $_POST['data-vacina'] : null,
        'validade-vacina' => isset($_POST['validade-vacina']) ? $_POST['validade-vacina'] : null,
        'lote-vacina' => isset($_POST['lote-vacina']) ? $_POST['lote-vacina'] : null,
        'fabricante-vacina' => isset($_POST['fabricante-vacina']) ? $_POST['fabricante-vacina'] : null,
        'dose-vacina' => isset($_POST['dose-vacina']) ? $_POST['dose-vacina'] : null,
    ];



    // Conecta ao MongoDB usando a classe MongoDBManager
    try {
        $mongoManager = new MongoDBManager('mongo', '27017', 'PetSeguro');

        // Obtém a coleção de pets
        $petsCollection = $mongoManager->getCollection('pets');

        // Insere o documento do pet na coleção
        $resultadoCadastroPet = $petsCollection->insertOne($dadosPet);

        // Verifica o resultado do cadastro do pet
        if ($resultadoCadastroPet->getInsertedCount() > 0) {
            exibirMensagem('Cadastro do pet realizado com sucesso!', 'sucesso');
            // Redireciona para a página apropriada
            header('Location: admin.html');
            exit;
        } else {
            exibirMensagem('Erro ao cadastrar o pet. Por favor, tente novamente.');
        }
    } catch (Exception $e) {
        exibirMensagem('Erro ao conectar ao MongoDB: ' . $e->getMessage());
    }
} else {
    // Redireciona se o formulário não foi enviado
    header('Location: cadastropet.html');
    exit;
}

function exibirMensagem($mensagem, $tipo = 'erro') {
    echo "<script>";
    echo "alert('$mensagem');";
    if ($tipo === 'sucesso') {
        echo "window.location.href = 'admin.html';";
    } else {
        echo "window.location.href = 'cadastropet.html';";
    }
    echo "</script>";
    exit;
}
?>
