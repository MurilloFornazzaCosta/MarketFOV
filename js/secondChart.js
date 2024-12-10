let produtosVendidos = [];
let nomesEqtd = {};
let dadosChart = [];
let nomesProdutos = [];




async function showChart2() {

    async function fetchVendas() {
        try {
            const response = await fetch('http://localhost:3000/produtos-vendidos');
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const data = await response.json();
            data.forEach(element => {
                produtosVendidos.push(element);
            });
            nomes = produtosVendidos.map(produto => produto.nome);
         
            // Atualiza o gráfico com os novos dados
    
    
        } catch (error) {
            console.error('Houve um problema com a requisição Fetch:', error);
        }
    }

    await fetchVendas();

    function top5Elements(nomes) {
        // Contar a frequência de cada elemento
        const countMap = {};
        nomes.forEach(item => {
            countMap[item] = (countMap[item] || 0) + 1;
        });
    
        // Converter o objeto em um array de [elemento, contagem]
        const sortedElements = Object.entries(countMap)
            .sort((a, b) => b[1] - a[1]) // Ordenar por contagem em ordem decrescente
            .slice(0, 5); // Pegar os 5 elementos mais frequentes
    
        return sortedElements.map(([element, count]) => ({ element, count }));
    }
    
    // Exemplo de uso
    
    nomesProdutos = top5Elements(nomes).map(item => item.element);
    dadosChart = top5Elements(nomes).map(item => item.count);

    console.log(nomes);
    // Seleciona a div que irá conter o gráfico
    var tabelaProdutosDiv = document.querySelector('.tabelaProdutos');

    // Verifica se a div chart2 já existe e a remove se necessário
    var existingChart2Div = document.querySelector('.chart2');
    if (existingChart2Div) {
        existingChart2Div.remove();
    }

    // Cria a div chart2
    var chart2Div = document.createElement('div');
    chart2Div.className = 'chart2';

    // Adiciona a nova div ao container tabelaProdutos
    tabelaProdutosDiv.insertBefore(chart2Div, tabelaProdutosDiv.querySelector('.filtro2'));

    // Cria o elemento canvas
    var canvas = document.createElement('canvas');

    // Configura os atributos do canvas
    canvas.id = 'doughnut';
    canvas.width = 300;
    canvas.height = 300;

    // Adiciona o canvas à div chart2
    chart2Div.appendChild(canvas);

    // Obtém o contexto do canvas
    const ctx2 = canvas.getContext('2d');

    // Cria o gráfico
    doughnut = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: nomesProdutos,
            datasets: [{
                label: '# of Votes',
                data: dadosChart,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                    
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                    
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });
}