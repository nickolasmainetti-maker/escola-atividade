<?php
require_once "conexao.php";
require_once "functions.php";
/** @var mysqli $conexao */ /**serve para remover o falso erro visual de variável indefinida no VS Code */

$id_aluno = (int)($_GET["id"] ?? 0);

if ($id_aluno > 0 && excluir_aluno($conexao, $id_aluno)) {
    header("Location: listar_alunos.php");
    exit;
}

echo "Não foi possível excluir o aluno.";
?>