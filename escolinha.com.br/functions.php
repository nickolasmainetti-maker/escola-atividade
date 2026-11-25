<?php

function login_existe($conexao, $tabela, $login, $id_ignorar = 0) {
    $coluna_id = ($tabela == "alunos") ? "id_aluno" : "id_professor";
    $sql = "SELECT $coluna_id FROM $tabela WHERE login = ? AND $coluna_id != ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "si", $login, $id_ignorar);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    return mysqli_num_rows($resultado) > 0;
}


function gravar_aluno($conexao, $nome, $cpf, $curso, $login, $senha) {
    $cpf_md5 = md5($cpf);
    $senha_md5 = md5($senha);

    $sql = "INSERT INTO alunos (nome, cpf, curso, login, senha) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $nome, $cpf_md5, $curso, $login, $senha_md5);
    return mysqli_stmt_execute($stmt);
}


function listar_alunos($conexao) {
    $sql = "SELECT id_aluno, nome, cpf, curso, login FROM alunos ORDER BY nome";
    return mysqli_query($conexao, $sql);
}


function buscar_aluno($conexao, $id_aluno) {
    $sql = "SELECT * FROM alunos WHERE id_aluno = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_aluno);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}


function atualizar_aluno($conexao, $id_aluno, $nome, $cpf, $curso, $login, $senha) {
    $cpf_md5 = md5($cpf);

    if ($senha != "") {
        $senha_md5 = md5($senha);
        $sql = "UPDATE alunos SET nome=?, cpf=?, curso=?, login=?, senha=? WHERE id_aluno=?";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($stmt, "sssssi", $nome, $cpf_md5, $curso, $login, $senha_md5, $id_aluno);
    } else {
        $sql = "UPDATE alunos SET nome=?, cpf=?, curso=?, login=? WHERE id_aluno=?";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $nome, $cpf_md5, $curso, $login, $id_aluno);
    }
    return mysqli_stmt_execute($stmt);
}


function excluir_aluno($conexao, $id_aluno) {
    $sql = "DELETE FROM alunos WHERE id_aluno = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_aluno);
    return mysqli_stmt_execute($stmt);
}


function gravar_professor($conexao, $nome, $cpf, $curso, $login, $senha) {
    $cpf_md5 = md5($cpf);
    $senha_md5 = md5($senha);

    $sql = "INSERT INTO professores (nome, cpf, curso, login, senha) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $nome, $cpf_md5, $curso, $login, $senha_md5);
    return mysqli_stmt_execute($stmt);
}


function listar_professores($conexao) {
    $sql = "SELECT id_professor, nome, cpf, curso, login FROM professores ORDER BY nome";
    return mysqli_query($conexao, $sql);
}


function buscar_professor($conexao, $id_professor) {
    $sql = "SELECT * FROM professores WHERE id_professor = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_professor);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}


function atualizar_professor($conexao, $id_professor, $nome, $cpf, $curso, $login, $senha) {
    $cpf_md5 = md5($cpf);

    if ($senha != "") {
        $senha_md5 = md5($senha);
        $sql = "UPDATE professores SET nome=?, cpf=?, curso=?, login=?, senha=? WHERE id_professor=?";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($stmt, "sssssi", $nome, $cpf_md5, $curso, $login, $senha_md5, $id_professor);
    } else {
        $sql = "UPDATE professores SET nome=?, cpf=?, curso=?, login=? WHERE id_professor=?";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $nome, $cpf_md5, $curso, $login, $id_professor);
    }
    return mysqli_stmt_execute($stmt);
}


function excluir_professor($conexao, $id_professor) {
    $sql = "DELETE FROM professores WHERE id_professor = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_professor);
    return mysqli_stmt_execute($stmt);
}

function enviar_foto($arquivo, $pasta_destino) {
    
    if (!isset($arquivo) || $arquivo["error"] !== UPLOAD_ERR_OK) {
        return false;
    }

   
    if ($arquivo["size"] > 2 * 1024 * 1024) {
        return false;
    }

    
    $info = getimagesize($arquivo["tmp_name"]);
    if ($info === false) {
        return false;
    }

    
    $permitidos = [
        "image/jpeg" => "jpg",
        "image/png" => "png",
        "image/webp" => "webp"
    ];
    $tipo = $info["mime"];
    if (!isset($permitidos[$tipo])) {
        return false;
    }

    
    $nome = bin2hex(random_bytes(16)) . "." . $permitidos[$tipo];
    $destino = rtrim($pasta_destino, "/\\") . DIRECTORY_SEPARATOR . $nome;

    
    if (move_uploaded_file($arquivo["tmp_name"], $destino)) {
        return $nome;
    }

    return false;
}


function atualizar_foto_aluno($conexao, $cpf_md5, $foto) {
    $sql = "UPDATE alunos SET foto = ? WHERE cpf = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $foto, $cpf_md5);
    return mysqli_stmt_execute($stmt);
}


function atualizar_foto_professor($conexao, $cpf_md5, $foto) {
    $sql = "UPDATE professores SET foto = ? WHERE cpf = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $foto, $cpf_md5);
    return mysqli_stmt_execute($stmt);
}


function listar_alunos_com_foto($conexao) {
    $sql = "SELECT id_aluno, nome, cpf, curso, login, foto FROM alunos ORDER BY nome";
    return mysqli_query($conexao, $sql);
}


function listar_professores_com_foto($conexao) {
    $sql = "SELECT id_professor, nome, cpf, curso, login, foto FROM professores ORDER BY nome";
    return mysqli_query($conexao, $sql);
}
?>