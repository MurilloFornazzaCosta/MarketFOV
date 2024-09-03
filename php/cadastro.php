<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="/css/cadastro.css">
    <style>
        .message-container {
            position: fixed;
            top: 10px;
            right: 10px;
            width: 300px;
            padding: 10px;
            border-radius: 5px;
            display: none;
            z-index: 1000;
        }

        .message-container.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .message-container.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>

<body>
    <div class="message-container" id="messageContainer">
        <?php
        if (isset($_GET['message'])) {
            echo htmlspecialchars($_GET['message']);
        }
        ?>
    </div>

    <div class="form-container">
        <form action="process_form.php" method="POST">
            <h1>Cadastro</h1>
            <label for="name" id="textName">Nome do Mercado</label>
            <br>
            <input type="text" id="textareaNome" name="name">
            <br>
            <label for="endereco" id="textEndereco">Endereço</label>
            <br>
            <input type="text" id="textareaEndereco" name="endereco">
            <br>
            <label for="cnpj" id="textCNPJ">CNPJ</label>
            <br>
            <input type="text" id="textareaCNPJ" name="cnpj">
            <br>
            <label for="senha" id="textPassword">Senha</label>
            <br>
            <input type="password" id="textareaSenha" name="senha">
            <br>
            <label for="confirmPassword" id="textConfirmPassword">Confirmar Senha</label>
            <br>
            <input type="password" id="textareaConfirmSenha" name="confirmSenha">
            <br>
            <img id="logo" src="/imgs/Logo.png" alt="">
            <button id="bt" type="submit">Cadastrar</button>
            <a href="login.html">Já Possui Cadastro?</a>
        </form>
    </div>

    <script>
        // Função para aplicar a máscara de CNPJ
        function applyCNPJMask(value) {
            value = value.replace(/\D/g, ''); // Remove caracteres não numéricos
            value = value.replace(/^(\d{2})(\d)/, '$1.$2'); // Adiciona ponto
            value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3'); // Adiciona ponto
            value = value.replace(/\.(\d{3})(\d)/, '.$1/$2'); // Adiciona barra
            value = value.replace(/(\d{4})(\d)/, '$1-$2'); // Adiciona hífen
            return value;
        }

        document.getElementById('textareaCNPJ').addEventListener('input', function(event) {
            this.value = applyCNPJMask(this.value);
        });

        // Exibe a mensagem de erro/sucesso
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
                }, 5000);
            }
        });
    </script>
</body>

</html>
