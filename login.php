<?php
require_once 'Classes/Usuario.php';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados do formulário
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Cria uma instância da classe Usuario, passando a conexão como parâmetro
    $usuario = new Usuario($conexao);

    // Realiza a autenticação do usuário

    $autenticado = $usuario->autenticarUsuario($username, $password);

    // Verifica se a autenticação foi bem-sucedida
    if ($autenticado) {
        echo "Login realizado com sucesso!";
        // Redireciona para a página desejada após o login
        
        header("Location: dashboard_usuario.php");
        exit();
    } else {
        echo "Nome de usuário ou senha incorretos.";
    }
}
?>
