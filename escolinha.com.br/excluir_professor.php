<?php
require_once "conexao.php";
require_once "functions.php";
/** @var mysqli $conexao */ /**serve para remover o falso erro visual de variável indefinida no VS Code */

$id_professor = (int)($_GET["id"] ?? 0);

if ($id_professor > 0 && excluir_professor($conexao, $id_professor)) {
    header("Location: listar_professores.php");
    exit;
}

echo "Não foi possível excluir o professor.";
?>