<?php
require_once('../php/buscaItensParaEstoque.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
    <title>Estoque</title>
    <link rel="stylesheet" href="../css/estoque.css">
    <link rel="stylesheet" href="../css/msg.css">
    <script src="/js/fazercompras.js"></script>
</head>

<body>
<div class="message-container" id="messageContainer">
        <?php
        if (isset($_GET['message'])) {
            echo htmlspecialchars($_GET['message']);
        }
        ?>
    </div>
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
            <h1>Estoque</h1>
            <div class="tabelaProdutos">

                <table>
                    <thead>
                        <tr>
                            <th scope="col">Produto</th>
                            <th scope="col">Quantd</th>
                            <th scope="col">Preço</th>
                            <th scope="col">Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                       foreach ($produtos as $produto) {
                        echo "<tr>";
                        echo "<th scope='row'>" . htmlspecialchars($produto['nome']) . "</th>";
                        echo "<td>" . htmlspecialchars($produto['qtd']) . "</td>";
                        echo "<td>R$" . number_format($produto['preco'], 2, ',', '.') . "</td>";
                        echo "<td>
                                <a href='editar.php?id=" . htmlspecialchars($produto['id']) . "' class='btn-edit' title='Editar'>✏️ Editar</a>
                                <a href='../php/remover.php?id=" . htmlspecialchars($produto['id']) . "' class='btn-remove' title='Remover' onclick='return confirm(\"Tem certeza que deseja remover este produto?\");'>🗑️ Remover</a>
                              </td>";
                        echo "</tr>";
                    }
                    
                        ?>

                       
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const messageContainer = document.getElementById('messageContainer');
        if (messageContainer.textContent.trim()) {
            if (window.location.search.includes('success=true')) {
                messageContainer.classList.add('success');
            } else {
                messageContainer.classList.add('error');
            }
            messageContainer.style.display = 'block';
            setTimeout(() => {
                messageContainer.style.display = 'none';
            }, 2500);
        }
    });
</script>
</body>

</html>