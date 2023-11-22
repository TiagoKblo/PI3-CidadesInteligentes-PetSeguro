// Initialize AOS
AOS.init();
// Função para exibir mensagens na página
function exibirMensagem(tipo, mensagem) {
  const mensagemElement = document.getElementById('mensagem');
  mensagemElement.innerHTML = `<div class="alert alert-${tipo}" role="alert">${mensagem}</div>`;
}


// Verifica se a página atual é 'cadastropet.html'
if (document.location.pathname.endsWith("cadastropet.html")) {
  //Mostra ou oculta o campo de texto "Qual doença?"
  function mostrarOcultarDoenca(selectElement) {
    var qualDoencaDiv = document.getElementById("qual-doenca-div");
    if (selectElement.value === "sim") {
      qualDoencaDiv.style.display = "block"; // Mostrar a div se "Sim" for selecionado
    } else {
      qualDoencaDiv.style.display = "none"; // Ocultar a div se "Não" for selecionado
    }
  }

  // Obtém referências para os elementos do formulário
  var especieSelect = document.getElementById("especie");
  var outraEspecieInput = document.getElementById("outra-especie");

  // Adiciona um ouvinte de evento para o campo "Espécie"
  especieSelect.addEventListener("change", function () {
    if (especieSelect.value === "outro") {
      // Se "Outra" for selecionada, mostra o campo "Qual espécie?"
      outraEspecieInput.style.display = "block";
    } else {
      // Caso contrário, oculta o campo "Qual espécie?"
      outraEspecieInput.style.display = "none";
    }
  });
  function mostrarOutraEspecie() {
    // Mostra o campo "Qual espécie?"
    outraEspecieInput.style.display = "block";
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

    if (selectElement.value === "sim") {
      camposVacina.style.display = "block";
    } else {
      camposVacina.style.display = "none";
    }
  }
}

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

    if(!onlyNumbers.test(cep.value) || !cepValid.test(cep.value)){
      throw {cep_error: 'Cep Inválido'};
    }

    const response = await fetch(`https://viacep.com.br/ws/${cep.value}/json/`);

    if(!response.ok) {
      throw await response.json();
    }

    const responseCep = await response.json();

    estado.value = responseCep.uf;
    cidade.value = responseCep.localidade;
    bairro.value = responseCep.bairro;
    rua.value = responseCep.logradouro;



  } catch (error) {
    if(error?.cep_error){
      message.textContent = error.error_cep;
      setTimeout(() => {
        message.textContent = "";
      }, 5000);
    }
    console.log(error);
  }

})
