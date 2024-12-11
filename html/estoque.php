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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque</title>
    <link rel="stylesheet" href="../css/estoque.css">
    <link rel="stylesheet" href="../css/msg.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="/js/fazercompras.js"></script>
</head>

<body>
    <div class="navbar">

        <div class="message-container" id="messageContainer">
            <?php
            if (isset($_GET['message'])) {
                echo htmlspecialchars($_GET['message']);
            }
            ?>
        </div>

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
                    <input id="inputSenhaModal" class="input" type="password" placeholder="senha" name="senha" required>
                </div>

                <?php if (isset($message)): ?>

                    <h1 id="errorMessage" style="color: red; display: block; font-size:12px;"><?php echo $message ?></h1>
                <?php endif; ?>
                <button type="submit" id="btnCloseModal">Editar dados</button>
            </form>
        </dialog>

        <div class="buttons">
            <a href="../html/cadastrarProdutos.php"><button class="button" id="button">Registrar Produto</button></a>
            <button class="button" id="buttonRelatorio">Relatório de vendas</button>

            <dialog id="authDialogRelatorio">
                <form method="POST" action="/MarketFOV/php/verificarSenhaParaRelatorio.php">
                    Digite a senha do comércio:
                    <div class="group">
                        <svg stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" class="icon">
                            <path
                                d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"
                                stroke-linejoin="round" stroke-linecap="round"></path>
                        </svg>
                        <input id="inputSenhaModal" class="input" type="password" placeholder="senha" name="senha"
                            required>
                    </div>

                    <?php if (isset($message)): ?>

                        <h1 id="errorMessage" style="color: red; display: block; font-size:12px;"><?php echo $message ?>
                        </h1>
                    <?php endif; ?>
                    <button type="submit" id="btnCloseModal">Editar dados</button>
                </form>
            </dialog>

            <a href="../html/estoque.php"><button class="button" id="button">Estoque</button></a>
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

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#example_select').select2(); // Corrigido o id do select
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>

</body>

</html>