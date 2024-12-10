const ctx = document.getElementById('barchart').getContext('2d');
const selectElement = document.getElementById('example_select');
const urlParams = new URLSearchParams(window.location.search);
const cnpj = urlParams.get('cnpj');
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
let dadosVendasSemanas = [0,0,0,0];
let contador = 0;


// Função para obter dados do servidor e calcular o valor total de cada venda
document.addEventListener("DOMContentLoaded", async function() {
    await fetchVendas();
});

async function fetchVendas() {
    try {                                            //3306     
        const response = await fetch("http://localhost:3000/vendas?cnpj=01234567890123");
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        data.forEach(element => {
            vendas.push(element);
        });
       
        // Atualiza o gráfico com os novos dados
        if (barchart) {
            barchart.data.datasets[0].data = totaisDasVendas;
            barchart.update(); // Atualiza o gráfico
        }

    } catch (error) {
        console.error('Houve um problema com a requisição Fetch:', error);
    }
}

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



document.addEventListener('DOMContentLoaded', async function () {
    await fetchVendas(); 
    console.log(vendas);



    const mesesInit = somaVendasPorMes().map(item => item.mesAno);
        console.log(mesesInit);

        for (let i = 0; i < mesesInit.length; i++) {
            for (let i2 = 0; i2 < arrayMeses.length; i2++) {
                if (mesesInit[i] == arrayMeses[i2]) {
                    dadosVendasMes[i2] = somaVendasPorMes().map(item => item.totalVenda)[i];
                }
                
            }
                
        }

        dados = dadosVendasMes;


    selectElement.value = 'mes';
    label = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

    barchart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: label,
            datasets: [{
                label: 'Total de vendas em R$',
                data: dados, // Agora usa os dados calculados
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

    function filtrarVendasMesAtual(vendas) {
        const hoje = new Date(); // Obtém a data atual
        const mesAtual = hoje.getMonth(); // Obtém o mês atual (0 para Janeiro, 11 para Dezembro)
        const anoAtual = hoje.getFullYear(); // Obtém o ano atual
    
        // Filtrar as vendas que ocorreram no mês e ano atual
        return vendas.filter(venda => {
            const dataVenda = new Date(venda.data); // Corrige para acessar a propriedade 'data'
            return dataVenda.getMonth() === mesAtual && dataVenda.getFullYear() === anoAtual;
        });
    }
        

    console.log(somaVendasPorMes())



    // Verifica se o gráfico existe e o destrói antes de criar um novo
    if (barchart) {
        barchart.destroy();
    }

    function getNumeroSemana(data) {
        const dataObj = new Date(data);
        const primeiroDiaDoAno = new Date(dataObj.getFullYear(), 0, 1);
        const diasPassados = Math.floor((dataObj - primeiroDiaDoAno) / (24 * 60 * 60 * 1000));
        
        // Calcula o número da semana, considerando o primeiro dia do ano como semana 1
        return Math.ceil((diasPassados + primeiroDiaDoAno.getDay() + 1) / 7);
    }

    // Define os labels com base na opção selecionada
    if (selectElement.value == "semana") {
        label = ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4'];
        const dias = somaVendasPorDia().map(item => item.data);

        function getNumeroSemanaDoMes(data) {
            const dataObj = new Date(data);
            const diaDoMes = dataObj.getDate(); // Obtém o dia do mês
        
            // Ajusta o cálculo para que a semana do mês seja calculada corretamente
            const semanaDoMes = Math.ceil(diaDoMes / 7); // Dividindo o dia do mês por 7 para determinar a semana do mês
        
            return 'Semana ' + semanaDoMes; // Retorna o número da semana dentro do mês
        }
        
        function obterDatasPorSemanaDoMes(datas) {
            const hoje = new Date();
            const mesAtual = hoje.getMonth(); // Obtém o mês atual (0 para Janeiro, 11 para Dezembro)
            const anoAtual = hoje.getFullYear(); // Obtém o ano atual
            
            // Filtro para pegar apenas as datas que são do mês e ano atual
            const datasDoMesAtual = datas.filter(data => {
                const dataObj = new Date(data);
                return dataObj.getMonth() === mesAtual && dataObj.getFullYear() === anoAtual;
            });
        
            // Objeto para armazenar as semanas e suas respectivas datas
            const semanasDoMes = {};
        
            // Itera sobre as datas do mês atual
            datasDoMesAtual.forEach(data => {
                const semanaRelativa = getNumeroSemanaDoMes(data); // Calcula a semana relativa do mês
                if (!semanasDoMes[semanaRelativa]) {
                    semanasDoMes[semanaRelativa] = []; // Cria um array vazio para a semana, se não existir
                }
                semanasDoMes[semanaRelativa].push(data); // Adiciona a data à semana correspondente
            });
        
            return semanasDoMes;
        }

        function somaVendasPorSemana(vendas) {
            const vendasPorSemana = {}; // Objeto para armazenar as vendas por semana
        
            vendas.forEach(venda => {
                if (venda.data && typeof venda.data === 'string') {
                    // Extrair o número da semana da data da venda
                    const semana = getNumeroSemanaDoMes(venda.data);
                    
                    if (vendasPorSemana[semana]) {
                        // Se já houver vendas para essa semana, somar o total da venda atual
                        vendasPorSemana[semana] += venda.totalVenda;
                    } else {
                        // Se não houver vendas para essa semana, inicializar com o total da venda atual
                        vendasPorSemana[semana] = venda.totalVenda;
                    }
                } else {
                    console.error('Data inválida para venda:', venda);
                }
            });
        
            // Converter o objeto vendasPorSemana em um array de resultados
            const resultados = Object.keys(vendasPorSemana).map(semana => {
                return { semana: semana, totalVenda: vendasPorSemana[semana] };
            });
        
            return resultados;
        }
    
        console.log(somaVendasPorSemana(filtrarVendasMesAtual(somaVendasPorDia())));
        

        const semanas = obterDatasPorSemanaDoMes(dias);

        for (let i = 0; i < label.length; i++) {
            
            for (let i2 = 0; i2 < somaVendasPorSemana(filtrarVendasMesAtual(somaVendasPorDia())).length; i2++) {
                if (somaVendasPorSemana(filtrarVendasMesAtual(somaVendasPorDia())).map(item => item.semana)[i2] == label[i]) {
                    console.log('teste certo');
                    dadosVendasSemanas[i] = somaVendasPorSemana(filtrarVendasMesAtual(somaVendasPorDia())).map(item => item.totalVenda)[i2];
                } else {
                    console.log('teste errado');

                } 
                
            }
            
        }

        dados = dadosVendasSemanas;
        console.log(dadosVendasSemanas);
        console.log(label);


        
        
        console.log(semanas);
        
        //console.log(dias);

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
        console.log(dias + ' = dias');

        
        function mesmaSemana(data) {
            const hoje = new Date();
            
            // Obtém número da semana e ano da data fornecida
            const numeroSemanaData = getNumeroSemana(data);
            const anoData = new Date(data).getFullYear();
            
            // Obtém número da semana e ano da data atual
            const numeroSemanaAtual = getNumeroSemana(hoje);
            const anoAtual = hoje.getFullYear();
            
            // Verifica se é a mesma semana e o mesmo ano
            return numeroSemanaData === numeroSemanaAtual && anoData === anoAtual;
        }
        
        // Exemplo de uso
        

        for (let i = 0; i < dias.length; i++) {

            const diaSemanaObj = new Date(dias[i]);
            const diaSemana = diaSemanaObj.getDay();
            console.log(label[diaSemana] + 'teste');

            if (mesmaSemana(dias[i])) {
                console.log('true');
                for (let i2 = 0; i2 < label.length; i2++) {
                    if (label[diaSemana] == label[i2]) {
                        dadosVendasDias[i2] = somaVendasPorDia().map(item => item.totalVenda)[i];
                    }    
                }
                
            } else {
                console.log('false');
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
                label: 'Total de vendas em R$',
                data: dados, // Usa os valores calculados aqui
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