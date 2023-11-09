<?php
require_once 'Classes/Usuario.php';

// Cria uma instância da classe Usuario, passando a conexão como parâmetro
$usuario = new Usuario($conexao);

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados do formulário
    $dadosUsuario = [
        ':id' => '$_POST["id"]',
        ':nome' => $_POST["nome"],
        ':email' => $_POST["email"],
        ':username' => $_POST["username"],
        ':senha' => $_POST["senha"],
        ':telefone' => $_POST["telefone"],
        ':dataNascimento' => $_POST["data-nascimento"],
        ':sexo' => $_POST["sexo"],
        ':quantidadeAnimais' => $_POST["quantidade-animais"],
        ':cep' => $_POST["cep"],
        ':estado' => $_POST["estado"],
        ':cidade' => $_POST["cidade"],
        ':bairro' => $_POST["bairro"],
        ':rua' => $_POST["rua"],
        ':numero' => $_POST["numero"]
    ];

    // Chama a função cadastrarUsuario
    $resultado = $usuario->cadastrarUsuario($dadosUsuario);

    // Verifica o resultado e redireciona se for bem-sucedido
    if ($resultado > 0) {
        echo "Cadastro realizado com sucesso!";
        header("Location: cadastropet.html");
        exit();
    } else {
        echo "Erro ao cadastrar.";
    }
}
?>
