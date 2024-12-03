<?php
$conn = new mysqli('ESN509VMYSQL', 'aluno', 'Senai1234', 'marketfov4');

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifica se o ID foi passado pela URL
if (!isset($_GET['id'])) {
    die("ID do produto não especificado.");
}

$id = $_GET['id']; // ID do produto a ser editado

// Prepare uma declaração SQL para obter o produto
$leitor = $conn->prepare('SELECT * FROM produtos WHERE id = ?');

// Check if prepare() was successful
if ($leitor === false) {
    die("Prepare failed: " . $conn->error);
}

// Bind the parameter to the SQL query
$leitor->bind_param('s', $id); // 's' specifies the type 'string'

// Execute the query
$leitor->execute();

// Get the result
$results = $leitor->get_result()->fetch_assoc();

// Verifica se o produto foi encontrado
if (!$results) {
    die("Produto não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="../css/cadastrarProdutos.css">
</head>

<body>
    <div class="detalhesProduto">
        <h1>Editar Produto</h1>
        <form id="meuFormulario" action="../php/editarProdutos.php?id=<?php echo htmlspecialchars($id); ?>"
            method="POST">
            <label for="codigodebarra" id="textcdb">Código de Barras</label>
            <br>
            <input type="text" id="codigodebarra" name="codigodebarra"
                value="<?php echo htmlspecialchars($results['barCode']); ?>">
            <span class="error" id="errorCDB"></span>
            <br><br>

            <label for="nome" id="textName">Nome do Produto</label>
            <br>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($results['nome']); ?>">
            <span class="error" id="errorNome"></span>
            <br><br>

            <label for="preco" id="textPreco">Preço</label>
            <br>
            <input type="text" id="preco" name="preco" value="<?php echo htmlspecialchars($results['preco']); ?>">
            <span class="error" id="errorPreco"></span>
            <br><br>

            <label for="quantd" id="textQuantd">Quantidade</label>
            <br>
            <input type="text" id="quantd" name="quantd" value="<?php echo htmlspecialchars($results['qtd']); ?>">
            <span class="error" id="errorQuantd"></span>
            <br><br>

            <label for="tipo" id="textTipo">Tipo de Produto</label>
            <br>
            <select name="tipo" id="tipo">
                <option value="">Selecione um tipo</option>
                <option value="limpeza" <?php if (strcasecmp($results['tipo'], 'limpeza') == 0)
                    echo 'selected'; ?>>
                    Produto de Limpeza</option>
                <option value="higiene" <?php if (strcasecmp($results['tipo'], 'higiene') == 0)
                    echo 'selected'; ?>>
                    Higiene Pessoal</option>
                <option value="alimentos" <?php if (strcasecmp($results['tipo'], 'alimentos') == 0)
                    echo 'selected'; ?>>
                    Alimentos</option>
                <option value="variados" <?php if (strcasecmp($results['tipo'], 'variados') == 0)
                    echo 'selected'; ?>>
                    Variados</option>
            </select>
            <span class="error" id="errorTipo"></span>
            <br><br>

            <input type="submit" class="registrar" value="Cadastrar">
        </form>
    </div>

</body>

</html>