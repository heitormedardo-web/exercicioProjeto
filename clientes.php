<?php
session_start();
require_once "config.php";
include_once "cabecalho.php";
include_once "navbar.php";

// Buscar clientes do banco de dados
$stmt = $pdo->query("SELECT * FROM clientes ORDER BY nome ASC");
$clientes = $stmt->fetchAll();

$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);
?>

<div class="main-container">
    <h1 class="page-title"> Lista de Clientes</h1>
    
    <?php if ($mensagem): ?>
        <div class="alert alert-sucesso"><?php echo $mensagem; ?></div>
    <?php endif; ?>
    
    <div class="action-bar">
        <a href="cad_clientes.php" class="btn-add"> Adicionar Cliente</a>
    </div>
    
    <?php if (empty($clientes)): ?>
        <div class="no-contacts">Nenhum cliente cadastrado.</div>
    <?php else: ?>
        <table class="contatos-table">
            <thead>
                <tr><th>ID</th><th>Nome</th><th>CPF</th><th>E-mail</th><th>Telefone</th><th>Ações</th></tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?php echo $cliente['id']; ?></td>
                    <td><?php echo htmlspecialchars($cliente['nome']); ?></td>
                    <td><?php echo htmlspecialchars($cliente['cpf']); ?></td>
                    <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                    <td><?php echo htmlspecialchars($cliente['telefone']); ?></td>
                    <td>
                        <a href="delete_clientes.php?id=<?php echo $cliente['id']; ?>" 
                           class="btn-delete" 
                           onclick="return confirm('Excluir este cliente?')"> Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
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
.btn-delete {
    background-color: #f44336;
    color: white;
    padding: 5px 10px;
    text-decoration: none;
    border-radius: 5px;
    font-size: 12px;
}
.alert-sucesso {
    background-color: #d4edda;
    color: #155724;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
}
</style>

<?php include_once "footer.php"; ?>