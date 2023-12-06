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

    public function findAllAnimais() {
        $collection = $this->getCollection('dados_animais');
        return $collection->find();
    }


}

// Crie uma instância do MongoDBManager
$mongoManager = new MongoDBManager('mongo', '27017', 'PetSeguro');

// Escolha a função apropriada com base na necessidade
$animais = $mongoManager->findAllAnimais();



// Converta os resultados para um array
$resultados = iterator_to_array($animais);
error_log('Resultados antes de retornar: ' . print_r($resultados, true));

// Retorne os resultados como JSON
header('Content-Type: application/json');
echo json_encode($resultados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
