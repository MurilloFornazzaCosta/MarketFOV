<?php
session_start();
$produtos = [];
foreach ($_SESSION['produtos'] as $produto) {
    $produtos[] = $produto;
}
$mercado = $_SESSION['mercadoLogado'];
$conn = new mysqli('ESN509VMYSQL', 'aluno', 'Senai1234', 'marketfov4');
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    adicionarVenda(null, $mercado['im'], $mercado['cnpj'], $mercado['ie'], $produtos);
    unset($_SESSION['produtos']);
    header("Location: ../html/fazerCompras.php");
}
function adicionarVenda($cpfCliente, $im, $cnpj, $ie, $produtos = []) {
    // Calcular o total da venda
    $total = 0;
    foreach ($produtos as $produto) {
        $total += $produto['quantidade'] * $produto['preco'];
    }

    // Gerar o cupom fiscal (base64 com dados de cnpj e data)
    $dataCupomBase = time();
    $cupomBase = [
        'data' => $dataCupomBase,
        'cnpj' => $cnpj
    ];
    $cupom = base64_encode(json_encode($cupomBase));
    
    // Definir a data da ve0 nda
    $data = date("Y-m-d");
    $conn = new mysqli('ESN509VMYSQL', 'aluno', 'Senai1234', 'marketfov4');
    // Preparar a consulta SQL para inserir a venda
    $stmt = $conn->prepare("INSERT INTO venda (codeCupom, dataVenda, cpfCliente, im, cnpj, ie, totalVenda) VALUES (?, ?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        return "Erro ao preparar a consulta: " . $this->conn->error;
    }

    // Fazer o bind dos parâmetros
    $stmt->bind_param('ssssssd', $cupom, $data, $cpfCliente, $im, $cnpj, $ie, $total);

    // Executar a consulta e verificar se foi bem-sucedida
    if ($stmt->execute()) {
        // Após inserir a venda, inserir os produtos vendidos
        inserirProdutosVendidos($produtos, $cupom); // Passando o código do cupom gerado
        
        $stmt->close();
        return "Venda adicionada com sucesso!";
    } else {
        return "Erro ao adicionar a venda: " . $stmt->error;
    }
}
function verificarExistenciaCupom($codeCupom)
    {
        $conn = new mysqli('ESN509VMYSQL', 'aluno', 'Senai1234', 'marketfov4');
        // Prepare the query to check if the cupom exists in the venda table
        $stmt = $conn->prepare("SELECT COUNT(*) FROM venda WHERE codeCupom = ?");
        
        if ($stmt === false) {
            return "Erro ao preparar a consulta: " . $this->conn->error;
        }
        
        $stmt->bind_param('s', $codeCupom);
        $stmt->execute();
        
        // Fetch the result
        $stmt->bind_result($count);
        $stmt->fetch();
        
        $stmt->close();
        
        return $count > 0;
    }
     function inserirProdutosVendidos($produtos = [], $codeCupom)
{
    // Verifica se o array de produtos está vazio
    if (empty($produtos)) {
        return "Nenhum produto vendido foi fornecido.";
    }
    $conn = new mysqli('ESN509VMYSQL', 'aluno', 'Senai1234', 'marketfov4');
    // Prepare a SQL query para inserir vendas de produtos, sem o campo 'valor'
    $stmt = $conn->prepare("INSERT INTO produtosvendidos (qtdVendidos, barCode, id, codeCupom, valor) VALUES (?, ?, ?, ?, ?)");

    if ($stmt === false) {
        return "Erro ao preparar a consulta de inserção: " . $this->conn->error;
    }

    foreach ($produtos as $produto) {
        // Verificar se a chave 'codeCupom' está presente no array do produto
        if (!isset($produto['codeCupom'])) {
            return "A chave 'codeCupom' não foi definida para o produto com código de barras " . $produto['barCode'] . ".";
        }
        $total = $produto['qtdVendidos'] * $produto['valor'];
        // Obter o código do cupom e remover espaços extras
        // Verificar se o código do cupom existe na tabela 'venda'
        if (!$this->verificarExistenciaCupom($codeCupom)) {
            return "O código do cupom '$codeCupom' não existe na tabela 'venda'.";
        }

        // Bind dos parâmetros para a consulta (não estamos mais incluindo 'valor')
        $stmt->bind_param('isssd', $produto['qtdVendidos'], $produto['barCode'], $produto['idProduto'], $codeCupom, $total);

        // Executar a consulta
        if (!$stmt->execute()) {
            return "Erro ao inserir produto vendido: " . $stmt->error;
        }
    }

    // Fechar a consulta
    $stmt->close();

    return "Produtos vendidos inseridos com sucesso!";
}