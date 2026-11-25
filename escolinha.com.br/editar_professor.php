<?php
require_once "conexao.php";
require_once "functions.php";
/** @var mysqli $conexao */ /**serve para remover o falso erro visual de variável indefinida no VS Code */

$id_professor = (int)($_GET["id"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["nome"]);
    $cpf = trim($_POST["cpf"]);
    $curso = trim($_POST["curso"]);
    $login = trim($_POST["login"]);
    $senha = $_POST["senha"]; // Vazio = mantém a senha atual.

    if (login_existe($conexao, "professores", $login, $id_professor)) {
        echo "Erro: este login já está em uso por outro professor!";
    } elseif (atualizar_professor($conexao, $id_professor, $nome, $cpf, $curso, $login, $senha)) {
        header("Location: listar_professores.php");
        exit;
    } else {
        echo "Não foi possível atualizar.";
    }
}

$resultado = buscar_professor($conexao, $id_professor);
$professor = mysqli_fetch_assoc($resultado);

if (!$professor) {
    die("Professor não encontrado.");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Professor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Editar professor</h1>
    <form method="POST">
        Nome: <input type="text" name="nome" value="<?= htmlspecialchars($professor["nome"]) ?>" required><br><br>
        CPF: <input type="text" name="cpf" value="" placeholder="Digite novamente o CPF" required><br><br>
        Curso: <input type="text" name="curso" value="<?= htmlspecialchars($professor["curso"]) ?>" required><br><br>
        Login: <input type="text" name="login" value="<?= htmlspecialchars($professor["login"]) ?>" required><br><br>
        Nova senha: <input type="password" name="senha"><br>
        <small>Deixe a senha vazia para manter a atual.</small><br><br>
        <button type="submit">Salvar alterações</button>
    </form>
    <br>
    <a href="listar_professores.php">Cancelar e voltar</a>
</body>
</html>