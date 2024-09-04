<?php
$servername = "ESN509VMYSQL";
$username = "aluno";
$password = "Senai1234";
$dbname = "MarketFOV";
$senhateste = 'a';
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

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
    }
}

$leitor->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cnpj = htmlspecialchars(trim($_POST['cnpj']));
    $senha = htmlspecialchars(trim($_POST['senha']));

    $authenticated = false;
    foreach ($mercados as $m) {
        if ($m['cnpj'] === $cnpj && $senha === $senhateste) { // Replace with appropriate password validation
            $authenticated = true;
            break;
        }
    }

    if ($authenticated) {
        header('Location: /MarketFOV-Sprint_V1.6.2/html/fazerCompras.html');
        exit();
    } else {
        $message = 'CNPJ ou Senha Inválidos, tente novamente!';
        header("Location: /MarketFOV-Sprint_V1.6.2/html/login.php?message=" . urlencode($message));
        exit();
    }
}

// Close connection
$conn->close();
?>
