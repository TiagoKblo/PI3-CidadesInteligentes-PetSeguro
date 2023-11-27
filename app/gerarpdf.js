const btnGeneratePDF = document.querySelector('#btnGeneratePDF');

btnGeneratePDF.addEventListener('click', () => {
//conteudo pdf
  const content = document.querySelector('#estatisticas');
  //configurações do pdf
  const options = {
    margin: 1,
    filename: 'vacinas.pdf',
    image: { type: 'jpeg', quality: 0.98 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }


  }

  html2pdf().set(options).from(estatisticas).save();
}
);
