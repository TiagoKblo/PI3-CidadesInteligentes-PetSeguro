// Initialize AOS
AOS.init();

// Verifica se a página atual é "cadastro.html" antes de adicionar o evento
if (window.location.pathname === '/cadastro.html') {
  // Obtém o elemento de formulário com o ID "cadastro-form"
  const form = document.getElementById("cadastro-form");

  // Verifica se o elemento foi encontrado antes de adicionar o ouvinte de evento
  if (form) {
    // Adiciona um evento de submissão do formulário
    form.addEventListener("submit", function (event) {
      // Redireciona para a página "cadastropet.html" quando o formulário é enviado
      window.location.href = "cadastropet.html";

      // Impede que o formulário seja submetido normalmente (evita recarregar a página)
      event.preventDefault();
    });
  }
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
