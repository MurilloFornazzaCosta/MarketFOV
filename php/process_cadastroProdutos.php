<?php
session_start();
$message;

// Create connection with error handling
//$conn = new mysqli('ESN509VMYSQL', 'aluno', 'Senai1234', 'marketfov4');
$conn = new mysqli('localhost', 'root', '102938', 'marketfov5');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['mercadoLogado'])) {
    $mercadoLogado = $_SESSION['mercadoLogado'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extract posted data
    $codigoBarras = htmlspecialchars(trim($_POST['codigodebarra']));
    $nomeProduto = htmlspecialchars(trim($_POST['nome']));
    $preco = htmlspecialchars(trim($_POST['preco']));
    $quantd = htmlspecialchars(trim($_POST['quantd']));
    $tipoProduto = htmlspecialchars(trim($_POST['tipo']));

    // Create SQL statement
    $query = $conn->prepare('INSERT INTO produtos (barCode, tipo, nome, preco, qtd, im, cnpj, ie) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    if ($query === false) {
        die('Prepare failed: ' . $conn->error);
    }

    // Bind parameters (assuming all are strings, adjust types as necessary)
    $query->bind_param('ssssssss', $codigoBarras, $tipoProduto, $nomeProduto, $preco, $quantd, $mercadoLogado['im'], $mercadoLogado['cnpj'], $mercadoLogado['ie']);

    // Execute query
    if ($query->execute()) {
        $message = 'Produto registrado com sucesso!';
    } else {
        $message = 'Erro ao registrar produto: ' . $query->error;
    }

    $query->close();
    $conn->close();

    // Redirect with message
    header("Location: /MarketFOV/html/cadastrarProdutos.php?message=" . urlencode($message));
    exit();
}
?>
