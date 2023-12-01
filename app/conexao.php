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

    public function find($collectionName, $filter) {
        $collection = $this->getCollection($collectionName);
        return $collection->find($filter);
    }
}

function buscarProprietarioPorCPF($cpf) {
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

function buscarAnimaisComEndereco() {
    global $mongoManager;

    try {
        // Consulta no MongoDB para encontrar todos os animais
        $animais = $mongoManager->find('pets', []);

        // Array para armazenar os dados dos animais
        $dadosAnimais = [];

        foreach ($animais as $animal) {
            // Consulta no MongoDB para encontrar o proprietário pelo CPF
            $proprietario = buscarProprietarioPorCPF($animal['cpf_proprietario']);

            if ($proprietario) {
                // Monta o objeto com os campos desejados
                $dadosAnimal = [
                    'nome' => $animal['nome'],
                    'especie' => $animal['especie'],
                    'outra-especie' => $animal['outra-especie'],
                    'raca' => $animal['raca'],
                    'cor' => $animal['cor'],
                    'animal-perdido' => $animal['animal-perdido'],
                    'possui-microchip' => $animal['possui-microchip'],
                    'castrado' => $animal['castrado'],
                    'animal-vacinado' => $animal['animal-vacinado'],
                    'nome-proprietario' => $proprietario['nome'],
                    'cep' => $proprietario['cep'],
                    'estado' => $proprietario['estado'],
                    'cidade' => $proprietario['cidade'],
                    'bairro' => $proprietario['bairro'],
                    'rua' => $proprietario['rua'],
                    'numero' => $proprietario['numero'],
                ];

                // Adiciona o animal ao array
                $dadosAnimais[] = $dadosAnimal;
            }
        }

        // Salva os dados em um arquivo JSON
        file_put_contents('dados_animais.json', json_encode($dadosAnimais, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));


    } catch (Exception $e) {
        // Trate a exceção, por exemplo, registrando em logs ou retornando uma mensagem de erro
        echo "Erro: " . $e->getMessage();
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

    // Chama a função para buscar e salvar os dados
    buscarAnimaisComEndereco();
} catch (Exception $e) {
    die("Erro ao conectar ao MongoDB: " . $e->getMessage());
}
?>
