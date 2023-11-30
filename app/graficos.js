// Inicializa os gráficos
function inicializarGraficos() {
    // Use a função fetch para carregar o arquivo JSON
    fetch('dadoscadastropet.json')
        .then(response => response.json())
        .then(data => {
            // Agora, 'data' contém os dados do arquivo JSON
            const especies = data.map(pet => pet.DadosGerais.Especie);
            const sexos = data.map(pet => pet.DadosGerais.SexoAnimal);
            const castrados = data.map(pet => pet.InformacoesSaude.Castrado);
            const doencas = data.map(pet => pet.InformacoesSaude.DoencasConhecidas === "Sim" ? "Com Doença" : "Sem Doença");
            const vacinas = data.reduce((acc, pet) => {
                if (pet.Vacinas && pet.Vacinas.AnimalVacinado === "Sim") {
                    // Verifique se o animal está vacinado
                    return acc.concat(pet); // Adicione o animal à lista de vacinados
                }
                else if (pet.Vacinas && pet.Vacinas.AnimalVacinado === "Não") {
                    // Verifique se o animal não está vacinado
                    return acc.concat(pet); // Adicione o animal à lista de não vacinados
                }

                return acc;
            }, []);



            criarGraficoEspecies(especies);
            criarGraficoSexo(sexos);
            criarGraficoCastracao(castrados);
            criarGraficoDoencas(doencas);
            criarGraficoVacinas(vacinas);
            criarGraficoIdades(data);
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
                    "rgba(255, 0, 0, 0.5)",       // Vermelho
                    "rgba(0, 255, 0, 0.5)",       // Verde
                    "rgba(0, 0, 255, 0.5)",       // Azul
                    "rgba(255, 255, 0, 0.5)",     // Amarelo
                    "rgba(255, 165, 0, 0.5)",     // Laranja
                    "rgba(128, 0, 128, 0.5)"      // Roxo

                ],
            }],
        },
    });
}

// Função para criar o gráfico de barras (Sexo)
function criarGraficoSexo(sexos) {
    const ctx = document.getElementById("bar-chart-sexo").getContext("2d");

    const contagemSexo = sexos.reduce((acc, sexo) => {
        acc[sexo] = (acc[sexo] || 0) + 1;
        return acc;
    }, {});

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: Object.keys(contagemSexo),
            datasets: [{
                label: "Sexo dos Animais",
                data: Object.values(contagemSexo),
                backgroundColor: [
                    "rgba(75, 192, 192, 0.8)",
                    "rgba(255, 99, 132, 0.8)",
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
                    beginAtZero: true,
                },
            },
        },
    });
}

// Função para criar o gráfico de barras (Castração)
function criarGraficoCastracao(castrados) {
    const ctx = document.getElementById("bar-chart-castracao").getContext("2d");

    const contagemCastracao = castrados.reduce((acc, castrado) => {
        acc[castrado] = (acc[castrado] || 0) + 1;
        return acc;
    }, {});

    new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: Object.keys(contagemCastracao),
            datasets: [{
                label: "Contagem de Castrações",
                data: Object.values(contagemCastracao),
                backgroundColor: [
                    "rgba(255, 206, 86, 0.7)",
                    "rgba(54, 162, 235, 0.7)",
                ],
                borderColor: [
                    "rgba(255, 206, 86, 1)",
                    "rgba(54, 162, 235, 1)",
                ],
                borderWidth: 1,
            }],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
}

// Função para criar o gráfico de barras (Doenças)
function criarGraficoDoencas(doencas) {
    const ctx = document.getElementById("stacked-bar-chart-doenca").getContext("2d");

    const contagemDoencas = doencas.reduce((acc, doenca) => {
        acc[doenca] = (acc[doenca] || 0) + 1;
        return acc;
    }, {});

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: Object.keys(contagemDoencas),
            datasets: [{
                label: "Suadáveis",
                data: Object.values(contagemDoencas),
                backgroundColor: [
                    "rgba(0, 0, 255, 0.2)",
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
                    beginAtZero: true,
                },
            },
        },
    })};


// Função para criar o gráfico de barras (Vacinas)
function criarGraficoVacinas(pets) {
    const ctx = document.getElementById("bar-chart-vacinas").getContext("2d");

    const vacinados = pets.filter(pet => pet.Vacinas && pet.Vacinas.AnimalVacinado === "Sim");
    const naoVacinados = pets.filter(pet => pet.Vacinas && pet.Vacinas.AnimalVacinado !== "Sim");

    console.log(`Número de animais vacinados: ${vacinados.length}`);
    console.log(`Número de animais não vacinados: ${naoVacinados.length}`);

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: ["Vacinados", "Não Vacinados"],
            datasets: [{
                label: "Contagem de Vacinas",
                data: [vacinados.length, naoVacinados.length],
                backgroundColor: [
                    "rgba(0, 128, 0, 0.2)", // Verde
                    "rgba(255, 255, 0, 0.2)", // Amarelo
                ],
                borderColor: [
                    "rgba(0, 128, 0, 1)", // Verde
                    "rgba(255, 255, 0, 1)", // Amarelo
                ],

                borderWidth: 1,
            }],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
}






// Função para criar o gráfico de linha (Idades)
function criarGraficoIdades(pets) {
    const ctx = document.getElementById("line-chart-nascimentos-idades").getContext("2d");

    const idades = pets.map(pet => calcularIdade(pet.DadosGerais.DataNascimento, pet.DadosGerais.DataObito));

    const data = {
        labels: idades.map(String),
        datasets: [{
            label: "Idades de Pets",
            data: idades,
            borderColor: "rgba(75, 192, 192, 1)",
            borderWidth: 2,
            fill: false,
        }],
    };

    const options = {
        scales: {
            y: {
                beginAtZero: true,
            },
        },
        plugins: {
            annotation: {
                annotations: [{
                    type: 'line',
                    mode: 'horizontal',
                    scaleID: 'y',
                    value: idades[0], // Primeira idade
                    borderColor: 'red',
                    borderWidth: 2,
                    label: {
                        content: 'Primeira Idade',
                        enabled: true,
                    }
                }]
            }
        }
    };

    new Chart(ctx, {
        type: "line",
        data: data,
        options: options
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

