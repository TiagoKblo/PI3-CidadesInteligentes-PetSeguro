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
        // ... (outros campos do animal)
        'animal-vacinado' => $_POST['animal-vacinado'],
        'vacinas' => [], // Array para armazenar as informações de vacinação
    ];

    // Verifica se o animal está vacinado antes de processar os campos de vacina
    if ($_POST['animal-vacinado'] === 'sim') {
        // Itera sobre os campos de vacinação e adiciona as informações ao array de vacinas
        for ($i = 0; $i < count($_POST['tipo-vacina']); $i++) {
            $dadosVacina = [
                'tipo-vacina' => $_POST['tipo-vacina'][$i],
                'data-vacina' => $_POST['data-vacina'][$i],
                'validade-vacina' => $_POST['validade-vacina'][$i],
                'lote-vacina' => $_POST['lote-vacina'][$i],
                'fabricante-vacina' => $_POST['fabricante-vacina'][$i],
                'dose-vacina' => $_POST['dose-vacina'][$i],
            ];

            // Adiciona as informações da vacina ao array de vacinas
            $dadosPet['vacinas'][] = $dadosVacina;
        }
    }

    // Conecta ao MongoDB usando a classe MongoDBManager
    try {
        $mongoManager = new MongoDBManager('mongo', '27017', 'PetSeguro');

        // Obtém a coleção de pets
        $petsCollection = $mongoManager->getCollection('pets');

        // Atualiza o documento do pet na coleção
        $resultadoAtualizacaoPet = $petsCollection->updateOne(
            ['cpf_proprietario' => $cpfProprietario],
            ['$set' => ['vacinas' => $dadosPet['vacinas']]]
        );

        // Verifica o resultado da atualização do pet
        if ($resultadoAtualizacaoPet->getModifiedCount() > 0) {
            exibirMensagem('Informações de vacinação atualizadas com sucesso!', 'sucesso');
            // Redireciona para a página apropriada
            header('Location: fichapet.php?cpf=' . $cpfProprietario);
            exit;
        } else {
            exibirMensagem('Erro ao atualizar informações de vacinação. Por favor, tente novamente.');
        }
    } catch (Exception $e) {
        exibirMensagem('Erro ao conectar ao MongoDB: ' . $e->getMessage());
    }
} else {
    // Redireciona se o formulário não foi enviado
    header('Location: fichapet.php?cpf=' . $cpfProprietario);
    exit;
}


?>
