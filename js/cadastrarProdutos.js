document.getElementById('meuFormulario').addEventListener('submit', function(event) {
    let valido = true;

    // Limpa mensagens de erro
    document.getElementById('errorCDB').textContent = '';
    document.getElementById('errorNome').textContent = '';
    document.getElementById('errorPreco').textContent = '';
    document.getElementById('errorTipo').textContent = '';
    document.getElementById('errorQuantd').textContent = '';

    // Validação do Código de Barras
    const codigodebarra = document.getElementById('textareacdb').value;
    if (codigodebarra.trim() === '' && valido == true) {
        document.getElementById('errorCDB').textContent = 'Código de barras é obrigatório.';
        valido = false;
    } else{
        document.getElementById('errorCDB').textContent = 'n funfou.';
    }

    // Validação do Nome do Produto
    const nome = document.getElementById('textareaNome').value;
    if (nome.trim() === '' && valido == true) {
        document.getElementById('errorNome').textContent = 'Nome do produto é obrigatório.';
        valido = false;
    }

    // Validação do Preço
    const preco = document.getElementById('textareaPreco').value;
    if (preco.trim() === '' || isNaN(preco) || preco <= 0) {
        document.getElementById('errorPreco').textContent = 'Preço deve ser um número positivo.';
        valido = false;
    }

    // Validação do Tipo de Produto
    const tipo = document.getElementById('tipos').value;
    if (tipo === '') {
        document.getElementById('errorTipo').textContent = 'Tipo de produto é obrigatório.';
        valido = false;
    }
    const quantd = document.getElementById('textareaQuantd').value
    if (quantd === '' || isNaN(quantd) || quantd <= 0 && valido == true) {
        document.getElementById('errorQuantd').textContent = 'Quantidade inserida inválida!'
    }
    // Se algum campo não for válido, previne o envio do formulário
    if (!valido) {
        event.preventDefault();
    }
});