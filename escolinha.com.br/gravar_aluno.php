<?php
require_once "conexao.php";
require_once "functions.php";
/** @var mysqli $conexao */ /**serve para remover o falso erro visual de variável indefinida no VS Code */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["nome"]);
    $cpf = trim($_POST["cpf"]);
    $curso = trim($_POST["curso"]);
    $login = trim($_POST["login"]);
    $senha = $_POST["senha"];

    if (login_existe($conexao, "alunos", $login)) {
        echo "Erro: este login já está cadastrado para outro aluno!";
    } elseif (gravar_aluno($conexao, $nome, $cpf, $curso, $login, $senha)) {
        echo "Aluno cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar aluno. Verifique os dados.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Aluno</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Cadastro de aluno</h1>
    <form method="POST">
        Nome: <input type="text" name="nome" required><br><br>
        CPF: <input type="text" name="cpf" required><br><br>
        Curso: <input type="text" name="curso" required><br><br>
        Login: <input type="text" name="login" required><br><br>
        Senha: <input type="password" name="senha" required><br><br>
        <button type="submit">Gravar aluno</button>
    </form>
    <br>
    <a href="index.php">Voltar ao início</a>
</body>
</html>