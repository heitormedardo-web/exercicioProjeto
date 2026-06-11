<?php
/**
 * @param PDO 
 * @return array 
 */
function obterContatos(PDO $pdo): array {
    
    $stmt = $pdo->query('SELECT * FROM contatos ORDER BY nome ASC');
    
    return $stmt->fetchAll();
}

/**
 
 * @param PDO 
 * @param string 
 * @param string 
 * @param string 
 * @return bool 
 */
function adicionarContato(PDO $pdo, string $nome, string $email, string $telefone): bool {
    try {
        $sql = "INSERT INTO contatos (nome, email, telefone) VALUES (:nome, :email, :telefone)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':nome' => htmlspecialchars($nome),
            ':email' => htmlspecialchars($email),
            ':telefone' => htmlspecialchars($telefone)
        ]);
    } catch (PDOException $e) {
        
        if ($e->errorInfo[1] == 1062) {
            return false;
        }
        throw $e;
    }
}

/**
 *  
 * @param PDO
 * @param int 
 * @return bool 
 */
function excluirContato(PDO $pdo, int $id): bool {
    $sql = "DELETE FROM contatos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([':id' => $id]);
}

/**
 
 * @param PDO 
 * @param int 
 * @return array|null 
 */
function buscarContatoPorId(PDO $pdo, int $id): ?array {
    $sql = "SELECT * FROM contatos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    
    
    $resultado = $stmt->fetch();
    return $resultado ?: null;
}

/**
 *
 *@param array 
 */
function exibirTabelaContatos(array $contatos): void {
    if (empty($contatos)) {
        echo '<div class="no-contacts"> Nenhum contato encontrado.</div>';
        return;
    }

    echo '<table class="contatos-table">';
    echo '  <thead>';
    echo '    <tr><th>#</th><th> Nome</th><th> E-mail</th><th> Telefone</th><th> Ações</th></tr>';
    echo '  </thead>';
    echo '  <tbody>';

    foreach ($contatos as $indice => $contato) {
        $num   = $indice + 1;
        $id    = $contato['id'];
        $nome  = htmlspecialchars($contato['nome']);
        $email = htmlspecialchars($contato['email']);
        $fone  = htmlspecialchars($contato['telefone']);

        echo "    <tr>";
        echo "      <td>{$num}</td>";
        echo "      <td>{$nome}</td>";
        echo "      <td>{$email}</td>";
        echo "      <td>{$fone}</td>";
        echo "      <td>";
        echo "          <div class='action-buttons'>";
        echo "              <a href='delete.php?id={$id}' ";
        echo "                 class='btn-delete' ";
        echo "                 onclick='return confirm(\"Tem certeza que deseja excluir {$nome}?\");'>";
        echo "                    Excluir";
        echo "              </a>";
        echo "          </div>";
        echo "        </td>";
        echo "     </tr>";
    }

    echo '  </tbody>';
    echo '</table>';
}
?>