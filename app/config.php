<?php

require_once __DIR__ . '/vendor/autoload.php';

$mongoHost = 'mongo'; // Nome do serviço do MongoDB no docker-compose.yml
$mongoPort = '27017';
$mongoDatabase = 'PetSeguro';
$mongoCollection = 'usuario';

try {
    $mongoClient = new MongoDB\Client("mongodb://$mongoHost:$mongoPort");
    $mongoDB = $mongoClient->$mongoDatabase;
    $collection = $mongoDB->$mongoCollection;

    // Verificação de Conexão
    $listCollections = $mongoDB->listCollections();
    $collectionNames = [];
    foreach ($listCollections as $collectionInfo) {
        $collectionNames[] = $collectionInfo->getName();
    }

    echo "Conexão com MongoDB estabelecida com sucesso. Coleções disponíveis: " . implode(', ', $collectionNames);
} catch (Exception $e) {
    die("Erro ao conectar ao MongoDB: " . $e->getMessage());
}
