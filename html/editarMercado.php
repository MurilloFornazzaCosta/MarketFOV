<?php
$conn = new mysqli('10.87.100.6', 'aluno', 'Senai1234', 'marketfov4');

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifica se o cnpj foi passado pela URL
if (!isset($_GET['cnpj'])) {
    die("ID do mercado não especificado.");
}

$cnpj = $_GET['cnpj']; // cnpj do mercado a ser editado

// Prepare uma declaração SQL para obter o produto
$leitor = $conn->prepare('SELECT * FROM mercados WHERE cnpj = ?');

// Check if prepare() was successful
if ($leitor === false) {
    die("Prepare failed: " . $conn->error);
}

// Bind the parameter to the SQL query
$leitor->bind_param('s', $cnpj); // 's' specifies the type 'string'

// Execute the query
$leitor->execute();

// Get the result
$results = $leitor->get_result()->fetch_assoc();
// Verifica se o produto foi encontrado
if (!$results) {
    die("Mercado não encontrado.");
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>

<body>
    <div class="form-container">

        <form action="../php/processaAtualizaMercado.php" method="POST">
            <h1>Cadastro</h1>
            <label for="name" id="textName">Nome do Mercado</label>
            <br>
            <input type="text" id="textareaNome" name="name" value="<?php echo htmlspecialchars($results['nome']); ?>">
            <br>
            <label for="endereco" id="textEndereco">Endereço</label>
            <br>
            <input type="text" id="textareaEndereco" name="endereco"
                value="<?php echo htmlspecialchars($results['endereco']); ?>">
            <br>
            <label for="cnpj" id="textCNPJ">CNPJ</label>
            <br>
            <input type="text" id="textareaCNPJ" maxlength="18" name="cnpj"
                value="<?php echo htmlspecialchars($results['cnpj']); ?>" readonly>
            <br>
            <label for="ie" id="textIE">Inscrição Estadual</label>
            <br>
            <input type="text" id="textareaIE" name="ie" value="<?php echo htmlspecialchars($results['ie']); ?>" readonly>
            <br>
            <label for="ie" id="textIM">Inscrição Municipal</label>
            <br>
            <input type="text" id="textareaIM" name="im" value="<?php echo htmlspecialchars($results['im']); ?>" readonly>
            <br>
            <label for="senha" id="textPassword">Senha</label>
            <br>
            <input type="text" id="textareaSenha" name="senha"
                value="<?php echo htmlspecialchars($results['senha']); ?>">
            <br>
            <!-- <label for="confirmPassword" id="textPassword">Confirmar Senha</label>
            <br> -->
            <!-- <input type="password" id="textareaSenha" name="confirmSenha">
            <br>
            <input type="file" id="logo"> -->
            <button id="bt">Salvar</button>
        </form>
    </div>
</body>

</html>