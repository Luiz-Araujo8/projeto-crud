<?php
header('Content-Type: application/json');
require_once 'functions.php';


$acao = $_GET['acao'] ?? '';

if ($acao == 'listar') {
    $busca = $_GET['busca'] ?? '';
    $cat = $_GET['categoria'] ?? '';
    $lista = getProdutos($pdo, $busca, $cat);
    echo json_encode($lista);
} 
else if ($acao == 'estatisticas') {
    $stats = getEstatisticas($pdo);
    echo json_encode($stats);
} 
else if ($acao == 'excluir') {
    $id = $_POST['id'] ?? 0;
    $res = excluirProduto($pdo, $id);
    echo json_encode($res);
}
?>