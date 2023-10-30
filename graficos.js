// Inicializa os gráficos
function inicializarGraficos() {
    // Use a função fetch para carregar o arquivo JSON
    fetch('dadoscadastropet.json')
        .then(response => response.json())
        .then(data => {
            // Agora, 'data' contém os dados do arquivo JSON
            const tiposSanguineos = data.map(pet => pet.tipo_sanguineo);
            const especies = data.map(pet => pet.especie);
            const idades = data.map(pet => calcularIdade(pet.data_nascimento, pet.data_obito));
            const doencas = data.map(pet => pet.doencas_conhecidas.length > 0 ? "Com Doença" : "Sem Doença");
            const vacinas = data.reduce((acc, pet) => {
                return acc.concat(pet.vacinas.map(vacina => `${vacina.tipo_vacina}-${vacina.fabricante_vacina}`));
            }, []);

            criarGraficoEspecies(especies);
            criarGraficoIdades(idades);
            criarGraficoDadosGerais(data);
            criarGraficoDoencas(data);
            criarGraficoVacinas(data);
        })
        .catch(error => {
            console.error('Erro ao carregar o arquivo JSON:', error);
        });
}

// Função para criar o gráfico de pizza (Espécies)
function criarGraficoEspecies(especies) {
    const ctx = document.getElementById("pie-chart-especies").getContext("2d");

    const contagemEspecies = especies.reduce((acc, especie) => {
        acc[especie] = (acc[especie] || 0) + 1;
        return acc;
    }, {});

    new Chart(ctx, {
        type: "pie",
        data: {
            labels: Object.keys(contagemEspecies),
            datasets: [{
                data: Object.values(contagemEspecies),
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

// Função para criar o gráfico de barras (Dados Gerais: Espécie, Sexo)
function criarGraficoDadosGerais(pets) {
    const ctx = document.getElementById("bar-chart-dados-gerais").getContext("2d");

    const especies = [...new Set(pets.map(pet => pet.especie))];
    const sexos = [...new Set(pets.map(pet => pet.sexo))];
    const datasets = [];

    especies.forEach(especie => {
        const data = sexos.map(sexo => {
            const count = pets.filter(pet => pet.especie === especie && pet.sexo === sexo).length;
            return count;
        });

        datasets.push({
            label: especie,
            data: data,
            backgroundColor: getBackgroundColor(especie),
        });
    });

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: sexos,
            datasets: datasets,
        },
        options: {
            scales: {
                x: {
                    stacked: false, // Barras não empiladas
                },
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
}

function getBackgroundColor(especie) {
    // Define cores fixas com base nas espécies
    if (especie === 'Cachorro') {
        return ['rgba(54, 162, 235, 0.5)']; // Azul para Cachorros
    } else if (especie === 'Gato') {
        return ['rgba(255, 99, 132, 0.5)']; // Vermelho para Gatos
    } else {
        return ['rgba(125, 125, 125, 0.5)', 'rgba(125, 125, 125, 0.5)']; // Cor padrão
    }
}





function criarGraficoDoencas(pets) {
    const ctx = document.getElementById("bar-chart-doenca").getContext("2d");

    const contagemDoencas = {
        "Com Doença": 0,
        "Sem Doença": 0
    };

    pets.forEach(pet => {
        if (pet.doencas_conhecidas.length > 0) {
            contagemDoencas["Com Doença"]++;
        } else {
            contagemDoencas["Sem Doença"]++;
        }
    });

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: Object.keys(contagemDoencas),
            datasets: [{
                label: "Possui Doença?",
                data: Object.values(contagemDoencas),
                backgroundColor: [
                    "rgba(75, 192, 192, 0.2)",
                    "rgba(255, 99, 132, 0.2)",
                ],
                borderColor: [
                    "rgba(75, 192, 192, 1)",
                    "rgba(255, 99, 132, 1)",
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


// Função para criar o gráfico de barras (Vacinas)
function criarGraficoVacinas(pets) {
    const ctx = document.getElementById("bar-chart-vacinas").getContext("2d");

    const vacinas = pets.reduce((acc, pet) => {
        return acc.concat(pet.vacinas.map(vacina => `${vacina.tipo_vacina}-${vacina.fabricante_vacina}`));
    }, []);

    const contagemVacinas = vacinas.reduce((acc, vacina) => {
        acc[vacina] = (acc[vacina] || 0) + 1;
        return acc;
    }, {});

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: Object.keys(contagemVacinas),
            datasets: [{
                label: "Contagem de Vacinas",
                data: Object.values(contagemVacinas),
                backgroundColor: [
                    "rgba(75, 192, 192, 0.2)",
                    "rgba(255, 99, 132, 0.2)",
                    "rgba(255, 206, 86, 0.2)",
                    "rgba(54, 162, 235, 0.2)",
                ],
                borderColor: [
                    "rgba(75, 192, 192, 1)",
                    "rgba(255, 99, 132, 1)",
                    "rgba(255, 206, 86, 1)",
                    "rgba(54, 162, 235, 1)",
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


// Função para criar o gráfico de linha (Idades)
function criarGraficoIdades(idades) {
    const ctx = document.getElementById("line-chart-idades").getContext("2d");

    new Chart(ctx, {
        type: "line",
        data: {
            labels: idades.map(String),
            datasets: [{
                label: "Idades de Pets",
                data: idades,
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



// Função para calcular a idade com base na data de nascimento e óbito
function calcularIdade(dataNascimento, dataObito) {
    if (!dataObito) {
        dataObito = new Date(); // Use a data atual se o pet estiver vivo
    } else {
        dataObito = new Date(dataObito);
    }

    dataNascimento = new Date(dataNascimento);

    // Cálculo da idade
    const diff = Math.abs(dataObito - dataNascimento);
    return Math.floor(diff / (1000 * 60 * 60 * 24 * 365.25));
}
