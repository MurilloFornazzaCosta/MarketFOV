<?php
    $conn = new mysqli('10.87.100.6', 'aluno', 'Senai1234', 'marketfov4');
    // $conn = new mysqli('localhost', 'root', '102938', 'marketfov5');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $endereco = $_POST['endereco'];
    $im = $_POST['im'];
    $cnpj = $_POST['cnpj'];
    $ie = $_POST['ie'];
    $nome = $_POST['name'];
    $senha = $_POST['senha'];

    $query = $conn->prepare('UPDATE mercados SET endereco = ?, im = ?, cnpj = ?, ie = ?, nome = ?, senha = ? WHERE cnpj = ?');
    if ($query === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Assuming 'im' is an integer, others are strings
    $query->bind_param('sssssss', $endereco, $im, $cnpj,  $ie, $nome, $senha, $cnpj);
    if ($query->execute()) {
        $message = 'Informações do Mercado Atualizado com Sucesso!';
        header("Location: /MarketFOV/html/estoque.php?message=" . urlencode($message) . "&success=true");
    } else {
        echo 'Error: ' . $query->error;
    }

    $query->close(); // Close the statement
}

$conn->close(); // Close the connection
