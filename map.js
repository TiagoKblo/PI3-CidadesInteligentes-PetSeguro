
// Função para inicializar o mapa
function initMap() {
    const myLatLng = { lat: -22.4334, lng: -46.8222 }; // Coordenadas da cidade de Itapira, SP, Brasil
    const map = new google.maps.Map(document.getElementById('map'), {
        center: myLatLng,
        zoom: 8
    });
}
