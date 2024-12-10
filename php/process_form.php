<?php
function validateCNPJ($cnpj) {
    // Remove caracteres não numéricos
    $cnpj = preg_replace('/\D/', '', $cnpj);

    // Verifica se o CNPJ possui 14 dígitos
    if (strlen($cnpj) != 14) {
        return false;
    }

    // CNPJ's com todos os dígitos iguais são inválidos
    if (preg_match('/^(\d)\1{13}$/', $cnpj)) {
        return false;
    }

    // Valida o primeiro dígito verificador
    $sum = 0;
    $weights = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    for ($i = 0; $i < 12; $i++) {
        $sum += $cnpj[$i] * $weights[$i];
    }
    $remainder = $sum % 11;
    $firstDigit = $remainder < 2 ? 0 : 11 - $remainder;
    if ($cnpj[12] != $firstDigit) {
        return false;
    }

    // Valida o segundo dígito verificador
    $sum = 0;
    $weights = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    for ($i = 0; $i < 13; $i++) {
        $sum += $cnpj[$i] * $weights[$i];
    }
    $remainder = $sum % 11;
    $secondDigit = $remainder < 2 ? 0 : 11 - $remainder;
    if ($cnpj[13] != $secondDigit) {
        return false;
    }

    return true;
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura e sanitiza os dados
    $name = htmlspecialchars(trim($_POST['name']));
    $endereco = htmlspecialchars(trim($_POST['endereco']));
    $cnpj = htmlspecialchars(trim($_POST['cnpj']));
    $senha = htmlspecialchars(trim($_POST['senha']));
    $confirmSenha = htmlspecialchars(trim($_POST['confirmSenha']));

    // Valida campos obrigatórios
    if (empty($name)) {
        $errors[] = "O nome do mercado é obrigatório.";
    }
    if (empty($endereco)) {
        $errors[] = "O endereço é obrigatório.";
    }
    if (empty($cnpj)) {
        $errors[] = "O CNPJ é obrigatório.";
    } elseif (!validateCNPJ($cnpj)) {
        $errors[] = "O CNPJ informado é inválido.";
    }
   
    if (empty($senha)) {
        $errors[] = "A senha é obrigatória.";
    }
    if (empty($confirmSenha)) {
        $errors[] = "A confirmação da senha é obrigatória.";
    }
    if ($senha !== $confirmSenha) {
        $errors[] = "As senhas não coincidem.";
    }

    if (!empty($errors)) {
        $message = implode(' | ', $errors);
        header("Location: cadastro.php?message=" . urlencode($message));
        exit;
    } else {
        //$conn = new mysqli('ESN509VMYSQL', 'aluno', 'Senai1234', 'marketfov4');
        $conn = new mysqli('localhost', 'root', '102938', 'marketfov5');

        $insere = $conn->prepare("INSERT INTO mercados VALUES (?, ?, ?, ?, ?, ?)");
        $insere->bind_param('ssssss', $endereco, $im, $cnpj, $ie, $name, $senha);
        if ($insere->execute()) {
            $message = "Cadastro realizado com sucesso!";
        }
        header("Location: cadastro.php?message=" . urlencode($message) . "&success=true");
        exit;
    }
} else {
    header("Location: cadastro.php");
    exit;
}
?>
