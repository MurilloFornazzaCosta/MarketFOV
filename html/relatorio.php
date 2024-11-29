<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está autenticado
if (!isset($_SESSION['mercadoLogado'])) {
    $message = 'FAÇA LOGIN PARA ACESSAR ESSA PÁGINA!';
    header("Location: /MarketFOV/html/login.php?message=" . urlencode($message));
    exit();
} else {
    // Armazena os dados do mercado logado
    $mercadoLogado = $_SESSION['mercadoLogado'];
}
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
// Verifica se há mensagem de erro de senha
$erroSenha = isset($_SESSION['erroSenha']) ? $_SESSION['erroSenha'] : null;

// Limpa a mensagem de erro após exibi-la
unset($_SESSION['erroSenha']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório das vendas</title>
    <link rel="stylesheet" href="../css/relatorio.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    <div class="navbar">
        <div class="image-container">
            <button id="btnImg">
                <img src="../imgs/retomar.png" alt="placeholder" id="logo">
            </button>
        </div>

        <!-- Dialog para inserir a senha -->
        <dialog id="authDialog">
            <form method="POST" action="/MarketFOV/php/verificarSenha.php">
                Digite a senha do comércio:
                <div class="group">
                    <svg stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="icon">
                        <path d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" stroke-linejoin="round" stroke-linecap="round"></path>
                    </svg>
                    <input id="inputSenhaModal" class="input" type="password" placeholder="senha" name="senha" required>
                </div>
                <?php  ?>
                <?php if (isset($message)): ?>
                    <?php  ?>
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
        <div class="detalhesProduto" id="detalhesProduto">
            <div id="pesquisa">
                <label for="example_select">Pesquisar por:</label>
                <select id="example_select" style="width: 200px;">
                    <option value="mes">Mês</option>
                    <option value="semana">Semana</option>
                    <option value="dia">Dia</option>
                </select>
            </div>

            <div class="container">
                <div class="chart">
                    <canvas id="barchart"></canvas>
                </div>
            </div>

            <h3 id="titleTabela">Tabela de vendas</h3>

            <div style="max-height: 300px; overflow-y: auto; margin-bottom: 50px;">
                <table id="tabelaVendas" class="table">
                    <thead>
                        <tr>
                            <th scope="col">Cupom</th>
                            <th scope="col">Data</th>
                            <th scope="col">CPF do cliente</th>
                            <th scope="col">IM</th>
                            <th scope="col">CNPJ</th>
                            <th scope="col">IE</th>
                            <th scope="col">Total da venda</th>
                        </tr>
                    </thead>
                    <tbody id="tabela-vendas-body">
                        <!-- Linhas serão adicionadas dinamicamente aqui -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div class="tabelaProdutos">
        <button class="filtro1" id="filtro1" onclick="showChart2()">
            <img class="iconProdutosVendidos" src="../imgs/mao.png" alt="">
            <h3 class="txtProdutosVendidos">Produtos mais vendidos</h3>
        </button>

        <button class="filtro2" id="filtro2" onclick="showVendas()">
            <img class="iconProdutosVendidos" src="../imgs/comissao.png" alt="">
            <h3 class="txtProdutosVendidos">Todas as vendas</h3>
        </button>
    </div>

    <script>
        const btnImg = document.getElementById("btnImg");
        const btnCloseModal = document.getElementById("btnCloseModal");
        const modal = document.getElementById("authDialog"); // Definição correta do modal
        const errorMessage = document.getElementById('errorMessage');

        // Exibe o modal quando o botão é clicado
        btnImg.onclick = function () {
            modal.showModal();
        };

        // Fecha o modal quando o botão de fechamento é clicado
        btnCloseModal.onclick = function () {
            modal.close();
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

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#example_select').select2(); // Corrigido o id do select
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>
    <script src="../js/mainChart.js"></script>
    <script src="../js/secondChart.js"></script>
    <script src="../js/listaVendas.js"></script>
</body>

</html>
