<?php
session_start();
require_once "config.php";

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM clientes WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['mensagem'] = 'Cliente excluído com sucesso!';
}

header('Location: clientes.php');
exit;
?>