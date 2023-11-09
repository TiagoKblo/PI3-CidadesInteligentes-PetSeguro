<?php
require_once 'Classes/Usuario.php';

$usuario->verificarAutenticacao();

// Cria uma instância da classe Usuario, passando a conexão como parâmetro
$usuario = new Usuario($conexao);

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados do formulário
    $dadosPet = [
        // Adicione os campos do formulário conforme necessário
        ':nomePet' => $_POST["nome-pet"],
        ':especie' => $_POST["especie"],
        ':outraEspecie' => $_POST["outraEspecie"],
        ':raca' => $_POST["raca"],
        ':dataNascimento' => $_POST["data-nascimento"],
        ':dataObito' => $_POST["data-obito"],
        ':motivoObito' => $_POST["motivo-obito"],
        ':cor' => $_POST["cor"],
        ':sexoAnimal' => $_POST["sexo-animal"],
        ':fotoPet' => isset($_FILES["foto-pet"]["name"]) ? $_FILES["foto-pet"]["name"] : null,
        ':possuiMicrochip' => $_POST["possui-microchip"],
        ':numeroChip' => isset($_POST["numero-do-chip"]) ? $_POST["numero-do-chip"] : null,
        ':tipoSanguineo' => $_POST["tipo-sanguineo"],
        ':castrado' => $_POST["castrado"],
        ':doencasConhecidas' => $_POST["doencas-conhecidas"],
        ':qualDoenca' => isset($_POST["qual-doenca"]) ? $_POST["qual-doenca"] : null,
        ':examesMedicos' => isset($_FILES["exames-medicos"]["name"]) ? $_FILES["exames-medicos"]["name"] : null,
        ':animalVacinado' => $_POST["animal-vacinado"],
        ':tipoVacina' => isset($_POST["tipo-vacina"]) ? $_POST["tipo-vacina"] : null,
        ':dataVacina' => isset($_POST["data-vacina"]) ? $_POST["data-vacina"] : null,
        ':validadeVacina' => isset($_POST["validade-vacina"]) ? $_POST["validade-vacina"] : null,
        ':loteVacina' => isset($_POST["lote-vacina"]) ? $_POST["lote-vacina"] : null,
        ':fabricanteVacina' => isset($_POST["fabricante-vacina"]) ? $_POST["fabricante-vacina"] : null,
        ':doseVacina' => isset($_POST["dose-vacina"]) ? $_POST["dose-vacina"] : null,

    ];

    // Chama a função cadastrarPet da classe Usuario
    $resultado = $usuario->cadastrarPet($dadosPet);

    // Verifica o resultado e redireciona se for bem-sucedido
    if ($resultado > 0) {
        echo "Cadastro do Pet realizado com sucesso!";
        // Adicione redirecionamento ou outra lógica aqui
        header("Location: dashboard_usuario.php");
    } else {
        echo "Erro ao cadastrar o Pet.";
    }
}
?>
