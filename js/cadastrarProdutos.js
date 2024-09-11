// Evento de submit do formulário
document.getElementById('meuFormulario').addEventListener('submit', function (event) {
    let valido = true;

    // Limpa mensagens de erro
    document.getElementById('errorCDB').textContent = '';
    document.getElementById('errorNome').textContent = '';
    document.getElementById('errorPreco').textContent = '';
    document.getElementById('errorTipo').textContent = '';
    document.getElementById('errorQuantd').textContent = '';

    // Limpa imagens
    document.getElementById('produtoRegistrado').style.display = 'none';
    document.getElementById('erroAoRegistrar').style.display = 'none';

    // Validação do Código de Barras
    const codigodebarra = document.getElementById('codigodebarra').value;
    if (codigodebarra.trim() === '') {
        document.getElementById('errorCDB').textContent = 'Código de barras é obrigatório.';
        valido = false;
    }

    // Validação do Nome do Produto
    const nome = document.getElementById('nome').value;
    if (nome.trim() === '') {
        document.getElementById('errorNome').textContent = 'Nome do produto é obrigatório.';
        valido = false;
    }

    // Validação do Preço
    const preco = document.getElementById('preco').value;
    if (preco.trim() === '' || isNaN(preco) || preco <= 0) {
        document.getElementById('errorPreco').textContent = 'Preço deve ser um número positivo.';
        valido = false;
    }

    // Validação da Quantidade
    const quantd = document.getElementById('quantd').value;
    if (quantd.trim() === '' || isNaN(quantd) || quantd <= 0) {
        document.getElementById('errorQuantd').textContent = 'Quantidade deve ser um número positivo.';
        valido = false;
    }

    // Validação do Tipo de Produto
    const tipo = document.getElementById('tipo').value;
    if (tipo === '') {
        document.getElementById('errorTipo').textContent = 'Tipo de produto é obrigatório.';
        valido = false;
    }

    // Se o formulário não for válido, previne o envio
    if (!valido) {
        document.getElementById('erroAoRegistrar').style.display = 'block';
        setTimeout(() => {
            document.getElementById('erroAoRegistrar').style.display = 'none';
        }, 3000);
        event.preventDefault();
        return;
    }
});

// Exibição de mensagens ao carregar a página
window.onload = function () {
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('message');
    if (message) {
        if (message.includes('Erro') || message.includes('obrigatório')) {
            document.getElementById('erroAoRegistrar').textContent = decodeURIComponent(message);
            document.getElementById('erroAoRegistrar').style.display = 'block';
            setTimeout(() => {
                document.getElementById('erroAoRegistrar').style.display = 'none';
            }, 3000);
        } else if (message.includes('sucesso')) {
            document.getElementById('produtoRegistrado').textContent = decodeURIComponent(message);
            document.getElementById('produtoRegistrado').style.display = 'block';
            setTimeout(() => {
                document.getElementById('produtoRegistrado').style.display = 'none';
            }, 3000);
        }
    }
};
