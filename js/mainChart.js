const ctx = document.getElementById('barchart').getContext('2d');
const selectElement = document.getElementById('example_select');
let barchart;
let label;
let dados = [];
let totaisDasVendas = []; // Para armazenar o valor total de cada venda
let datasVendas = [];
let vendas = [];
let valorVenda;
var valorDoDia;
let vendasPorDia = {};
let vendasPorMes = {};
let arrayMeses = ['01-2024', '02-2024', '03-2024', '04-2024', '05-2024', '06-2024', '07-2024', '08-2024', '09-2024', '10-2024', '11-2024', '12-2024'];
let dadosVendasDias = [0,0,0,0,0,0,0]
let dadosVendasMes = [0,0,0,0,0,0,0,0,0,0,0,0];
let contador = 0;


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

document.addEventListener('DOMContentLoaded', function () {
    // Chama a função para obter os dados assim que a página for carregada
    console.log(fetchVendas());
    console.log(datasVendas);
});


document.addEventListener('DOMContentLoaded', function () {



    selectElement.value = 'mes';
    label = ['Janeir', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

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


function somaVendasPorDia() {
    const vendasPorDia = {};
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
    return results;
}


selectElement.addEventListener("change", function () {

    
    console.log(somaVendasPorDia());



    function somaVendasPorMes() {
        const vendasPorMes = {}; // Inicializa o objeto para armazenar as vendas por mês
    
        vendas.forEach(venda => {
            // Verifica se a propriedade 'dataVenda' está definida e é uma string
            if (venda.dataVenda && typeof venda.dataVenda === 'string') {
                // Extrair o mês e o ano manualmente da string de data 'YYYY-MM-DD'
                const partesData = venda.dataVenda.split('-'); // Quebra a string em [YYYY, MM, DD]
                const ano = partesData[0];
                const mes = partesData[1];
    
                const mesAno = `${mes}-${ano}`; // Formato MM-YYYY
    
                if (vendasPorMes[mesAno]) {
                    // Se já houver vendas para esse mês, somar o total da venda atual
                    vendasPorMes[mesAno] += venda.totalVenda;
                } else {
                    // Se não houver vendas para esse mês, inicializar com o total da venda atual
                    vendasPorMes[mesAno] = venda.totalVenda;
                }
            } else {
                console.error('Data inválida para venda:', venda);
            }
        });
    
        // Converter o objeto vendasPorMes em um array de resultados
        const results = Object.keys(vendasPorMes).map(mesAno => {
            return { mesAno: mesAno, totalVenda: vendasPorMes[mesAno] };
        });
    
        contador++; // Certifique-se de que o contador é global e inicializado
        return results;
    }
    
    
    
    


    console.log(somaVendasPorMes())



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
        
        const meses = somaVendasPorMes().map(item => item.mesAno);
        console.log(meses);

        for (let i = 0; i < meses.length; i++) {
            for (let i2 = 0; i2 < arrayMeses.length; i2++) {
                if (meses[i] == arrayMeses[i2]) {
                    dadosVendasMes[i2] = somaVendasPorMes().map(item => item.totalVenda)[i];
                }
                
            }
                
        }

        dados = dadosVendasMes;
        console.log(dadosVendasMes);
        //console.log(somaVendasPorMes().map(item => item.totalVenda));

    }

    if (selectElement.value == "dia") {
        label = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
        const dias = somaVendasPorDia().map(item => item.data);
        console.log(dias + 'testeeee');

        for (let i = 0; i < dias.length; i++) {

            const diaSemanaObj = new Date(dias[i]);
            const diaSemana = diaSemanaObj.getDay();
            console.log(label[diaSemana] + 'teste');


            for (let i2 = 0; i2 < label.length; i2++) {
                if (label[diaSemana] == label[i2]) {
                    dadosVendasDias[i2] = somaVendasPorDia().map(item => item.totalVenda)[i];
                }    
            }
            
        }

        dados = dadosVendasDias;
        console.log(dadosVendasDias);

    }

    // Recria o gráfico com os novos labels e os valores já calculados
    barchart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: label,
            datasets: [{
                label: '',
                data: dados, // Usa os valores calculados aqui
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