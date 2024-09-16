<?php
require_once('../php/buscaItensParaEstoque.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['mercadoLogado'])) {
    $message = 'FAÇA LOGIN PARA ACESSAR ESSA PÁGINA!';
    header("Location: /MarketFOV/html/login.php?message=" . urlencode($message));
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque</title>
    <link rel="stylesheet" href="../css/estoque.css">
    <script src="/js/fazercompras.js"></script>
</head>

<body>
    <div class="navbar">
        <div class="image-container">
            <img src="../imgs/macedopng.png" alt="placeholder" id="logo">
            <div class="comment-box" id="comment-box">
                Alterar<br>foto
            </div>
        </div>
        <div class="buttons">
            <a href="../html/cadastrarProdutos.php"><button id="button">Registrar Produto</button></a>
            <a href="../html/relatorio.html"><button id="button">Relatório de vendas</button></a>
            <a href="../html/estoque.html"><button id="button">Estoque</button></a>
            <a href="../html/fazerCompras.html"><button id="btfecharcaixa">Realizar Compra</button></a>
        </div>
    </div>
    <main>
        <div class="detalhesProduto">
            <h1>Estoque</h1>
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
                        foreach ($produtos as $produto) {
                            echo "<tr>";
                            echo "<th scope='row'>" . htmlspecialchars($produto['nome']) . "</th>";
                            echo "<td>" . htmlspecialchars($produto['qtd']) . "</td>";
                            echo "<td>R$" . number_format($produto['preco'], 2, ',', '.') . "</td>";
                            echo "</tr>";
                        }
                        ?>

                       
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>

</html>