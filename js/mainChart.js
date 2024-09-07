const ctx = document.getElementById('barchart').getContext('2d');
const selectElement = document.getElementById('example_select');
let barchart;
let label;
let totaisDasVendas = []; // Para armazenar o valor total de cada venda
let datasVendas = [];
let vendas = [];
let valorVenda;
var valorDoDia;
let vendasPorDia = {};


// Função para obter dados do servidor e calcular o valor total de cada venda
async function fetchVendas() {
    try {
        const response = await fetch('http://localhost:3306/vendas');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        data.forEach(element => {
            vendas.push(element)
        });
        // Calcula o valor total para cada venda 
        totaisDasVendas = data.map(venda => venda.totalVenda);
        datasVendas = data.map(venda => venda.dataVenda);

        // Atualiza o gráfico com os novos dados
        if (barchart) {
            barchart.data.datasets[0].data = totaisDasVendas;
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
            labels: datasVendas,
            datasets: [{
                label: 'Relatório de vendas',
                data: totaisDasVendas, // Agora usa os dados calculados
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
let contador = 0;
selectElement.addEventListener("change", function () {
    // for (let index = 0; index < datasVendas.length; index++) {

    //     datasVendas[index] = datasVendas[index - 1];

    //     valorVenda = totaisDasVendas[index] + totaisDasVendas[index - 1];

    //     console.log(valorVenda);
    // }
    function somaVendasPorDia() {
        if (contador == 0) {
            vendas.forEach(venda => {
                if (vendasPorDia[venda.dataVenda]) {
                    vendasPorDia[venda.dataVenda] += venda.totalVenda;
                } else {
                    vendasPorDia[venda.dataVenda] = venda.totalVenda
                }
            });

            const results = Object.keys(vendasPorDia).map(data => {
                return { data: data, totalVenda: vendasPorDia[data] };
            });
            contador++;
            return results;
        } else {
        }
    }
    console.log(somaVendasPorDia());
    console.log(datasVendas)
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
            labels: '',
            datasets: [{
                label: '',
                data: vendasPorDia, // Usa os valores calculados aqui
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

const ctx = document.getElementById('barchart').getContext('2d');
const selectElement = document.getElementById('example_select');
let barchart;
let label;
let totaisDasVendas = []; // Para armazenar o valor total de cada venda
let datasVendas = [];
let vendas = [];
let valorVenda;
var valorDoDia;
let vendasPorDia = {};


// Função para obter dados do servidor e calcular o valor total de cada venda
async function fetchVendas() {
    try {
        const response = await fetch('http://localhost:3306/vendas');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        data.forEach(element => {
            vendas.push(element)
        });
        // Calcula o valor total para cada venda 
        totaisDasVendas = data.map(venda => venda.totalVenda);
        datasVendas = data.map(venda => venda.dataVenda);

        // Atualiza o gráfico com os novos dados
        if (barchart) {
            barchart.data.datasets[0].data = totaisDasVendas;
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
            labels: datasVendas,
            datasets: [{
                label: 'Relatório de vendas',
                data: totaisDasVendas, // Agora usa os dados calculados
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
let contador = 0;
selectElement.addEventListener("change", function () {
    // for (let index = 0; index < datasVendas.length; index++) {

    //     datasVendas[index] = datasVendas[index - 1];

    //     valorVenda = totaisDasVendas[index] + totaisDasVendas[index - 1];

    //     console.log(valorVenda);
    // }
    function somaVendasPorDia() {
        if (contador == 0) {
            vendas.forEach(venda => {
                if (vendasPorDia[venda.dataVenda]) {
                    vendasPorDia[venda.dataVenda] += venda.totalVenda;
                } else {
                    vendasPorDia[venda.dataVenda] = venda.totalVenda
                }
            });

            const results = Object.keys(vendasPorDia).map(data => {
                return { data: data, totalVenda: vendasPorDia[data] };
            });
            contador++;
            return results;
        } else {
        }
    }
    console.log(somaVendasPorDia());
    console.log(datasVendas)
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
            labels: '',
            datasets: [{
                label: '',
                data: vendasPorDia, // Usa os valores calculados aqui
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
