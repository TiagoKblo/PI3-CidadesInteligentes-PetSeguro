// Dados de exemplo (substitua por seus próprios dados do MongoDB)
const dados = {
    tiposSanguineos: ["A+", "B+", "AB-", "O+", "A+", "AB-", "O-"],
    especies: ["Cachorro", "Gato", "Cachorro", "Cachorro", "Gato", "Gato", "Cachorro"],
    idades: [5, 3, 2, 7, 1, 4, 6],
};

// Função para criar o gráfico de barras (Tipos Sanguíneos)
function criarGraficoTiposSanguineos() {
    const ctx = document.getElementById("bar-chart-tipo-sanguineo").getContext("2d");

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: [...new Set(dados.tiposSanguineos)],
            datasets: [{
                label: "Contagem de Tipos Sanguíneos",
                data: [...dados.tiposSanguineos].reduce((acc, tipo) => {
                    acc[tipo] = (acc[tipo] || 0) + 1;
                    return acc;
                }, {}),
                backgroundColor: [
                    "rgba(75, 192, 192, 0.2)",
                    "rgba(255, 99, 132, 0.2)",
                    "rgba(255, 206, 86, 0.2)",
                    "rgba(54, 162, 235, 0.2)",
                    "rgba(153, 102, 255, 0.2)",
                ],
                borderColor: [
                    "rgba(75, 192, 192, 1)",
                    "rgba(255, 99, 132, 1)",
                    "rgba(255, 206, 86, 1)",
                    "rgba(54, 162, 235, 1)",
                    "rgba(153, 102, 255, 1)",
                ],
                borderWidth: 1,
            }],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// Função para criar o gráfico de pizza (Espécies)
function criarGraficoEspecies() {
    const ctx = document.getElementById("pie-chart-especies").getContext("2d");

    new Chart(ctx, {
        type: "pie",
        data: {
            labels: [...new Set(dados.especies)],
            datasets: [{
                data: [...dados.especies].reduce((acc, especie) => {
                    acc[especie] = (acc[especie] || 0) + 1;
                    return acc;
                }, {}),
                backgroundColor: [
                    "rgba(75, 192, 192, 0.2)",
                    "rgba(255, 99, 132, 0.2)",
                    "rgba(255, 206, 86, 0.2)",
                    "rgba(54, 162, 235, 0.2)",
                    "rgba(153, 102, 255, 0.2)",
                ],
            }],
        },
    });
}

// Função para criar o gráfico de linha (Idades)
function criarGraficoIdades() {
    const ctx = document.getElementById("line-chart-idades").getContext("2d");

    new Chart(ctx, {
        type: "line",
        data: {
            labels: dados.idades.map(String),
            datasets: [{
                label: "Idades de Pets",
                data: dados.idades,
                borderColor: "rgba(75, 192, 192, 1)",
                borderWidth: 2,
                fill: false,
            }],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function inicializarGraficos() {
    // Chame as funções para criar os gráficos aqui
    criarGraficoTiposSanguineos();
    criarGraficoEspecies();
    criarGraficoIdades();
}

