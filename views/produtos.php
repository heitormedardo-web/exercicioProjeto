<?php
session_start();
require_once "config.php";
require_once "funcoes_produtos.php";
include_once "cabecalho.php";
include_once "navbar.php";

$produtos = obterProdutos($pdo);

$mensagem = $_SESSION['mensagem'] ?? '';
$tipo_mensagem = $_SESSION['tipo_mensagem'] ?? '';
unset($_SESSION['mensagem'], $_SESSION['tipo_mensagem']);
?>

<div class="main-container">
    <h1 class="page-title">Gerenciar Produtos</h1>
    
    <?php if ($mensagem): ?>
        <div class="alert alert-<?php echo $tipo_mensagem; ?>">
            <?php echo $mensagem; ?>
        </div>
    <?php endif; ?>
    
    <div class="action-bar">
        <a href="cad_produtos.php" class="btn-add">Novo Produto</a>
    </div>
    
    <?php exibirTabelaProdutos($produtos); ?>
    
    <div style="margin-top: 20px; text-align: center;">
        <p>Total de produtos: <strong><?php echo count($produtos); ?></strong></p>
    </div>
</div>

<style>
.btn-add {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    display: inline-block;
    margin-bottom: 20px;
}
.btn-add:hover {
    background-color: #45a049;
    transform: translateY(-2px);
}
.btn-delete {
    background-color: #f44336;
    color: white;
    padding: 5px 10px;
    text-decoration: none;
    border-radius: 5px;
    font-size: 12px;
    display: inline-block;
}
.btn-delete:hover {
    background-color: #da190b;
}
.preco {
    font-weight: bold;
    color: #4CAF50;
}
.estoque {
    text-align: center;
}
</style>

<?php include_once "footer.php"; ?>