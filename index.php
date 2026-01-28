<?php
require_once 'functions.php';
verificarAutenticacao(); 
?>

<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Produtos</title>
 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
   
</head>
<body>

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container d-flex justify-content-center"> 
        <span class="navbar-brand mb-0 h1 text-uppercase">Sistema de Estoque</span>
    </div>
</nav>

<div class="container">
   

    <div class="d-flex justify-content-center mb-5">
        <a href="form_produto.php" class="btn btn-success btn-lg shadow">+ Adicionar Novo Produto</a>
    </div>
</div>

<div class="container">
    
    <div class="row mb-4" id="stats-container">
    </div>

    <div class="card p-3 mb-4 shadow-sm">
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label text-muted">Pesquisar por nome:</label>
                <input type="text" id="buscaNome" onkeyup="buscarProdutos()" class="form-control" placeholder="Digite o nome do produto...">
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted">Filtrar por Categoria:</label>
                <select id="filtroCategoria" onchange="buscarProdutos()" class="form-select">
                    <option value="">Todas as Categorias</option>
                    <?php
                    try {
                        $cats = $pdo->query("SELECT * FROM categorias")->fetchAll();
                        foreach ($cats as $c) {
                            echo "<option value='{$c['id']}'>{$c['nome']}</option>";
                        }
                    } catch (Exception $e) {
                        echo "<option>Erro ao carregar</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>

    <div class="table-responsive bg-white shadow-sm rounded">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="tabelaProdutos">
                </tbody>
        </table>
    </div>
</div>

<script src="script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>