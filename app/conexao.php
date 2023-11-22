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
}

try {
    $mongoManager = new MongoDBManager('mongo', '27017', 'PetSeguro');

    // Exemplo de uso com a coleção 'veterinarios'
    $usuarioCollection = $mongoManager->getCollection('veterinarios');

    // Você pode criar mais instâncias da coleção para outras coleções, por exemplo:
    // $outraColecao = $mongoManager->getCollection('outraColecao');

    // Restante do código...
} catch (Exception $e) {
    die("Erro ao conectar ao MongoDB: " . $e->getMessage());
}
?>
