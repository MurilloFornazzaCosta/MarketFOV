<?php
session_start();
$message;
//cria conexão com banco de dados
$conn = new mysqli('ESN509VMYSQL', 'aluno', 'Senai1234', 'marketfov3');
if (isset($_SESSION['mercadoLogado'])) {
    $mercadoLogado = $_SESSION['mercadoLogado'];
}
//verifica se ocorreu um envio de formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //resgata os valores do formulário enviado
    $codigoBarras = htmlspecialchars(trim($_POST['codigodebarra']));
    $nomeProduto = htmlspecialchars(trim($_POST['nome']));
    $preco = htmlspecialchars(trim($_POST['preco']));
    $quantd = htmlspecialchars(trim($_POST['quantd']));
    $tipoProduto = htmlspecialchars(trim($_POST['tipo']));

    //cria um comando de inserir no banco de dados
    $query = $conn->prepare('INSERT INTO produtos VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $query->bind_param('ssssssss', $quantd, $tipoProduto, $nomeProduto, $preco, $codigoBarras, $mercadoLogado['im'], $mercadoLogado['cnpj'], $mercadoLogado['ie']);
    if ($query->execute()) {
        $message = 'Produto registrado com sucesso!';
    } else {
        $message = 'Erro ao registrar produto: ' . $query->error;
    }

    $query->close();
    $conn->close();

    // Redireciona de volta para o formulário com a mensagem
    header("Location: /MarketFOV/html/cadastrarProdutos.php?message=" . urlencode($message));
    exit();
}
