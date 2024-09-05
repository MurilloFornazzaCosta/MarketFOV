const ctx = document.getElementById('barchart').getContext('2d');
const selectElement = document.getElementById('example_select');
let barchart;
let label;
let totalPorVenda = []; // Para armazenar o valor total de cada venda
let datasVenda = [];
var valorDoDia;

// Função para obter dados do servidor e calcular o valor total de cada venda
async function fetchVendas() {
    try {
        const response = await fetch('http://localhost:3306/vendas');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();

        // Calcula o valor total para cada venda (preço * qtdVendidos)
        totalPorVenda = data.map(venda => venda.preco * venda.qtdVendidos);
        datasVenda = data.map(venda => venda.dataVenda);
        for (let index = 0; index < totalPorVenda.length; index++) {
            
            if (datasVenda[index] === datasVenda[index - 1] && index > 0) {
                valorDoDia += totalPorVenda[index];
            } else {
                valorDoDia = 'ddd';
            }

        }
        // Atualiza o gráfico com os novos dados
        if (barchart) {
            barchart.data.datasets[0].data = totalPorVenda;
            barchart.update(); // Atualiza o gráfico
        }

    } catch (error) {
        console.error('Houve um problema com a requisição Fetch:', error);
    }

}

// Chama a função para obter os dados
fetchVendas();



document.addEventListener('DOMContentLoaded', function () {
    selectElement.value = 'mes';
    label = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

    barchart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: label,
            datasets: [{
                label: 'Relatório de vendas',
                data: totalPorVenda, // Agora usa os dados calculados
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
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});

selectElement.addEventListener("change", function () {



    //valorDoDia = 'ddd';

    console.log(valorDoDia);

    // Verifica se o gráfico existe e o destrói antes de criar um novo
    if (barchart) {
        barchart.destroy();
    }

    // Define os labels com base na opção selecionada
    if (selectElement.value == "semana") {
        label = ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4'];
    }

    if (selectElement.value == "mes") {
        label = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    }

    if (selectElement.value == "dia") {
        label = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];
    }

    // Recria o gráfico com os novos labels e os valores já calculados
    barchart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: datasVenda,
            datasets: [{
                label: 'Relatório de vendas',
                data: valorDoDia, // Usa os valores calculados aqui
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
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
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

});
