<?php
require_once 'conexao.php';


class Usuario {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function cadastrarUsuario($dadosUsuario) {
        // Validar nome (não vazio)
        if (empty($dadosUsuario[':nome'])) {
            return false; // Ou você pode lançar uma exceção ou retornar uma mensagem de erro
        }

        // Validar email (formato válido)
        if (!filter_var($dadosUsuario[':email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        // Outras validações para os campos podem ser adicionadas aqui...

        // Adiciona o hash da senha
        $dadosUsuario[':senha'] = password_hash($dadosUsuario[':senha'], PASSWORD_DEFAULT);

        // Prepara a consulta SQL para inserir os dados na tabela 'usuarios'
        $sql = "INSERT INTO usuarios (id, nome, email, username, senha, telefone, data_nascimento, sexo, quantidade_animais, cep, estado, cidade, bairro, rua, numero) VALUES (:id, :nome, :email, :username, :senha, :telefone, :dataNascimento, :sexo, :quantidadeAnimais, :cep, :estado, :cidade, :bairro, :rua, :numero)";

        // Prepara a declaração PDO
        $stmt = $this->conexao->prepare($sql);

        // Executa a declaração com os dados do usuário
        $stmt->execute($dadosUsuario);

        // Retorna o resultado da execução
        return $stmt->rowCount() > 0; // Retorna true se a inserção for bem-sucedida, caso contrário, false
    }
    // Função para listar os pets
    public function listarPets() {
        try {
            $stmt = $this->conexao->query("SELECT * FROM animais");
            $pets = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $pets;
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }
    public function buscarPetPorId($id) {
        try {
            $stmt = $this->conexao->prepare("SELECT * FROM animais WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $pet = $stmt->fetch(PDO::FETCH_ASSOC);

            return $pet;
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }

//Função para autenticar os usuários
    public function autenticarUsuario($username, $senha) {
        // Consulta SQL para obter o usuário com o nome de usuário fornecido
        $sql = "SELECT * FROM usuarios WHERE username = :username";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        // Verifica se o usuário existe
        if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica a senha usando password_verify
            if (password_verify($senha, $usuario['senha'])) {
                // Senha correta, autenticação bem-sucedida
                return true;
            }
        }

        // Nome de usuário ou senha incorretos, autenticação falhou
        return false;
    }
    public function verificarAutenticacao() {
        // Inicia a sessão se ainda não estiver iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Verifica se a variável de sessão 'usuario_logado' está definida
        if (!isset($_SESSION['usuario_logado'])) {
            // Usuário não está logado, redireciona para a página de login
            header("Location: login.html");
            exit();
        }
    }
    public function cadastrarPet($dadosPet)
{
    try {
        $stmt = $this->conexao->prepare("INSERT INTO animais (nomePet, especie, outraEspecie, raca, dataNascimento, dataObito, motivoObito, cor, sexoAnimal, fotoPet, possuiMicrochip, numeroChip, tipoSanguineo, castrado, doencasConhecidas, qualDoenca, examesMedicos, animalVacinado, tipoVacina, dataVacina, validadeVacina, loteVacina, fabricanteVacina, doseVacina) VALUES (:nomePet, :especie, :outraEspecie, :raca, :dataNascimento, :dataObito, :motivoObito, :cor, :sexoAnimal, :fotoPet, :possuiMicrochip, :numeroChip, :tipoSanguineo, :castrado, :doencasConhecidas, :qualDoenca, :examesMedicos, :animalVacinado, :tipoVacina, :dataVacina, :validadeVacina, :loteVacina, :fabricanteVacina, :doseVacina)");

        // Associa os parâmetros
        $stmt->bindParam(':nomePet', $dadosPet[':nomePet']);
        $stmt->bindParam(':especie', $dadosPet[':especie']);
        $stmt->bindParam(':outraEspecie', $dadosPet[':outraEspecie']);
        $stmt->bindParam(':raca', $dadosPet[':raca']);
        $stmt->bindParam(':dataNascimento', $dadosPet[':dataNascimento']);
        $stmt->bindParam(':dataObito', $dadosPet[':dataObito']);
        $stmt->bindParam(':motivoObito', $dadosPet[':motivoObito']);
        $stmt->bindParam(':cor', $dadosPet[':cor']);
        $stmt->bindParam(':sexoAnimal', $dadosPet[':sexoAnimal']);
        $stmt->bindParam(':fotoPet', $dadosPet[':fotoPet']);
        $stmt->bindParam(':possuiMicrochip', $dadosPet[':possuiMicrochip']);
        $stmt->bindParam(':numeroChip', $dadosPet[':numeroChip']);
        $stmt->bindParam(':tipoSanguineo', $dadosPet[':tipoSanguineo']);
        $stmt->bindParam(':castrado', $dadosPet[':castrado']);
        $stmt->bindParam(':doencasConhecidas', $dadosPet[':doencasConhecidas']);
        $stmt->bindParam(':qualDoenca', $dadosPet[':qualDoenca']);
        $stmt->bindParam(':examesMedicos', $dadosPet[':examesMedicos']);
        $stmt->bindParam(':animalVacinado', $dadosPet[':animalVacinado']);
        $stmt->bindParam(':tipoVacina', $dadosPet[':tipoVacina']);
        $stmt->bindParam(':dataVacina', $dadosPet[':dataVacina']);
        $stmt->bindParam(':validadeVacina', $dadosPet[':validadeVacina']);
        $stmt->bindParam(':loteVacina', $dadosPet[':loteVacina']);
        $stmt->bindParam(':fabricanteVacina', $dadosPet[':fabricanteVacina']);
        $stmt->bindParam(':doseVacina', $dadosPet[':doseVacina']);

        // Executa a inserção
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        // Em caso de erro, imprime a mensagem e retorna false
        echo "Erro: " . $e->getMessage();
        return false;
    }
}

}
?>

