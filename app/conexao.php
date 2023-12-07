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
    public function buscar($collectionName, $filter) {
        $collection = $this->getCollection($collectionName);
        return $collection->find($filter);
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

        foreach ($animais as $animal) {
            // Consulta no MongoDB para encontrar o proprietário pelo CPF
            $proprietario = buscarProprietarioPorCPF($animal['cpf_proprietario']);

            if ($proprietario) {
                // Verifica se o animal já existe na coleção 'dados_animais' com base no _id
                $existeAnimal = $mongoManager->findOne('dados_animais', ['_id' => $animal['_id']]);

                if (!$existeAnimal) {
                    // Obter a data e hora atual
                    $dataHoraAtual = new MongoDB\BSON\UTCDateTime();

                    // Converter para um objeto DateTime
                    $dateTime = $dataHoraAtual->toDateTime();

                    // Formatar a data conforme necessário (por exemplo, no formato "Y-m-d H:i:s")
                    $dataHoraFormatada = $dateTime->format("d-m-Y H:i:s");

                    // Monta o objeto com os campos desejados
                    $dadosAnimal = [
                        '_id' => $animal['_id'],
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
                        'data_hora_atual' => $dataHoraFormatada,
                    ];

                    // Insere os dados na nova collection 'dados_animais'
                    $mongoManager->getCollection('dados_animais')->insertOne($dadosAnimal);
                }
            }
        }
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

    // Coleção 'dados_animais'
    $dadosAnimaisCollection = $mongoManager->getCollection('dados_animais');

    // Coleção 'administradores'
    $administradoresCollection = $mongoManager->getCollection('administradores');

    // Restante do código...

    // Chama a função para buscar e salvar os dados
    buscarAnimaisComEndereco();
} catch (Exception $e) {
    die("Erro ao conectar ao MongoDB: " . $e->getMessage());
}
?>
