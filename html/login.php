<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/login.css">
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
        <form action="../php/processa_login.php" method="post">
            <h1>Login</h1>
            <label for="cnpj" id="textCNPJ">CNPJ</label>
            <br>
            <input type="text" id="textareaCNPJ" name="cnpj">
            <br>
            <label for="senha" id="textPassword">Senha</label>
            <br>
            <input type="password" id="textareaSenha" name="senha">
            <br>
            <img id="logo" src="../imgs/Logo.png" alt="">
            <button id="bt">Logar</button>
        </form>
    </div>
</body>
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

</html>