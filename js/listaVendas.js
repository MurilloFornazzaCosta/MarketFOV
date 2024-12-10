const vendasTotais = [];

async function fetchVendas() {
    try {
        const response = await fetch('http://localhost:3000/vendas-totais');
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
    var vazio = '';
    const tabelaVendasBody = document.getElementById('tabela-vendas-body');


    divLista.style.height = '900px';
    tabelaVendas.style.display = 'inline';
    tabelaVendas.style.borderCollapse = 'collapse';
    //tabelaVendas.style.border = '2px solid #5a8b7a';
    tabelaVendas.style.borderRadius = '10px';
    tabelaVendas.style.marginBottom = '50px'
    chart.style.marginBottom = '100px';
    title.style.display = 'inline';
    

    // Espera a resolução de fetchVendas antes de prosseguir
    
    const vendasData = await fetchVendas();

    
    // Limpa as linhas anteriores da tabela para evitar duplicação
    tabelaVendasBody.innerHTML = ''; 
    
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
    
        // Adiciona a nova linha ao tbody
        
        tabelaVendasBody.appendChild(row);
        
    });
    
    // Agora, `vendasData` contém os dados retornados pela fetchVendas
    console.log(vendasData);
}
