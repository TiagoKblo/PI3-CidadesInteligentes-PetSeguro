// map.js

function initMap() {
  const myLatLng = { lat: -22.4334, lng: -46.8222 }; // Coordenadas da cidade de Itapira, SP, Brasil
  const map = new google.maps.Map(document.getElementById('map'), {
      center: myLatLng,
      zoom: 8
  });

// Exemplo de marcador personalizado para um animal de estimação
const petMarker = new google.maps.Marker({
  position: { lat: -22.4334, lng: -46.8222 }, // Coordenadas do animal de estimação
  map: map, // O mapa em que o marcador será exibido
  icon: 'caminho-para-o-seu-icone.png' // Caminho para o ícone personalizado
});

}
