<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servidor = "localhost";
$banco = "dbescola";
$usuario = "root";
$senha = "123456"; 
try {
    $conexao = mysqli_connect($servidor, $usuario, $senha, $banco);
    mysqli_set_charset($conexao, "utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("Falha ao conectar no banco de dados: " . $e->getMessage());
}
?>