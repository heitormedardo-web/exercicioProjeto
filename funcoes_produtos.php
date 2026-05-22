<?php
/**
 * funcoes_produtos.php - Funções específicas para produtos
 */

function obterProdutos(PDO $pdo): array {
    $stmt = $pdo->query("SELECT * FROM produtos ORDER BY nome ASC");
    return $stmt->fetchAll();
}

function exibirTabelaProdutos(array $produtos): void {
    if (empty($produtos)) {
        echo '<div class="no-contacts">📦 Nenhum produto cadastrado.</div>';
        return;
    }

    echo '<table class="contatos-table">';
    echo '  <thead>';
    echo '    <tr><th>ID</th><th>Imagem</th><th>Produto</th><th>Descrição</th><th>Preço</th><th>Estoque</th><th>Ações</th></tr>';
    echo '  </thead>';
    echo '  <tbody>';

    foreach ($produtos as $produto) {
        $id = $produto['id'];
        $nome = htmlspecialchars($produto['nome']);
        $descricao = htmlspecialchars(substr($produto['descricao'] ?? '', 0, 50));
        $preco = 'R$ ' . number_format($produto['preco'], 2, ',', '.');
        $estoque = $produto['estoque'];
        
        // Caminho da imagem
        if (!empty($produto['imagem']) && file_exists('uploads/' . $produto['imagem'])) {
            $imagem = 'uploads/' . $produto['imagem'];
        } else {
            $imagem = 'uploads/default.png';
        }

        echo "    <tr>";
        echo "        <td>{$id}</td>";
        echo "        <td><img src='{$imagem}' alt='{$nome}' style='width: 50px; height: 50px; object-fit: cover; border-radius: 5px;'></td>";
        echo "        <td><strong>{$nome}</strong></td>";
        echo "        <td>{$descricao}</td>";
        echo "        <td class='preco'>{$preco}</td>";
        echo "        <td class='estoque'>{$estoque} un.</td>";
        echo "        <td>";
        echo "            <a href='delete_produtos.php?id={$id}' ";
        echo "               class='btn-delete' ";
        echo "               onclick='return confirm(\"Excluir {$nome}?\")'>";
        echo "                Excluir";
        echo "            </a>";
        echo "        </td>";
        echo "      </tr>";
    }

    echo '  </tbody>';
    echo '</table>';
}
?>