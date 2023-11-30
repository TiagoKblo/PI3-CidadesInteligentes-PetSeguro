// Função para carregar os dados do JSON e atualizar a interface
async function carregarEstatisticas() {
  try {
      // Faz uma requisição assíncrona para o arquivo JSON
      const resposta = await fetch('dados_animais.json');
      const dados = await resposta.json();

      // Calcula as estatísticas
      const totalAnimaisCadastrados = dados.length;
      const animaisComChip = dados.filter(animal => animal['possui-microchip'] === 'sim').length;
      const animaisPerdidos = dados.filter(animal => animal['animal-perdido'] === 'sim').length;

      // Atualiza os campos no HTML com os dados obtidos
      document.getElementById('total-animais').innerText = totalAnimaisCadastrados;
      document.getElementById('possui-microchip').innerText = animaisComChip;
      document.getElementById('animal-perdido').innerText = animaisPerdidos;

      // Chamando a função para animar os números desejados após carregar as estatísticas
      animateNumber("#total-animais", totalAnimaisCadastrados, 1000);
      animateNumber("#possui-microchip", animaisComChip, 1000);
      animateNumber("#animal-perdido", animaisPerdidos, 1000);
  } catch (erro) {
      console.error('Erro ao carregar estatísticas:', erro);
  }
}

// Chama a função para carregar as estatísticas quando a página carregar
document.addEventListener('DOMContentLoaded', carregarEstatisticas);

// Função para animar os números
function animateNumber(element, targetValue, duration) {
  $({ value: 0 }).animate({ value: targetValue }, {
      duration: duration,
      step: function () {
          $(element).text(Math.ceil(this.value));
      }
  });
}
