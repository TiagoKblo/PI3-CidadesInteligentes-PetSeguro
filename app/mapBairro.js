var google;

function gerarQuadrantes(lat, lng, largura, altura) {
    const superiorEsquerdo = { lat: lat + altura / 2, lng: lng - largura / 2 };
    const inferiorEsquerdo = { lat: lat - altura / 2, lng: lng - largura / 2 };
    const superiorDireito = { lat: lat + altura / 2, lng: lng + largura / 2 };
    const inferiorDireito = { lat: lat - altura / 2, lng: lng + largura / 2 };

    return { superiorEsquerdo, inferiorEsquerdo, superiorDireito, inferiorDireito };
}

function initMap() {
    const geocoder = new google.maps.Geocoder();
    const location = "Itapira, SP, Brasil";

    geocoder.geocode({ 'address': location }, function (results, status) {
        if (status === 'OK') {
            const myLatLng = results[0].geometry.location;
            const map = new google.maps.Map(document.getElementById('map'), {
                center: myLatLng,
                zoom: 11
            });

            const cityIconSize = new google.maps.Size(20, 20);

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

            adicionarQuadrantes(map, myLatLng);
        } else {
            console.error('Erro ao obter coordenadas:', status);
        }
    });
}

function adicionarQuadrantes(map, coordenadaCentral) {
    const larguraQuadrante = 0.01;
    const alturaQuadrante = 0.01;

    const quadrantes = gerarQuadrantes(coordenadaCentral.lat(), coordenadaCentral.lng(), larguraQuadrante, alturaQuadrante);

    adicionarPoligono(map, quadrantes.superiorEsquerdo, quadrantes.inferiorEsquerdo, quadrantes.inferiorDireito, quadrantes.superiorDireito, '#FF0000'); // Vermelho
    adicionarPoligono(map, quadrantes.inferiorEsquerdo, quadrantes.inferiorDireito, quadrantes.superiorDireito, quadrantes.superiorEsquerdo, '#00FF00'); // Verde
    adicionarPoligono(map, quadrantes.superiorDireito, quadrantes.inferiorDireito, quadrantes.inferiorEsquerdo, quadrantes.superiorEsquerdo, '#0000FF'); // Azul
    adicionarPoligono(map, quadrantes.inferiorEsquerdo, quadrantes.superiorEsquerdo, quadrantes.superiorDireito, quadrantes.inferiorDireito, '#FFFF00'); // Amarelo
}

function adicionarPoligono(map, ponto1, ponto2, ponto3, ponto4, cor) {
    const quadrantePoligono = new google.maps.Polygon({
        paths: [ponto1, ponto2, ponto3, ponto4],
        strokeColor: cor,
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: cor,
        fillOpacity: 0.35,
    });

    quadrantePoligono.setMap(map);
}
