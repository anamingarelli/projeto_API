<?php

header("Content-Type: application/json");

require "conexao.php";

$metodo = $_SERVER["REQUEST_METHOD"];

if ($metodo == "POST") {

    $json = file_get_contents("php://input");

    $dados = json_decode($json, true);

    if($dados["prioridade"]=="baixa"|| $dados["prioridade"]=="media"||$dados["prioridade"]=="alta"){

        if($dados["status"]=="aberto"||$dados["status"]=="em andamento"||$dados["status"]=="concluido"){

            $sql = "INSERT INTO chamados (equipamento, setor, descricao, prioridade, status) VALUES (?, ?, ?, ?, ? )";

            $comando = $pdo -> prepare($sql);

            $comando -> execute([
                $dados["equipamento"],
                $dados["setor"],
                $dados["descricao"],
                $dados["prioridade"],
                $dados["status"]
                ]);

            echo json_encode(["Mensagem"=>"Chamado cadastrado com sucesso!✅"]);
        } else {
            echo json_encode(["Mensagem" =>"Status inválido. Preencha o campo com: aberto, em andamento ou concluído!🙂"]);
        }
    } else {
            echo json_encode(["Mensagem"=>"Prioridade inválida. Preencha o campo com: baixa, média ou alta"]);

    }

    
};

if ($metodo == "GET") {
    

    $sql = "SELECT * FROM chamados ORDER BY id";

    $comando = $pdo -> query($sql);

    $chamados = $comando -> fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($chamados);
};

if ($metodo == "PUT") {

    $json = file_get_contents("php://input");

    $dados = json_decode($json, true);

     if($dados["prioridade"]=="baixa"|| $dados["prioridade"]=="media"||$dados["prioridade"]=="alta"){

        if($dados["status"]=="aberto"||$dados["status"]=="em andamento"||$dados["status"]=="concluido"){

            $sql = "UPDATE chamados SET equipamento=?, setor=?, descricao=?, prioridade=?, status=? WHERE id=?";

            $comando = $pdo -> prepare($sql);

            $comando -> execute([
            $dados["equipamento"],
            $dados["setor"],
            $dados["descricao"],
            $dados["prioridade"],
            $dados["status"],
            $dados["id"]
            ]);

    echo json_encode([
        "Mensagem"=>"Chamado atualizado com sucesso!☑️"
    ]);
        } else {
            echo json_encode(["Mensagem" =>"Status inválido. Preencha o campo com: aberto, em andamento ou concluído!🙂"]);
        }
    } else {
            echo json_encode(["Mensagem"=>"Prioridade inválida. Preencha o campo com: baixa, média ou alta"]);

    }
};

if ($metodo == "DELETE") {

    $json = file_get_contents("php://input");
    $dados = json_decode($json, true);

    $sql = "DELETE FROM chamados WHERE id = ?";

    $comando = $pdo->prepare($sql);
    
    $comando->execute([
        $dados["id"]
    ]);

    echo json_encode([
        "Mensagem" => "Chamado deletado ❌ com sucesso!"
    ]);
}
?>