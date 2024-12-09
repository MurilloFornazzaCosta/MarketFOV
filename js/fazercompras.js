document.addEventListener("DOMContentLoaded", function () {
  // Função para calcular o total e atualizar a quantidade
  function calcularTotal() {
    let total = 0;
    const produtos = {}; // Objeto para armazenar as quantidades e preços por nome

    // Seleciona todas as linhas da tabela
    const linhas = document.querySelectorAll(".tabelaProdutos tbody tr");

    // Percorre cada linha da tabela
    linhas.forEach((linha) => {
      const nomeProduto = linha.children[0].textContent; // Nome do produto na primeira coluna
      const precoTexto = linha.children[2].textContent; // Preço na terceira coluna
      const quantidadeTexto = linha.children[1].textContent; // Quantidade na segunda coluna

      // Remove o símbolo de R$ e a vírgula do preço
      const preco = parseFloat(precoTexto.replace("R$", "").replace(",", "."));
      const quantidade = parseInt(quantidadeTexto, 10);

      // Se o produto já existe no objeto, soma a quantidade e o preço
      if (produtos[nomeProduto]) {
        produtos[nomeProduto].quantidade += quantidade;
        produtos[nomeProduto].preco += preco * quantidade;
      } else {
        produtos[nomeProduto] = {
          quantidade: quantidade,
          preco: preco * quantidade,
        };
      }
    });

    // Atualiza a tabela com as quantidades agregadas
    const corpoTabela = document.querySelector(".tabelaProdutos tbody");
    corpoTabela.innerHTML = ""; // Limpa o corpo da tabela

    for (const [nomeProduto, dados] of Object.entries(produtos)) {
      const novaLinha = document.createElement("tr");
      novaLinha.innerHTML = `
                <th>${nomeProduto}</th>
                <td>${dados.quantidade}</td>
                <td>R$${(dados.preco / dados.quantidade)
                  .toFixed(2)
                  .replace(".", ",")}</td>
            `;
      corpoTabela.appendChild(novaLinha);
    }

    // Calcula o total
    total = Object.values(produtos).reduce(
      (acc, dados) => acc + dados.preco,
      0
    );

    // Atualiza o valor total na tabela
    const totalElemento = document.querySelector(".tabelaProdutos tfoot td");
    totalElemento.textContent = `R$${total.toFixed(2).replace(".", ",")}`;
  }

  // Chama a função para calcular o total ao carregar a página
  calcularTotal();
});

document.addEventListener("DOMContentLoaded", function () {
  var imageContainer = document.querySelector(".image-container");
  var commentBox = document.getElementById("comment-box");

  imageContainer.addEventListener("mouseover", function () {
    commentBox.style.display = "block";
  });

  imageContainer.addEventListener("mouseout", function () {
    commentBox.style.display = "none";
  });
});

