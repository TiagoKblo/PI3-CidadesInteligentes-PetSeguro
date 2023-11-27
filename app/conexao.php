<?php
require_once __DIR__ . '/vendor/autoload.php';

class MongoDBManager {
    private $mongoClient;
    private $mongoDB;

    public function __construct($host, $port, $database) {
        $this->mongoClient = new MongoDB\Client("mongodb://$host:$port");
        $this->mongoDB = $this->mongoClient->$database;
    }

    public function getCollection($collectionName) {
        return $this->mongoDB->$collectionName;
    }
    public function findOne($collectionName, $filter) {
        $collection = $this->getCollection($collectionName);
        return $collection->findOne($filter);
    }
}
function buscarProprietarioPorCPF($cpf)
{
    global $mongoManager;

    try {
        // Consulta no MongoDB para encontrar o proprietário pelo CPF
        $proprietarioEncontrado = $mongoManager->findOne('proprietarios', ['cpf' => $cpf]);

        return $proprietarioEncontrado;
    } catch (Exception $e) {
        // Trate a exceção, por exemplo, registrando em logs ou retornando uma mensagem de erro
        return null;
    }
}


try {
    $mongoManager = new MongoDBManager('mongo', '27017', 'PetSeguro');

    // Coleção 'veterinarios'
    $usuarioCollection = $mongoManager->getCollection('veterinarios');

    // Coleção 'pets'
    $petsCollection = $mongoManager->getCollection('pets');

    // Coleção 'proprietarios'
    $proprietariosCollection = $mongoManager->getCollection('proprietarios');

    // Restante do código...
} catch (Exception $e) {
    die("Erro ao conectar ao MongoDB: " . $e->getMessage());
}
?>
