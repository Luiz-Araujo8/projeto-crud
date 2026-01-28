<?php
require_once 'functions.php';
verificarAutenticacao(); 
?>

<?php
require_once 'functions.php';

$produto = null;
$msg = '';

// POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $dados = [
        'id' => $_POST['id'] ?? '',
        'nome' => htmlspecialchars($_POST['nome']),
        'preco' => filter_var($_POST['preco'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
        'quantidade' => filter_var($_POST['quantidade'], FILTER_SANITIZE_NUMBER_INT),
        'categoria_id' => $_POST['categoria_id'],
        'descricao' => htmlspecialchars($_POST['descricao'])
    ];

    $resultado = salvarProduto($pdo, $dados);
    if ($resultado['sucesso']) {
        header("Location: index.php");
        exit;
    } else {
        $msg = "<div class='alert alert-danger'>" . $resultado['msg'] . "</div>";
    }
}

//GET
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $produto = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Formulário de Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4><?= $produto ? 'Editar Produto' : 'Novo Produto' ?></h4>
                </div>
                <div class="card-body">
                    <?= $msg ?>
                    <form method="POST" action="">
                        <input type="hidden" name="id" value="<?= $produto['id'] ?? '' ?>">
                        
                        <div class="mb-3">
                            <label>Nome:</label>
                            <input type="text" name="nome" class="form-control" required value="<?= $produto['nome'] ?? '' ?>">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Preço (R$):</label>
                                <input type="number" step="0.01" name="preco" class="form-control" required value="<?= $produto['preco'] ?? '' ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Quantidade:</label>
                                <input type="number" name="quantidade" class="form-control" required value="<?= $produto['quantidade'] ?? '' ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Categoria:</label>
                            <select name="categoria_id" class="form-select" required>
                                <option value="">Selecione...</option>
                                <?php
                                $cats = $pdo->query("SELECT * FROM categorias")->fetchAll();
                                foreach ($cats as $c) {
                                    $selected = ($produto && $produto['categoria_id'] == $c['id']) ? 'selected' : '';
                                    echo "<option value='{$c['id']}' $selected>{$c['nome']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Descrição:</label>
                            <textarea name="descricao" class="form-control" rows="3"><?= $produto['descricao'] ?? '' ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <a href="index.php" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>