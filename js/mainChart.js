const ctx = document.getElementById('barchart').getContext('2d');
const selectElement = document.getElementById('example_select');
let barchart; // Declare a variável barchart fora do escopo do evento
let label;

document.addEventListener('DOMContentLoaded', function(){
    selectElement.value = 'mes';
    label = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    barchart = new Chart(ctx, {  // Note que agora usamos barchart sem const
        type: 'bar',
        data: {
            labels: label,
            datasets: [{
                label: 'Relatório de vendas',
                data: [12, 19, 3, 5, 2, 3, 5, 20, 12, 24, 5, 12], // Você pode ajustar os dados aqui conforme necessário
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

selectElement.addEventListener("change", function() {

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

    // Cria um novo gráfico com os labels e dados definidos
    barchart = new Chart(ctx, {  // Note que agora usamos barchart sem const
        type: 'bar',
        data: {
            labels: label,
            datasets: [{
                label: 'Relatório de vendas',
                data: [12, 19, 3, 5, 2, 3, 5, 20, 12, 24, 5, 12], // Você pode ajustar os dados aqui conforme necessário
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
