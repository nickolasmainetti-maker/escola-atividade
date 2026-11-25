<?php
require_once "conexao.php";
require_once "functions.php";
/** @var mysqli $conexao */

$resultado = listar_professores_com_foto($conexao);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Professores Cadastrados</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Professores cadastrados</h1>
    <a href="gravar_professor.php">Cadastrar novo professor</a> | <a href="index.php">Menu inicial</a>
    <br><br>

    <table border="1" cellpadding="8">
        <tr>
            <th>Foto</th>
            <th>ID</th>
            <th>Nome</th>
            <th>CPF (MD5)</th>
            <th>Curso</th>
            <th>Login</th>
            <th>Ações</th>
        </tr>
        <?php while ($professor = mysqli_fetch_assoc($resultado)) { ?>
        <tr>
            <td>
                <?php if (!empty($professor["foto"])) { ?>
                    <img src="uploads/<?= htmlspecialchars($professor["foto"]) ?>"
                         width="70" height="70" style="object-fit:cover;"
                         alt="Foto do professor">
                <?php } else { ?>
                    Sem foto
                <?php } ?>
            </td>
            <td><?= $professor["id_professor"] ?></td>
            <td><?= htmlspecialchars($professor["nome"]) ?></td>
            <td><?= htmlspecialchars($professor["cpf"]) ?></td>
            <td><?= htmlspecialchars($professor["curso"]) ?></td>
            <td><?= htmlspecialchars($professor["login"]) ?></td>
            <td>
                <a href="editar_professor.php?id=<?= $professor["id_professor"] ?>">Editar</a> |
                <a href="excluir_professor.php?id=<?= $professor["id_professor"] ?>"
                   onclick="return confirm('Tem certeza que deseja excluir este professor?');">Excluir</a>
            </td>
        </tr>
        <?php } ?>
    </table>

</body>
</html>