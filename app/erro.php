<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Erro</title>
</head>
<body>
    <h1>Ocorreu um erro</h1>

    <?php
    // Verifica se há uma mensagem de erro na URL
    if (isset($_GET['erro'])) {
        $mensagemErro = urldecode($_GET['erro']);
        echo "<p>Mensagem de erro: $mensagemErro</p>";

        // Adiciona var_dump para mostrar detalhes do erro
        echo "<pre>";
        var_dump($mensagemErro);
        echo "</pre>";
    } else {
        echo "<p>Nenhuma mensagem de erro recebida.</p>";
    }
    ?>

    <!-- Você pode adicionar mais conteúdo à sua página de erro conforme necessário -->
</body>
</html>
