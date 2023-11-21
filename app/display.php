<?php

require_once __DIR__ . '/config.php';
;

try {
    $mongoHost = "mongo"; // Nome do serviço do MongoDB no docker-compose.yml
    $mongoPort = "27017";
    $mongoDatabase = "PetSeguro";
    $collectionName = "usuario";

    $mongoDBConnection = new MongoDBConnection($mongoHost, $mongoPort, $mongoDatabase, $collectionName);

    $cursor = $mongoDBConnection->getAllDocuments();

    // Exibir os resultados
    echo "<h1>Dados do MongoDB</h1>";
    echo "<ul>";

    foreach ($cursor as $document) {
        echo "<li>";
        echo "Nome: " . $document['nome'] . "<br>";
        echo "Email: " . $document['email'] . "<br>";
        echo "Idade: " . $document['idade'] . "<br>";
        echo "</li>";
    }

    echo "</ul>";
} catch (Exception $e) {
    die("Erro ao conectar ao MongoDB: " . $e->getMessage());
}
