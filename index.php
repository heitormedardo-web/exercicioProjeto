<?php

session_start();

require_once "config.php";      
require_once "funcoes.php";
include_once "cabecalho.php";
include_once "navbar.php";


$contatos = obterContatos($pdo);  

$mensagem = $_SESSION['mensagem'] ?? '';
$tipo_mensagem = $_SESSION['tipo_mensagem'] ?? '';
unset($_SESSION['mensagem']);
unset($_SESSION['tipo_mensagem']);
?>

<div class="main-container">
    <h1 class="page-title"> Lista de Contatos</h1>
    
    <?php if ($mensagem): ?>
        <div class="alert alert-<?php echo $tipo_mensagem; ?>">
            <?php echo $mensagem; ?>
        </div>
    <?php endif; ?>
    
    <div class="action-bar">
        <a href="add.php" class="btn-add"> Adicionar Novo Contato</a>
    </div>
    
    <?php exibirTabelaContatos($contatos); ?>
    
    <div style="margin-top: 20px; text-align: center;">
        <p>Total de contatos: <strong><?php echo count($contatos); ?></strong></p>
    </div>

    <div class="action-bar">
    <a href="cadastro_contato.php" class="btn-add"> Novo Contato</a>
    <a href="add.php" class="btn-add-secondary"> Cadastro </a>
</div>
</div>
<style>
    .btn-add-secondary {
        background-color: #2196F3;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        display: inline-block;
        transition: all 0.3s;
        margin-left: 10px;
    }
    
    .btn-add-secondary:hover {
        background-color: #0b7dda;
        transform: translateY(-2px);
    }
</style>
<?php include_once "footer.php"; ?>