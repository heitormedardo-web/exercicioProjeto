<?php
session_start();
require_once "config.php";

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['mensagem'] = 'Produto excluído com sucesso!';
}

header('Location: produtos.php');
exit;
?>