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

    <div class="message-container" id="messageContainer">
        <?php
        if (isset($_GET['message'])) {
            echo htmlspecialchars($_GET['message']);
        }
        ?>
    </div>


    <div class="navbar">
        <div class="image-container">
            <button id="btnImg">
                <img src="../imgs/retomar.png" alt="placeholder" id="logo">
            </button>
        </div>

        <!-- Dialog para inserir a senha -->
        <dialog id="authDialog">
            <form method="POST" action="/MarketFOV/php/verificarSenhaParaEditar.php">
                Digite a senha do comércio:
                <div class="group">
                    <svg stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                        class="icon">
                        <path
                            d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"
                            stroke-linejoin="round" stroke-linecap="round"></path>
                    </svg>
                    <input id="inputSenhaModal" class="inputModal" type="password" placeholder="senha" name="senha" required>
                </div>

                <?php if (isset($message)): ?>

                    <h1 id="errorMessage" style="color: red; display: block; font-size:12px;"><?php echo $message ?></h1>
                <?php endif; ?>
                <button type="submit" id="btnCloseModal">Editar dados</button>
            </form>
        </dialog>
        <div class="buttons">
            <a href="../html/cadastrarProdutos.php"><button id="button">Registrar Produto</button></a>
            <a href="../html/relatorio.php"><button id="button">Relatório de vendas</button></a>
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

    <script>
        const buttonRelatorio = document.getElementById("buttonRelatorio");
        const btnImg = document.getElementById("btnImg");
        const btnCloseModal = document.getElementById("btnCloseModal");
        const modal = document.getElementById("authDialog"); // Definição correta do modal
        const modalRelatorio = document.getElementById("authDialogRelatorio");
        const errorMessage = document.getElementById('errorMessage');

        // Exibe o modal quando o botão é clicado
        btnImg.onclick = function () {
            modal.showModal();
        };

        buttonRelatorio.onclick = function () {
            modalRelatorio.showModal();
        };

        // Fecha o modal quando o botão de fechamento é clicado
        btnCloseModal.onclick = function () {
            modal.close();
        };

        btnCloseModal.onclick = function () {
            modalRelatorio.close();
        };

        // Exibe a mensagem de erro se houver
        <?php if ($erroSenha): ?>
            // Exibe a mensagem de erro no frontend
            errorMessage.textContent = <?= json_encode($erroSenha) ?>;
            errorMessage.style.display = 'block'; // Torna a mensagem visível
            modal.showModal(); // Exibe o dialog
        <?php endif; ?>

        function fecharDialog() {
            modal.close(); // Fecha o dialog
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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




    <script src="../js/cadastrarProdutos.js"></script>
    <!-- <script src="../js/validacaocamposCadastroProduto.js"></script> -->
</body>

</html>