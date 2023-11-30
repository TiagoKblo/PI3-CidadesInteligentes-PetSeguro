// Chame a função initMap quando o script for carregado
initMap();

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

            // Ícone da cidade
            const cityIconSize = new google.maps.Size(20, 20);

            // Crie um objeto de ícone para a cidade com a propriedade scaledSize definida
            const cityIcon = {
                url: '/imagens/icone-cidade.png',
                scaledSize: cityIconSize
            };

            new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: location,
                icon: cityIcon
            });

            // Adicione os quadrantes ao mapa
            adicionarQuadrantes(map, myLatLng);
        } else {
            console.error('Erro ao obter coordenadas:', status);
        }
    });
}

function adicionarQuadrantes(map, coordenadaCentral) {
    const larguraQuadrante = 0.01; // Ajuste a largura do quadrante conforme necessário
    const alturaQuadrante = 0.01; // Ajuste a altura do quadrante conforme necessário

    // Gere as coordenadas para os 4 quadrantes
    const quadranteSuperior = gerarQuadrante(coordenadaCentral.lat(), coordenadaCentral.lng(), larguraQuadrante, alturaQuadrante).superior;
    const quadranteInferior = gerarQuadrante(coordenadaCentral.lat(), coordenadaCentral.lng(), larguraQuadrante, alturaQuadrante).inferior;
    const quadranteEsquerda = gerarQuadrante(coordenadaCentral.lat(), coordenadaCentral.lng(), larguraQuadrante, alturaQuadrante).esquerda;
    const quadranteDireita = gerarQuadrante(coordenadaCentral.lat(), coordenadaCentral.lng(), larguraQuadrante, alturaQuadrante).direita;

    // Adicione polígonos para representar os quadrantes
    adicionarPoligono(map, quadranteSuperior, '#FF0000'); // Vermelho
    adicionarPoligono(map, quadranteInferior, '#00FF00'); // Verde
    adicionarPoligono(map, quadranteEsquerda, '#0000FF'); // Azul
    adicionarPoligono(map, quadranteDireita, '#FFFF00'); // Amarelo
}

function gerarQuadrante(lat, lng, largura, altura) {
    const superior = { lat: lat + altura / 2, lng: lng };
    const inferior = { lat: lat - altura / 2, lng: lng };
    const esquerda = { lat: lat, lng: lng - largura / 2 };
    const direita = { lat: lat, lng: lng + largura / 2 };

    return { superior, inferior, esquerda, direita };
}

function adicionarPoligono(map, coordenadas, cor) {
    const quadrantePoligono = new google.maps.Polygon({
        paths: coordenadas,
        strokeColor: cor,
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: cor,
        fillOpacity: 0.35,
    });

    quadrantePoligono.setMap(map);
}
