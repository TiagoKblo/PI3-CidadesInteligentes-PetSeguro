<?php
require_once 'conexao.php';

class Usuario {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function cadastrarUsuario($dadosUsuario) {
        // Prepara a consulta SQL para inserir os dados na tabela 'usuarios'
        $sql = "INSERT INTO usuarios (id, nome, email, username, senha, telefone, data_nascimento, sexo, quantidade_animais, cep, estado, cidade, bairro, rua, numero) VALUES (:id, :nome, :email, :username, :senha, :telefone, :dataNascimento, :sexo, :quantidadeAnimais, :cep, :estado, :cidade, :bairro, :rua, :numero)";

        // Prepara a declaração PDO
        $stmt = $this->conexao->prepare($sql);

        // Executa a declaração com os dados do usuário
        $stmt->execute($dadosUsuario);

        // Retorna o resultado da execução
        return $stmt->rowCount();
    }
}
?>

