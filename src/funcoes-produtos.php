<?php
require_once "conecta.php";

function listarProdutos(PDO $conexao): array
{
    //$sql = "SELECT * FROM produtos";
    $sql = "SELECT 
               produtos.id, produtos.nome AS produto, 
               produtos.preco, produtos.quantidade,
               fabricantes.nome AS fabricante,
               (produtos.preco * produtos.quantidade) AS total
         FROM produtos INNER JOIN fabricantes
         ON produtos.fabricante_id = fabricantes.id
        ORDER BY produto";


    try {
        $consulta = $conexao->prepare($sql);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $erro) {
        die("Erro ao carregar produtos: " . $erro->getMessage());
    }
}

// inserir produto

function inserirProduto(
    PDO $conexao,
    string $nome,
    float $preco,
    int $quantidade,
    int $fabricanteID,
    string $descricao
): void {
    $sql = "INSERT INTO produtos(nome, preco, quantidade, fabricante_id, descricao) 
            VALUES(:nome, :preco, :quantidade, :fabricante_id, :descricao)";

    try {
        $consulta = $conexao->prepare($sql);

        $consulta->bindValue(":nome", $nome, PDO::PARAM_STR);
        $consulta->bindValue(":preco", $preco, PDO::PARAM_STR);
        $consulta->bindValue(":quantidade", $quantidade, PDO::PARAM_INT);
        $consulta->bindValue(":descricao", $descricao, PDO::PARAM_STR);
        $consulta->bindValue(":fabricante_id", $fabricanteID, PDO::PARAM_INT);

        $consulta->execute();
    } catch (Exception $erro) {
        die("Erro ao inserir produto: " . $erro->getMessage());
    }
}

//lista produto

function listarUmProduto(PDO $conexao, int $idProduto): array
{
    $sql = "SELECT * FROM produtos WHERE id = :id";

    try {
        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":id", $idProduto, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $erro) {
        die("Erro ao carregar produtos:" . $erro->getMessage());
    }
}

//atualizar 

function atualizarProduto(PDO $conexao, int $id,  string $nomeProduto, float $preco, int $quantidade, string $descricao, int $fabricanteID): void
{
    $sql = "UPDATE produtos SET nome = :nome, preco = :preco, quantidade = :quantidade, descricao = :descricao, fabricante_id = :fabricante_id WHERE id = :id";

    try {

        $consulta = $conexao->prepare($sql);

        $consulta->bindValue(":id", $id, PDO::PARAM_INT);
        $consulta->bindValue(":nome", $nomeProduto, PDO::PARAM_STR);
        $consulta->bindValue(":preco", $preco, PDO::PARAM_STR);
        $consulta->bindValue(":quantidade", $quantidade, PDO::PARAM_INT);
        $consulta->bindValue(":descricao", $descricao, PDO::PARAM_STR);
        $consulta->bindValue(":fabricante_id", $fabricanteID, PDO::PARAM_INT);



        $consulta->execute();
    } catch (Exception $erro) {

        die("Erro ao atualizar produto: " . $erro->getMessage());
    }
}

// excluir produto
function excluirProduto(PDO $conexao, int $id): void
{
    $sql = "DELETE FROM produtos WHERE id = :id";
    try {
        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":id", $id, PDO::PARAM_INT);
        $consulta->execute();
    } catch (Exception $erro) {
        die("Erro ao excluir produto: " . $erro->getMessage());
    }
}
