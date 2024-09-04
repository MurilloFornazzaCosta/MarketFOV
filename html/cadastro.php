<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentt</title>
    <link rel="stylesheet" href="../css/cadastro.css">
    <link rel="stylesheet" href="../css/msg.css">
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

        <form action="../php/processa_cadastro.php" method="POST">
            <h1>Cadastro</h1>
            <label for="name" id="textName">Nome do Mercado</label>
            <br>
            <input type="text" id="textareaNome" name="name">
            <br>
            <label for="endereco" id="textEndereco">Endereço</label>
            <br>
            <input type="password" id="textareaEndereco" name="endereco">
            <br>
            <label for="cnpj" id="textCNPJ">CNPJ</label>
            <br>
            <input type="text" id="textareaCNPJ" maxlength="18" name="cnpj">
            <br>
            <label for="ie" id="textIE">Inscrição Estadual</label>
            <br>
            <input type="text" id="textareaIE" name="ie">
            <br>
            <label for="ie" id="textIM">Inscrição Municipal</label>
            <br>
            <input type="text" id="textareaIM" name="im">
            <br>
            <label for="senha" id="textPassword">Senha</label>
            <br>
            <input type="password" id="textareaSenha" name="senha">
            <br>
            <label for="confirmPassword" id="textPassword">Confirmar Senha</label>
            <br>
            <input type="password" id="textareaSenha" name="confirmSenha">
            <br>
            <img id="logo" src="../imgs/Logo.png" alt="">
            <button id="bt">Cadastrar</button>
            <a href="login.html">Já Possui Cadastro?</a>
        </form>
    </div>
</body>
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

    function applyIEandIMmask(value) {
        value = value.replace(/\D/g, '');
        return value;
    }
    document.getElementById('textareaIE').addEventListener('input', function(event) {
        this.value = applyIEandIMmask(this.value)
    })
    document.getElementById('textareaIM').addEventListener('input', function(event) {
        this.value = applyIEandIMmask(this.value)
    })

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
            }, 2500);
        }
    });
</script>

</html>