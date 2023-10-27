// Initialize AOS
AOS.init();

// Função para redirecionar para a página de cadastro pet
document.addEventListener("DOMContentLoaded", function() {
  // Obtém o elemento de formulário com o ID "cadastro-form"
  const form = document.getElementById("cadastro-form");

  // Adiciona um evento de submissão do formulário
  form.addEventListener("submit", function(event) {
    // Redireciona para a página "cadastropet.html" quando o formulário é enviado
    window.location.href = "cadastropet.html";
    
    // Impede que o formulário seja submetido normalmente (evita recarregar a página)
    event.preventDefault();
  });
});
