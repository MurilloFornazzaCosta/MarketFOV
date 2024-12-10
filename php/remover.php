<?php
// Database connection
    $conn = new mysqli('ESN509VMYSQL', 'aluno', 'Senai1234', 'marketfov4');
    // $conn = new mysqli('localhost', 'root', '102938', 'marketfov5');

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the ID is set and is a valid integer
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $id = $_GET['id'];

    // Prepare the DELETE statement
    $stmt1 = $conn->prepare("DELETE FROM produtosvendidos WHERE id = ?");    
    $stmt2 = $conn->prepare("DELETE FROM produtos WHERE id = ?");
    
    // Check if preparation was successful
    if ($stmt1 === false || $stmt2 === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind the parameters
    $stmt1->bind_param('i', $id);
    $stmt2->bind_param('i', $id);

    // Execute the statement
    if ($stmt1->execute() && $stmt2->execute()) {
        // Check if any rows were affected
        if ($stmt1->affected_rows > 0 || $stmt2->affected_rows > 0) {
            $message = 'Produto Deletado com sucesso!';
            header("Location: /MarketFOV/html/estoque.php?message=" . urlencode($message) . "&success=true");
        }
    }

    // Close the statement
    $stmt1->close();
    $stmt2->close();
} else {
    echo "Invalid ID specified.";
}

// Close the connection
$conn->close();
?>
