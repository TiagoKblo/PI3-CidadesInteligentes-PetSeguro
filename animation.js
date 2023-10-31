
// Função para animar os números
function animateNumber(element, targetValue, duration) {
  $({ value: 0 }).animate({ value: targetValue }, {
      duration: duration,
      step: function () {
          $(element).text(Math.ceil(this.value));
      }
  });
}

// Chamando a função para animar os números desejados
animateNumber("#total-animais-cadastrados", 100, 2000);
animateNumber("#animais-com-chip", 75, 2000);
animateNumber("#animais-encontrados", 30, 2000);
