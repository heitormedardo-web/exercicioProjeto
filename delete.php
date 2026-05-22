<?php
// delete.php - Excluir contato
session_start();

require_once "config.php";
require_once "funcoes.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int)$_GET['id'];

// Passa $pdo como argumento
$contato = buscarContatoPorId($pdo, $id);

if ($contato) {
    if (excluirContato($pdo, $id)) {
        $_SESSION['mensagem'] = " Contato '{$contato['nome']}' excluído com sucesso!";
        $_SESSION['tipo_mensagem'] = 'sucesso';
    } else {
        $_SESSION['mensagem'] = " Erro ao excluir contato!";
        $_SESSION['tipo_mensagem'] = 'erro';
    }
} else {
    $_SESSION['mensagem'] = " Contato não encontrado!";
    $_SESSION['tipo_mensagem'] = 'erro';
}

header('Location: index.php');
exit;
?>