<?php
session_start();
if (!isset($_SESSION['mercadoLogado'])) {
    $message = 'FAÇA LOGIN PARA ACESSAR ESSA PÁGINA!';
    header("Location: /MarketFOV/html/login.php?message=" . urlencode($message));
    exit();
}  else {
    $mercadoLogado = $_SESSION['mercadoLogado'];
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
            <a href="../html/editarMercado.php?cnpj=<?php echo urlencode($mercadoLogado['cnpj']); ?>">
                <img src="../imgs/retomar.png" alt="placeholder" id="logo">
            </a>
        </div>
        
        <div class="buttons">
            <a href="../html/cadastrarProdutos.php"><button id="button">Registrar Produto</button></a>
            <a href=""><button id="button">Aplicar Desconto</button></a>
            <a href="../html/relatorio.php"><button id="button">Relatório de vendas</button></a>
            <a href="../html/estoque.php"><button id="button">Estoque</button></a>
            <a href="../html/fazerCompras.php"><button id="btfecharcaixa">Realizar Compra</button></a>
        </div>
    </div>
    <main>
        <div class="detalhesProduto">
            <img src="../imgs/placeholderProduto.png" alt="Produto">
            <h2 id="nomeProduto">Nestlé Nescau 2.0 400g</h2>
            <p id="preco">R$12,50</p>
            <button id="finalizar">Finalizar Compra</button>

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
                <tr>
                    <th scope="row">Danoninho</th>
                    <td>1</td>
                    <td>R$15,30</td>
                </tr>
                <tr>
                    <th scope="row">Manteiga</th>
                    <td>1</td>
                    <td>R$7,30</td>
                </tr>
                <tr>
                    <th scope="row">Nescau</th>
                    <td>1</td>
                    <td>R$12,50</td>
                </tr>
                <tr>
                    <th scope="row">Danoninho</th>
                    <td>1</td>
                    <td>R$15,30</td>
                </tr>
                <tr>
                    <th scope="row">Manteiga</th>
                    <td>1</td>
                    <td>R$7,30</td>
                </tr>
                <tr>
                    <th scope="row">Nescau</th>
                    <td>1</td>
                    <td>R$12,50</td>
                </tr>
                <tr>
                    <th scope="row">Danoninho</th>
                    <td>1</td>
                    <td>R$15,30</td>
                </tr>
                <tr>
                    <th scope="row">Manteiga</th>
                    <td>1</td>
                    <td>R$7,30</td>
                </tr>
                <tr>
                    <th scope="row">Nescau</th>
                    <td>1</td>
                    <td>R$12,50</td>
                </tr>
                <tr>
                    <th scope="row">Danoninho</th>
                    <td>1</td>
                    <td>R$15,30</td>
                </tr>
                <tr>
                    <th scope="row">Manteiga</th>
                    <td>1</td>
                    <td>R$7,30</td>
                </tr>
                <tr>
                    <th scope="row">Nescau</th>
                    <td>1</td>
                    <td>R$12,50</td>
                </tr>
                <tr>
                    <th scope="row">Danoninho</th>
                    <td>1</td>
                    <td>R$15,30</td>
                </tr>
                <tr>
                    <th scope="row">Manteiga</th>
                    <td>1</td>
                    <td>R$7,30</td>
                </tr>
                <tr>
                    <th scope="row">Nescau</th>
                    <td>1</td>
                    <td>R$12,50</td>
                </tr>
                <tr>
                    <th scope="row">Danoninho</th>
                    <td>1</td>
                    <td>R$15,30</td>
                </tr>
                <tr>
                    <th scope="row">Manteiga</th>
                    <td>1</td>
                    <td>R$7,30</td>
                </tr>
                <tr>
                    <th scope="row">Nescau</th>
                    <td>1</td>
                    <td>R$12,50</td>
                </tr>
                <tr>
                    <th scope="row">Danoninho</th>
                    <td>1</td>
                    <td>R$15,30</td>
                </tr>
                <tr>
                    <th scope="row">Manteiga</th>
                    <td>1</td>
                    <td>R$7,30</td>
                </tr>
                <tr>
                    <th scope="row">Nescau</th>
                    <td>1</td>
                    <td>R$12,50</td>
                </tr>
                <tr>
                    <th scope="row">Danoninho</th>
                    <td>1</td>
                    <td>R$15,30</td>
                </tr>
                <tr>
                    <th scope="row">Manteiga</th>
                    <td>1</td>
                    <td>R$7,30</td>
                </tr>
                <tr>
                    <th scope="row">Nescau</th>
                    <td>1</td>
                    <td>R$12,50</td>
                </tr>
                <tr>
                    <th scope="row">Danoninho</th>
                    <td>1</td>
                    <td>R$15,30</td>
                </tr>
                <tr>
                    <th scope="row">Manteiga</th>
                    <td>1</td>
                    <td>R$7,30</td>
                </tr>
                <tr>
                    <th scope="row">Nescau</th>
                    <td>1</td>
                    <td>R$12,50</td>
                </tr>
                <tr>
                    <th scope="row">Nutella</th>
                    <td>2</td>
                    <td>R$33,5</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th scope="row" colspan="2">Total</th>
                    <td>R$35,10</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>