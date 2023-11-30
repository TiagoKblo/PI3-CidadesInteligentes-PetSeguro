<?php
// buscar_nome_proprietario.php

require_once __DIR__ . '/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpf = $_POST['cpf'];
    $nomeProprietario = buscarNomeNoBanco($cpf);
    echo $nomeProprietario;
}

function buscarNomeNoBanco($cpf) {
    try {
        $mongoManager = new MongoDBManager('mongo', '27017', 'PetSeguro');
        $proprietariosCollection = $mongoManager->getCollection('proprietarios');

        // Consulta MongoDB para obter o nome do proprietário com base no CPF
        $result = $proprietariosCollection->findOne(['cpf' => $cpf], ['projection' => ['nome' => 1]]);

        return $result ? $result['nome'] : 'Proprietário não encontrado';
    } catch (Exception $e) {
        // Lida com erros ao conectar ao MongoDB
        return 'Erro ao conectar ao MongoDB: ' . $e->getMessage();
    }
}
?>
