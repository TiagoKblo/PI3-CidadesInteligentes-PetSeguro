let movableMarker;

function initMap() {
  // Use a Geocoding API para obter as coordenadas para "Itapira, SP, Brasil"
  const geocoder = new google.maps.Geocoder();
  const location = "Itapira, SP, Brasil";

  geocoder.geocode({ 'address': location }, function (results, status) {
      if (status === 'OK') {
          const myLatLng = results[0].geometry.location;
          const map = new google.maps.Map(document.getElementById('map'), {
              center: myLatLng,
              zoom: 11
          });

          // Adicione um marcador para a localização
          new google.maps.Marker({
              position: myLatLng,
              map: map,
              title: location
          });

          // Carregue e exiba os polígonos do GeoJSON
          loadGeoJson(map);
      } else {
          console.error('Erro ao obter coordenadas:', status);
      }
  });
}

function loadGeoJson(map) {
  // Carregue o arquivo GeoJSON (itapira.json)
  map.data.loadGeoJson('itapira.json');

  // Defina estilos para os polígonos
  map.data.setStyle({
      fillColor: 'green',
      strokeWeight: 1
  });
}
map.addListener('click', function (event) {
    if (!movableMarker) {
        movableMarker = new google.maps.Marker({
            position: event.latLng,
            map: map,
            draggable: true, // Torna o marcador móvel
            title: 'Escolher Localização'
        });

        // Adicione um ouvinte para atualizar as coordenadas quando o marcador for movido
        movableMarker.addListener('dragend', function () {
            updateLocation(movableMarker.getPosition());
        });
    } else {
        movableMarker.setPosition(event.latLng);
        updateLocation(movableMarker.getPosition());
    }
});


function updateLocation(latLng) {
// Atualize a localização no seu formulário ou onde quer que você esteja armazenando as coordenadas
document.getElementById('location').value = latLng.lat() + ', ' + latLng.lng();
}
