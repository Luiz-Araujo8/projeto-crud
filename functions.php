<?php
require_once 'config.php';

//JOIN
function getProdutos($pdo, $busca = "", $categoriaId = "") {
    $sql = "SELECT p.*, c.nome as nome_categoria 
            FROM produtos p 
            LEFT JOIN categorias c ON p.categoria_id = c.id 
            WHERE 1=1";
    
    if ($busca != "") {
        $sql .= " AND p.nome LIKE :busca";
    }
    if ($categoriaId != "") {
        $sql .= " AND p.categoria_id = :cat_id";
    }

    $stmt = $pdo->prepare($sql);
    
    if ($busca != "") $stmt->bindValue(':busca', "%$busca%");
    if ($categoriaId != "") $stmt->bindValue(':cat_id', $categoriaId);
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//GROUP BY
function getEstatisticas($pdo) {
    $sql = "SELECT c.nome, COUNT(p.id) as total_produtos, SUM(p.quantidade) as estoque_total
            FROM categorias c
            LEFT JOIN produtos p ON c.id = p.categoria_id
            GROUP BY c.nome";
    
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Excluir
function excluirProduto($pdo, $id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
        return ['sucesso' => true];
    } catch (Exception $e) {
        return ['sucesso' => false, 'msg' => $e->getMessage()];
    }
}
//Salvar ou Atualizar 
function salvarProduto($pdo, $dados) {
    try {
        $id = $dados['id'];
        $nome = $dados['nome'];
        $preco = $dados['preco'];
        $quantidade = $dados['quantidade'];
        $categoria_id = $dados['categoria_id'];
        $descricao = $dados['descricao'];

        if (!empty($id)) {
    
            $sql = "UPDATE produtos SET nome=?, preco=?, quantidade=?, descricao=?, categoria_id=? WHERE id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $preco, $quantidade, $descricao, $categoria_id, $id]);
        } else {
         
            $sql = "INSERT INTO produtos (nome, preco, quantidade, descricao, categoria_id) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $preco, $quantidade, $descricao, $categoria_id]);
        }
        return ['sucesso' => true];
    } catch (PDOException $e) {
        
        return ['sucesso' => false, 'msg' => "Erro no banco de dados: " . $e->getMessage()];
    }
}
?>