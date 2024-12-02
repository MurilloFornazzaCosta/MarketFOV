<?php
session_start(); // Inicia a sessão para acessar os dados

// Verifica se o usuário está autenticado
if (!isset($_SESSION['mercadoLogado'])) {
    header('Location: /MarketFOV/html/login.php');
    exit();
}

$senhaInserida = trim($_POST['senha']);
$senhaSessao = $_SESSION['mercadoLogado']['senha'];
$cnpj = $_SESSION['mercadoLogado']['cnpj'];

if ($senhaInserida === $senhaSessao) {
    // Redireciona para a página de edição de dados
    header('Location: /MarketFOV/html/editarMercado.php?cnpj=' . urlencode($cnpj));
    exit();
} else {
    // Redireciona de volta para a página anterior com mensagem de erro
    $message = "Senha incorreta. Tente novamente.";
    header("Location: /MarketFOV/html/fazerCompras.php?message=" . urlencode($message));
    exit();

}
