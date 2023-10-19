
// Initialize AOS
AOS.init();

// Função para verificar se a página rolou até o final
function isPageAtBottom() {
  return (window.innerHeight + window.scrollY) >= document.body.offsetHeight;
}

// Função para mostrar ou ocultar o rodapé com base na posição da página
function toggleFooterVisibility() {
  if (isPageAtBottom()) {
      document.getElementById('myFooter').style.display = 'block';
  } else {
      document.getElementById('myFooter').style.display = 'none';
  }
}

// Adicionar um ouvinte de evento de rolagem
window.addEventListener('scroll', toggleFooterVisibility);

// Chamar a função inicialmente para verificar o estado da página
toggleFooterVisibility();
