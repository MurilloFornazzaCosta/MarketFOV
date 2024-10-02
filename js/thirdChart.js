const vendasTotais = [];

async function fetchVendas() {
    try {
        const response = await fetch('http://localhost:3306/vendas-totais');
        if (!response.ok) {
            throw new Error(`Erro de rede: ${response.statusText}`);
        }

        const data = await response.json();

        // Limpa o array 'vendas' antes de preenchê-lo novamente
        vendas.length = 0;

        data.forEach(element => {
            vendas.push(element);
        });

        return vendas;

    } catch (error) {
        console.error('Houve um problema com a requisição Fetch:', error);
    }
}


async function showVendas() {
    var divLista = document.getElementById('detalhesProduto');
    var tabelaVendas = document.getElementById('tabelaVendas');
    var chart = document.querySelector('.chart');
    var title = document.getElementById('titleTabela');

    divLista.style.height = '900px';
    tabelaVendas.style.display = 'inline';
    chart.style.marginBottom = '100px';
    title.style.display = 'inline';
    

    // Espera a resolução de fetchVendas antes de prosseguir
    const vendasData = await fetchVendas();

        // Itera sobre os dados de vendas e cria uma nova linha para cada venda
        vendasData.forEach(venda => {
            // Cria uma nova linha <tr>
            const row = document.createElement('tr');
    
            // Cria células <td> e <th> para cada campo de venda
            row.innerHTML = `
                <th scope="row">${venda.codeCupom}</th>
                <td>${venda.dataVenda}</td>
                <td>${venda.cpfCliente}</td>
                <td>${venda.im}</td>
                <td>${venda.cnpj}</td>
                <td>${venda.ie}</td>
                <td>R$ ${venda.totalVenda}</td>
            `;
    
            // Adiciona a nova linha à tabela
            tabelaVendas.appendChild(row);
        });

    
    // Agora, `vendasData` contém os dados retornados pela fetchVendas
    console.log(vendasData);
}
