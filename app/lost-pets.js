// Exemplo de dados de animais perdidos
const lostPetsData = [
    {
      name: 'REX',
      type: 'Cachorro',
      color: 'Marrom',
      coordinates: { lat: -22.439, lng: -46.830 }
    },
    // Adicione mais animais conforme necessário
    {
        name: 'TOTO',
        type: 'Cachorro',
        color: 'Amarelo',
        coordinates: { lat: -22.440, lng: -46.815 }
    },
    {
        name: 'Garfield',
        type: 'Gato',
        color: 'Laranja',
        coordinates: { lat: -22.410, lng: -46.840 }
    }
  ];

  // Função para carregar marcadores de animais perdidos no mapa
  function loadLostPetsMarkers(map) {
    // Ícone do animal com tamanho menor (por exemplo, 10x10)
    const animalIconSize = new google.maps.Size(25, 25);

    // Crie um objeto de ícone para o animal com a propriedade scaledSize definida
    const animalIcon = {
      url: '/imagens/icone-pata.png',
      scaledSize: animalIconSize
    };

    lostPetsData.forEach(function (animal) {
      const marker = new google.maps.Marker({
        position: animal.coordinates,
        map: map,
        title: animal.name,
        icon: animalIcon // Usando o ícone personalizado com o tamanho ajustado
      });

      marker.addListener('click', function () {
        showAnimalInfo(animal);
      });
    });
  }

  // Chame a função para carregar os marcadores de animais perdidos
  loadLostPetsMarkers(map);
