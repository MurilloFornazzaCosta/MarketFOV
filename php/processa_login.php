<?php
session_start();
$servername = "10.87.100.6";
$username = "aluno";
$password = "Senai1234";
$dbname = "marketfov4";

// $servername = "localhost";
// $username = "root";
// $password = "102938";
// $dbname = "marketfov4";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all mercados
$sql = 'SELECT * FROM mercados';
$leitor = $conn->prepare($sql);

if (!$leitor) {
    die("Prepare failed: " . $conn->error);
}

$leitor->execute();
$results = $leitor->get_result();

$mercados = [];
if ($results->num_rows > 0) {
    while ($row = $results->fetch_assoc()) {
        $mercados[] = $row;
        var_dump($row);
    }
}

$leitor->close();



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cnpj = htmlspecialchars(trim($_POST['cnpj']));
    $senha = htmlspecialchars(trim($_POST['senha']));

    $authenticated = false;
    foreach ($mercados as $m) {
        if ($m['cnpj'] === $cnpj && $senha === $m['senha']) {
            $authenticated = true;
            $_SESSION['mercadoLogado'] = $m;
            break;
        }
    }

    if ($authenticated) {
        header('Location: /MarketFOV/html/fazerCompras.php');
        exit();
    } else {
        $message = 'CNPJ ou Senha Inválidos, tente novamente!';
        header("Location: /MarketFOV/html/login.php?message=" . urlencode($message));
        exit();
    }
}

// Close connection
$conn->close();
