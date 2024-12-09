<?php
session_start();
$conn = new mysqli('ESN509VMYSQL', 'aluno', 'Senai1234', 'marketfov4');
// Assuming you already have your $conn (MySQLi connection) set up

// Prepare the SQL statement
$query = $conn->prepare('SELECT * FROM produtos WHERE barCode = ?');

// Get the barcode from the POST request
$barCode = $_POST['barCode'];

// Bind the parameter to the prepared statement (assuming the barcode is a string)
$query->bind_param('s', $barCode);

// Execute the query
$query->execute();

// Get the result set
$result = $query->get_result();

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Fetch the row
    
    $row = $result->fetch_assoc();
    if ($row['cnpj'] == $_SESSION['mercadoLogado']['cnpj']) {
        $name = $row['nome'];
    $price = $row['preco'];
    $barCode = $row['barCode'];
    // Redirect to the previous page with the name and price as query parameters
    header("Location: /MarketFOV/html/fazerCompras.php" . "?name=" . urlencode($name) . "&price=" . urlencode($price) . "&barCode=" . urlencode($barCode));
    exit(); // Make sure to exit after the redirect
    } else{
        header("Location: /MarketFOV/html/fazerCompras.php" . "?name=Produto Não Encontrado" );
    }
} else {
    header("Location: /MarketFOV/html/fazerCompras.php");
}

// Close the prepared statement
$query->close();
?>
