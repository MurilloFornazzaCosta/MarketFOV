<?php

session_start();

if (!isset($_SESSION['mercadoLogado'])) {
    $message = 'FAÇA LOGIN PARA ACESSAR ESSA PÁGINA!';
    header("Location: /MarketFOV/html/login.php?message=" . urlencode($message));
    exit();
} else {
    $mercadoLogado = $_SESSION['mercadoLogado'];
}

// Verificar se o produto foi enviado via URL
if (isset($_GET['name']) && isset($_GET['price']) && isset($_GET['barCode'])) {
    $produtoNome = htmlspecialchars($_GET['name']);
    $produtoPreco = htmlspecialchars($_GET['price']);
    $produtoBarCode = htmlspecialchars($_GET['barCode']);
    // Verificar se o produto existe antes de adicionar à sessão
    if (!empty($produtoNome) && is_numeric($produtoPreco) && !empty($produtoNome) ) {
        // Se o produto já está na sessão, incrementar a quantidade
        if (isset($_SESSION['produtos'][$produtoNome])) {
            $_SESSION['produtos'][$produtoNome]['quantidade']++;
        } else {
            // Caso o produto não exista, adicioná-lo à sessão
            $_SESSION['produtos'][$produtoNome] = [
                'preco' => $produtoPreco,
                'quantidade' => 1,
                'barCode' => $produtoBarCode
            ];
        }
    }
   foreach ($_SESSION['produtos'] as $produto) {
        $produtos[] = $produto;
   }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fazer Compras</title>
    <link rel="stylesheet" href="../css/fazerCompras.css">
    <script src="../js/fazercompras.js"></script>
</head>

<body>
    <div class="navbar">
        <div class="image-container">
            <img src="../imgs/macedopng.png" alt="placeholder" id="logo">
            <div class="comment-box" id="comment-box">
                <a
                    href="../html/editarMercado.php?cnpj=<?php echo urlencode($mercadoLogado['cnpj']); ?>">Alterar<br>Dados</a>
            </div>
        </div>
        <div class="buttons">
            <a href="../html/cadastrarProdutos.php"><button id="button">Registrar Produto</button></a>
            <a href=""><button id="button">Aplicar Desconto</button></a>
            <a href="../html/relatorio.html"><button id="button">Relatório de vendas</button></a>
            <a href="../html/estoque.php"><button id="button">Estoque</button></a>
            <a href="../html/fazerCompras.php"><button id="btfecharcaixa">Realizar Compra</button></a>
        </div>
    </div>
    <main>
        <div class="detalhesProduto">
            <form action="../php/BuscaProduto.php" method="post" id="barCodeInput">
                <input type="text" name="barCode" id="barCode">
                <input type="submit">
            </form>
            <?php if (isset($_GET['name']) && isset($_GET['price'])): ?>
            <h2 id="nomeProduto">
                <?php echo htmlspecialchars($_GET['name']); ?>
            </h2>
            <p id="preco">R$
                <?php echo htmlspecialchars($_GET['price']); ?>
            </p>
            <p id="preco">
                <?php echo htmlspecialchars($_GET['barCode']); ?>
            </p>
            <?php else: ?>
            <p>Produto não encontrado.</p>
            <?php endif; ?>
            <form action="../php/InsereVenda.php" method="POST">
                <button id="finalizar">Finalizar Compra</button>
            </form>
        </div>
    </main>
    <div class="tabelaProdutos">
        <table>
            <thead>
                <tr>
                    <th scope="col">Produto</th>
                    <th scope="col">Quantd</th>
                    <th scope="col">Preço</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Exibir todos os produtos armazenados na sessão
                if (isset($_SESSION['produtos']) && !empty($_SESSION['produtos'])) {
                    foreach ($_SESSION['produtos'] as $nome => $produto) {
                        echo "<tr>";
                        echo "<th scope='row'>$nome</th>";
                        echo "<td>{$produto['quantidade']}</td>";
                        echo "<td>R$ {$produto['preco']}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Nenhum produto na sessão.</td></tr>";
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th scope="row" colspan="2">Total</th>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
