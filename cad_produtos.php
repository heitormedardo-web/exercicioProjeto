<?php
session_start();
require_once "config.php";
include_once "cabecalho.php";
include_once "navbar.php";

$mensagem = '';
$tipo_mensagem = '';

// Função para criar a pasta uploads se não existir
function garantirPastaUploads() {
    $pasta = 'uploads/';
    if (!is_dir($pasta)) {
        // Tenta criar a pasta com permissão 0777 (leitura/escrita para todos)
        if (mkdir($pasta, 0777, true)) {
            return true;
        } else {
            return false;
        }
    }
    return true;
}

function formatarPrecoBanco($preco) {
    $preco = str_replace('R$', '', $preco);
    $preco = str_replace('.', '', $preco);
    $preco = str_replace(',', '.', $preco);
    return floatval($preco);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = formatarPrecoBanco($_POST['preco'] ?? '0');
    $estoque = (int)($_POST['estoque'] ?? 0);
    $nomeImagem = '';
    
    $erros = [];
    
    if (empty($nome)) {
        $erros[] = 'Nome do produto é obrigatório!';
    }
    
    if ($preco <= 0) {
        $erros[] = 'Preço deve ser um valor positivo!';
    }
    
    if ($estoque < 0) {
        $erros[] = 'Estoque não pode ser negativo!';
    }
    
    // Upload da imagem
    if (!empty($_FILES['imagem']['name'])) {
        // Verificar e criar a pasta uploads automaticamente
        if (!garantirPastaUploads()) {
            $erros[] = 'Não foi possível criar a pasta de uploads!';
        } else {
            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $permitidos = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            
            if (!in_array(strtolower($extensao), $permitidos)) {
                $erros[] = 'Tipo de imagem não permitido. Use: JPG, PNG, WEBP ou GIF';
            } else {
                $nomeImagem = uniqid('prod_') . '.' . $extensao;
                $caminhoImagem = 'uploads/' . $nomeImagem;
                
                if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem)) {
                    $erros[] = 'Erro ao fazer upload da imagem!';
                }
            }
        }
    }
    
    if (empty($erros)) {
        try {
            if ($nomeImagem) {
                $stmt = $pdo->prepare("INSERT INTO produtos (nome, descricao, preco, estoque, imagem) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$nome, $descricao, $preco, $estoque, $nomeImagem]);
            } else {
                $stmt = $pdo->prepare("INSERT INTO produtos (nome, descricao, preco, estoque) VALUES (?, ?, ?, ?)");
                $stmt->execute([$nome, $descricao, $preco, $estoque]);
            }
            
            $_SESSION['mensagem'] = 'Produto cadastrado com sucesso!';
            $_SESSION['tipo_mensagem'] = 'sucesso';
            header('Location: produtos.php');
            exit;
        } catch (PDOException $e) {
            $mensagem = 'Erro ao cadastrar: ' . $e->getMessage();
            $tipo_mensagem = 'erro';
        }
    } else {
        $mensagem = implode('<br>', $erros);
        $tipo_mensagem = 'erro';
    }
}
?>

<div class="main-container">
    <div class="form-container">
        <h1 class="page-title">Adicionar Produto com Imagem</h1>
        
        <?php if ($mensagem): ?>
            <div class="alert alert-<?php echo $tipo_mensagem; ?>">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nome do Produto: *</label>
                <input type="text" name="nome" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label>Descrição:</label>
                <textarea name="descricao" class="form-input" rows="3"></textarea>
            </div>
            
            <div class="form-row" style="display: flex; gap: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label>Preço: *</label>
                    <input type="text" name="preco" class="form-input" placeholder="99,90" required>
                </div>
                
                <div class="form-group" style="flex: 1;">
                    <label>Estoque:</label>
                    <input type="number" name="estoque" class="form-input" value="0" min="0">
                </div>
            </div>
            
            <div class="form-group">
                <label>Imagem do Produto:</label>
                <input type="file" name="imagem" class="form-input" accept="image/jpeg,image/png,image/webp,image/gif">
                <small>Formatos: JPG, PNG, WEBP, GIF (a pasta uploads será criada automaticamente)</small>
            </div>
            
            <div class="form-buttons">
                <button type="submit" class="btn btn-success">Salvar Produto</button>
                <a href="produtos.php" class="btn btn-cancel">Cancelar</a>
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
}
.form-input:focus {
    outline: none;
    border-color: #4CAF50;
}
.dark-mode .form-input {
    background-color: #1a1a1a;
    color: white;
    border-color: #444;
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
.alert-sucesso {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}
.alert-erro {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
.dark-mode .alert-sucesso {
    background-color: #155724;
    color: #d4edda;
}
.dark-mode .alert-erro {
    background-color: #721c24;
    color: #f8d7da;
}
small {
    display: block;
    font-size: 12px;
    color: #666;
    margin-top: 5px;
}
.dark-mode small {
    color: #aaa;
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