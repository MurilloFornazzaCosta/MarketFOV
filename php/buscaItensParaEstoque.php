<?php
session_start();
$produtos = [];
if (isset($_SESSION['mercadoLogado'])) {
    $mercadoLogado = $_SESSION['mercadoLogado'];
}

// Create a new MySQLi connection
//$conn = new mysqli('ESN509VMYSQL', 'aluno', 'Senai1234', 'marketfov4');
$conn = new mysqli('localhost', 'root', '102938', 'marketfov5');

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare an SQL statement with a placeholder
$leitor = $conn->prepare('SELECT * FROM produtos WHERE cnpj = ?');

// Check if prepare() was successful
if ($leitor === false) {
    die("Prepare failed: " . $conn->error);
}

// Bind the parameter to the SQL query
$leitor->bind_param('s', $mercadoLogado['cnpj']); // 's' specifies the type 'string'

// Execute the query
$leitor->execute();

// Get the result
$results = $leitor->get_result();

// Fetch data if available
if ($results->num_rows > 0) {
    while ($row = $results->fetch_assoc()) {
        $produtos[] = $row;
    }
}

// Close statement and connection
$leitor->close();
$conn->close();

// Debugging output
// echo "Redirecting to: estoque.php?produtos=" . $produtos_serialized;
// exit();

// Redirect with serialized data
?>
