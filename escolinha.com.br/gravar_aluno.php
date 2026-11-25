

 <?php
require_once "conexao.php";
require_once "functions.php";
/** @var mysqli $conexao */

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome  = trim($_POST["nome"]);
    $cpf   = trim($_POST["cpf"]);
    $curso = trim($_POST["curso"]);
    $login = trim($_POST["login"]);
    $senha = $_POST["senha"];

    if (login_existe($conexao, "alunos", $login)) {
        $mensagem = "Erro: este login já está cadastrado.";
    } elseif (gravar_aluno($conexao, $nome, $cpf, $curso, $login, $senha)) {
        
        $foto = enviar_foto($_FILES["foto"] ?? null, __DIR__ . "/uploads");
        if ($foto !== false) {
            atualizar_foto_aluno($conexao, md5($cpf), $foto);
            $mensagem = "Aluno cadastrado com foto!";
        } else {
            $mensagem = "Aluno cadastrado, mas houve erro ao enviar a foto.";
        }
    } else {
        $mensagem = "Erro ao cadastrar aluno.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Aluno</title>
</head>
<body>
    <h1>Cadastrar Aluno</h1>
    <?php if ($mensagem !== "") { echo "<p>$mensagem</p>"; } ?>

    <form method="POST" enctype="multipart/form-data">
        Nome: <input type="text" name="nome" required><br><br>
        CPF: <input type="text" name="cpf" required><br><br>
        Curso: <input type="text" name="curso" required><br><br>
        Login: <input type="text" name="login" required><br><br>
        Senha: <input type="password" name="senha" required><br><br>
        Foto: <input type="file" name="foto" accept="image/jpeg,image/png,image/webp" required><br><br>
        <button type="submit">Gravar aluno</button>
    </form>

    <br>
    <a href="listar_alunos.php">Listar alunos</a> | <a href="index.php">Voltar ao menu</a>
</body>
</html>