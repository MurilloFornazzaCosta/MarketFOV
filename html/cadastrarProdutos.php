<?php
session_start();
if (!isset($_SESSION['mercadoLogado'])) {
    $message = 'FAÇA LOGIN PARA ACESSAR ESSA PÁGINA!';
    header("Location: /MarketFOV/html/login.php?message=" . urlencode($message));
    exit();
} else {
    $mercadoLogado = $_SESSION['mercadoLogado'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produtos</title>
    <link rel="stylesheet" href="../css/navbar.css">
    <script src="../js/fazercompras.js"></script>
    <style>
        /* Adicione estilos básicos para as imagens */
        #produtoRegistrado,
        #erroAoRegistrar {
            display: none;
            /* Inicialmente, as imagens estão ocultas */
        }
    </style>
    <link rel="stylesheet" href="../css/cadastrarProdutos.css">

</head>

<body>

    <div class="navbar">
        <div class="image-container">
            <img src="../imgs/macedopng.png" alt="placeholder" id="logo">
            <div class="comment-box" id="comment-box">
                <a href="../html/editarMercado.php?cnpj=<?php echo urlencode($mercadoLogado['cnpj']); ?>">Alterar<br>Dados</a>
            </div>
        </div>
        <div class="buttons">
            <a href="../html/cadastrarProdutos.php"><button id="button">Registrar Produto</button></a>
            <a href="../html/relatorio.html"><button id="button">Relatório de vendas</button></a>
            <a href="../html/estoque.php"><button id="button">Estoque</button></a>
            <a href="../html/fazerCompras.php"><button id="btfecharcaixa">Realizar Compra</button></a>
        </div>
    </div>
    <main>
        <div class="detalhesProduto">
            <h1>Registrar Produtos</h1>
            <form id="meuFormulario" action="../php/process_cadastroProdutos.php" method="POST">
                <label for="codigodebarra" id="textcdb">Código de Barras</label>
                <br>
                <input type="text" id="codigodebarra" name="codigodebarra">
                <span class="error" id="errorCDB"></span>
                <br><br>

                <label for="nome" id="textName">Nome do Produto</label>
                <br>
                <input type="text" id="nome" name="nome">
                <span class="error" id="errorNome"></span>
                <br><br>

                <label for="preco" id="textPreco">Preço</label>
                <br>
                <input type="text" id="preco" name="preco">
                <span class="error" id="errorPreco"></span>
                <br><br>

                <label for="quantd" id="textQuantd">Quantidade</label>
                <br>
                <input type="text" id="quantd" name="quantd">
                <span class="error" id="errorQuantd"></span>
                <br><br>

                <label for="tipo" id="textTipo">Tipo de Produto</label>
                <br>
                <select name="tipo" id="tipo">
                    <option value="">Selecione um tipo</option>
                    <option value="limpeza">Produto de Limpeza</option>
                    <option value="higiene">Higiene Pessoal</option>
                    <option value="alimentos">Alimentos</option>
                    <option value="variados">Variados</option>
                </select>
                <span class="error" id="errorTipo"></span>
                <br><br>

                <input type="submit" class="registrar" value="Cadastrar">
            </form>
            <img src="../imgs/produtoRegistrado.png" id="produtoRegistrado" alt="Produto Registrado">
            <img src="../imgs/erroAoRegistrar.png" id="erroAoRegistrar" alt="Erro ao Registrar">
        </div>
    </main>
    <div class="tabelaProdutos">
        <table>
            <thead>
                <tr>
                    <th scope="col">Produto</th>
                    <th scope="col">Preço</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">Danoninho</th>
                    <td>R$15,30</td>
                </tr>
                <tr>
                    <th scope="row">Manteiga</th>
                    <td>R$7,30</td>
                </tr>
                <tr>
                    <th scope="row">Nescau</th>
                    <td>R$12,50</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th scope="row" colspan="1">Total</th>
                    <td>R$35,10</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <script src="../js/cadastrarProdutos.js"></script>
    <!-- <script src="../js/validacaocamposCadastroProduto.js"></script> -->
</body>

</html>