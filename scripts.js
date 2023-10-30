// Initialize AOS
AOS.init();

// Verifica se a página atual é "cadastro.html" antes de adicionar o evento
if (window.location.pathname === '/cadastro.html') {
  // Obtém o elemento de formulário com o ID "cadastro-form"
  const form = document.getElementById("cadastro-form");

  // Verifica se o elemento foi encontrado antes de adicionar o ouvinte de evento
  if (form) {
    // Adiciona um evento de submissão do formulário
    form.addEventListener("submit", function(event) {
      // Redireciona para a página "cadastropet.html" quando o formulário é enviado
      window.location.href = "cadastropet.html";

      // Impede que o formulário seja submetido normalmente (evita recarregar a página)
      event.preventDefault();
    });
  }
}
