<?php
session_start();
require_once "config.php";
include_once "cabecalho.php";
include_once "navbar.php";

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $cpf = trim($_POST['cpf'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');
    
    if (empty($nome) || empty($cpf) || empty($email)) {
        $mensagem = 'Nome, CPF e E-mail são obrigatórios!';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO clientes (nome, cpf, email, telefone, endereco) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nome, $cpf, $email, $telefone, $endereco]);
            $_SESSION['mensagem'] = 'Cliente cadastrado com sucesso!';
            header('Location: clientes.php');
            exit;
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                $mensagem = 'Este CPF já está cadastrado!';
            } else {
                $mensagem = 'Erro ao cadastrar: ' . $e->getMessage();
            }
        }
    }
}
?>

<div class="main-container">
    <div class="form-container">
        <h1 class="page-title"> Adicionar Cliente</h1>
        
        <?php if ($mensagem): ?>
            <div class="alert alert-erro"><?php echo $mensagem; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Nome Completo: *</label>
                <input type="text" name="nome" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label>CPF: *</label>
                <input type="text" name="cpf" class="form-input" placeholder="123.456.789-00" required>
            </div>
            
            <div class="form-group">
                <label>E-mail: *</label>
                <input type="email" name="email" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label>Telefone:</label>
                <input type="text" name="telefone" class="form-input" placeholder="(99) 99999-9999">
            </div>
            
            <div class="form-group">
                <label>Endereço:</label>
                <textarea name="endereco" class="form-input" rows="3"></textarea>
            </div>
            
            <div class="form-buttons">
                <button type="submit" class="btn btn-success"> Salvar</button>
                <a href="clientes.php" class="btn btn-cancel">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<style>
    .form-container {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .dark-mode .form-container {
        background: #2d2d2d;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
    }
    
    .dark-mode .form-group label {
        color: #f5f5f5;
    }
    
    .form-input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
        transition: border-color 0.3s;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #4CAF50;
        box-shadow: 0 0 5px rgba(76,175,80,0.3);
    }
    
    .dark-mode .form-input {
        background-color: #1a1a1a;
        color: white;
        border-color: #444;
    }
    
    .form-text {
        display: block;
        font-size: 12px;
        color: #666;
        margin-top: 5px;
    }
    
    .dark-mode .form-text {
        color: #aaa;
    }
    
    .form-buttons {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }
    
    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        transition: all 0.3s;
        flex: 1;
    }
    
    .btn-success {
        background-color: #4CAF50;
        color: white;
    }
    
    .btn-success:hover {
        background-color: #45a049;
        transform: translateY(-2px);
    }
    
    .btn-cancel {
        background-color: #f44336;
        color: white;
    }
    
    .btn-cancel:hover {
        background-color: #da190b;
        transform: translateY(-2px);
    }
    
    .alert {
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        animation: fadeIn 0.5s;
    }
    
    .alert-erro {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .dark-mode .alert-erro {
        background-color: #721c24;
        color: #f8d7da;
    }
    
    .info-box {
        margin-top: 20px;
        padding: 15px;
        background-color: #e7f3ff;
        border-left: 4px solid #2196F3;
        border-radius: 5px;
        font-size: 14px;
    }
    
    .dark-mode .info-box {
        background-color: #1a3a5c;
        color: #ddd;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<?php include_once "footer.php"; ?>