<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/conexao.php';

// Inicializa a mensagem de erro como vazia
$mensagemErro = '';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém o status atual de perda do animal
    $statusPerdaAtual = $_POST['statusPerdaAtual'];

    // Inverte o status (de 'sim' para 'nao' e vice-versa)
    $novoStatusPerda = ($statusPerdaAtual === 'sim') ? 'nao' : 'sim';

    // Atualiza apenas o campo 'animal-perdido'
    $dadosAtualizados = ['$set' => ['animal-perdido' => $novoStatusPerda]];

    // Conecta ao MongoDB usando a classe MongoDBManager
    try {
        $mongoManager = new MongoDBManager('mongo', '27017', 'PetSeguro');

        // Obtém a coleção de pets
        $petsCollection = $mongoManager->getCollection('pets');

        // Substitui o ID fixo por uma variável usando $_POST['idPet']
        $petId = $_POST['idPet'];

        // Atualiza o documento do pet na coleção usando o campo _id como identificador
        $resultadoAtualizacao = $petsCollection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectID($petId)],
            $dadosAtualizados
        );

        // Verifica o resultado da atualização
        if ($resultadoAtualizacao->getModifiedCount() > 0) {
            exibirMensagem('Status de perda atualizado com sucesso!', 'sucesso', 'admin.html');
            exit;
        } else {
            exibirMensagem('Erro ao atualizar o status de perda. Nenhuma modificação necessária ou documento não encontrado.', 'erro', 'erro.php');
        }
    } catch (MongoDB\Driver\Exception\Exception $e) {
        $mensagemErro = 'Erro do MongoDB: ' . $e->getMessage();
    } catch (Exception $e) {
        $mensagemErro = 'Erro desconhecido: ' . $e->getMessage();
    }

    // Redireciona para a página de erro com a mensagem de erro
    exibirMensagem($mensagemErro, 'erro', 'erro.php');
}

function exibirMensagem($mensagem, $tipo = 'erro', $paginaDestino = 'cadastropet.html') {
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
?>
