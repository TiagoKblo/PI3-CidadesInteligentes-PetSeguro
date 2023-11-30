// Initialize AOS
AOS.init();
// Função para exibir mensagens na página
function exibirMensagem(tipo, mensagem) {
  const mensagemElement = document.getElementById('mensagem');
  mensagemElement.innerHTML = `<div class="alert alert-${tipo}" role="alert">${mensagem}</div>`;
}
if (document.location.pathname.endsWith("cadastropet.html")) {
  $(document).ready(function () {
      $('#cpf-proprietario').on('blur', function () {
          var cpf = $('#cpf-proprietario').val();

          // Faz uma requisição AJAX para buscar o nome do proprietário
          $.ajax({
              type: 'POST',
              url: 'buscar_nome_proprietario.php',
              data: { cpf: cpf },
              success: function (response) {
                  // Atualiza o conteúdo do popover com o nome do proprietário
                  $('#cpf-proprietario').attr('data-bs-content', response);
                  $('#cpf-proprietario').popover('show');
              },
              error: function (error) {
                  console.error('Erro ao buscar o nome do proprietário:', error);
              }
          });
      });

      // Inicializa o popover
    $('#cpf-proprietario').popover({
      placement: 'right',
      trigger: 'focus',
      html: true
    });
  });

  // Obtém referências para os elementos do formulário
  var especieSelect = document.getElementById("especie");
  var outraEspecieLabel = document.getElementById("outra-especie-label");
  var outraEspecieInput = document.getElementById("outra-especie-input");

  // Adiciona um ouvinte de evento para o campo "Espécie"
  especieSelect.addEventListener("change", function () {
    mostrarOutraEspecie();
  });

  function mostrarOutraEspecie() {
    // Mostra o campo "Qual espécie?" e a caixa de texto apenas se "Outra" for selecionada
    if (especieSelect.value === "outro") {
      outraEspecieLabel.style.display = "block";
      outraEspecieInput.style.display = "block";
    } else {
      outraEspecieLabel.style.display = "none";
      outraEspecieInput.style.display = "none";
    }
  }

  // Mostra ou oculta o campo de texto "Qual doença?"
  function mostrarOcultarDoenca(selectElement) {
    var qualDoencaDiv = document.getElementById("qual-doenca-div");
    var qualDoencaInput = document.getElementById("qual-doenca");

    if (selectElement.value === "sim") {
      qualDoencaDiv.style.display = "block"; // Mostrar a div se "Sim" for selecionado
    } else {
      qualDoencaDiv.style.display = "none"; // Ocultar a div se "Não" for selecionado
      // Limpar o valor do campo quando ele estiver oculto
      qualDoencaInput.value = "";
    }
  }

  function mostrarOcultarChip(selectElement) {
    var numeroDoChipDiv = document.getElementById("numero-do-chip-div");
    var numeroDoChipInput = document.getElementById("numero-do-chip");

    if (selectElement.value === "sim") {
      numeroDoChipDiv.style.display = "block";
    } else {
      numeroDoChipDiv.style.display = "none";
      // Limpar o valor do campo quando ele estiver oculto
      numeroDoChipInput.value = "";
    }
  }

  function mostrarOcultarCamposVacina(selectElement) {
    var camposVacina = document.getElementById("campos-vacina");

    camposVacina.style.display = selectElement.value === "sim" ? "block" : "none";
  }
}

// Verifica se a página atual é 'fichapet.php'
if (document.location.pathname.endsWith("fichapet.php")) {
  // Código existente para 'fichapet.php'

  // Função para mostrar/ocultar campos de vacina
function mostrarCamposVacina() {
  var camposVacina = document.getElementById("campos-vacina");
  camposVacina.style.display = "block";
}

// Função para adicionar campos de uma nova vacina
function adicionarVacina() {
  // Obtém a referência para os campos de vacina
  var camposVacina = document.getElementById("campos-vacina");

  // Clone do primeiro conjunto de campos de vacina
  var novaVacina = camposVacina.firstElementChild.cloneNode(true);

  // Limpa os valores nos campos clonados
  var inputs = novaVacina.querySelectorAll("input");
  inputs.forEach(function (input) {
    input.value = "";
  });

  // Adiciona a nova vacina ao final da lista
  camposVacina.appendChild(novaVacina);

  // Obtém os valores dos campos da nova vacina
  var tipoVacina = novaVacina.querySelector('input[name="tipo-vacina[]"]').value;
  var dataVacina = novaVacina.querySelector('input[name="data-vacina[]"]').value;
  var validadeVacina = novaVacina.querySelector('input[name="validade-vacina[]"]').value;
  var loteVacina = novaVacina.querySelector('input[name="lote-vacina[]"]').value;
  var fabricanteVacina = novaVacina.querySelector('input[name="fabricante-vacina[]"]').value;
  var doseVacina = novaVacina.querySelector('input[name="dose-vacina[]"]').value;

  // Faz uma requisição AJAX para o arquivo PHP que salvará as informações no banco de dados
  $.ajax({
    type: 'POST',
    url: 'salvar_vacina.php', // Altere para o nome do arquivo PHP que salvará as informações
    data: {
      tipoVacina: tipoVacina,
      dataVacina: dataVacina,
      validadeVacina: validadeVacina,
      loteVacina: loteVacina,
      fabricanteVacina: fabricanteVacina,
      doseVacina: doseVacina
    },
    success: function (response) {
      // Exibe uma mensagem de sucesso (ou tratamento adicional, se necessário)
      exibirMensagem('success', 'Vacina adicionada com sucesso!');
    },
    error: function (error) {
      // Exibe uma mensagem de erro (ou tratamento adicional, se necessário)
      exibirMensagem('danger', 'Erro ao adicionar vacina. Tente novamente.');
      console.error('Erro ao adicionar vacina:', error);
    }
  });
}
}


// Verifica se a página atual é 'cadastro.html'
if (
  document.location.pathname.endsWith("cadastro.html") ||
  document.location.pathname.endsWith("cadastro_vet.html")
) {
  // Se a página for 'cadastro.html' ou 'cadastro_vet.html', o código será executado

  // API DE CEP
  const cep = document.querySelector('#cep');
  const estado = document.querySelector('#estado');
  const cidade = document.querySelector('#cidade');
  const bairro = document.querySelector('#bairro');
  const rua = document.querySelector('#rua');
  const message = document.querySelector('#message');

  cep.addEventListener('focusout', async () => {
    try {
      const onlyNumbers = /^[0-9]+$/;
      const cepValid = /^[0-9]+$/;

      if (!onlyNumbers.test(cep.value) || !cepValid.test(cep.value)) {
        throw { cep_error: 'Cep Inválido' };
      }

      const response = await fetch(`https://viacep.com.br/ws/${cep.value}/json/`);

      if (!response.ok) {
        throw await response.json();
      }

      const responseCep = await response.json();

      estado.value = responseCep.uf;
      cidade.value = responseCep.localidade;
      bairro.value = responseCep.bairro;
      rua.value = responseCep.logradouro;
    } catch (error) {
      if (error?.cep_error) {
        message.textContent = error.error_cep;
        setTimeout(() => {
          message.textContent = "";
        }, 5000);
      }
      console.log(error);
    }
  });
}
 
