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
}
?>

