<?php
$conn = new mysqli('ESN509VMYSQL', 'aluno', 'Senai1234', 'marketfov4');

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifica se o método de requisição é POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém os dados do formulário
    $id = $_GET['id']; // ID do produto a ser editado
    $codigodebarra = $_POST['codigodebarra'];
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $quantd = $_POST['quantd'];
    $tipo = $_POST['tipo'];

    // Prepara uma declaração SQL para atualizar o produto
    $stmt = $conn->prepare("UPDATE produtos SET barCode = ?, nome = ?, preco = ?, qtd = ?, tipo = ? WHERE id = ?");
    
    // Verifica se a preparação da declaração foi bem-sucedida
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind dos parâmetros
    $stmt->bind_param('ssdisi', $codigodebarra, $nome, $preco, $quantd, $tipo, $id);

    // Executa a declaração
    if ($stmt->execute()) {
        $message = 'Produto alterado com sucesso!';
        header("Location: /MarketFOV/html/estoque.php?message=" . urlencode($message) . "&success=true");
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    // Fecha a declaração
    $stmt->close();
}

// Fecha a conexão
$conn->close();
?>
