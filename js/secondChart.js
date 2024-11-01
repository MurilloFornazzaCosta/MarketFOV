let produtosVendidos = [];

async function fetchVendas() {
    try {
        const response = await fetch('http://localhost:3306/produtos-vendidos');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        data.forEach(element => {
            produtosVendidos.push(element);
        });

    } catch (error) {
        console.error('Houve um problema com a requisição Fetch:', error);
    }
}

document.addEventListener("DOMContentLoaded", async function() {
    await fetchVendas();
    fetchVendas();
     // Exibe o conteúdo do array após o carregamento
});





function showChart2() {
    console.log(produtosVendidos);
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
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
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