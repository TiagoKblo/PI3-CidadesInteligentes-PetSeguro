var google;



function gerarQuadradoSuperiorEsquerdo(lat, lng, largura, altura) {
    const superiorEsquerdo = { lat: lat + altura, lng: lng - largura };
    const inferiorEsquerdo = { lat: lat, lng: lng - largura };
    const superiorDireito = { lat: lat + altura, lng: lng };
    const inferiorDireito = { lat: lat, lng: lng };

    return { superiorEsquerdo, inferiorEsquerdo, superiorDireito, inferiorDireito };
}

function gerarQuadradoSuperiorDireito(lat, lng, largura, altura) {
    const superiorEsquerdo = { lat: lat + altura, lng: lng };
    const inferiorEsquerdo = { lat: lat, lng: lng };
    const superiorDireito = { lat: lat + altura, lng: lng + largura };
    const inferiorDireito = { lat: lat, lng: lng + largura };

    return { superiorEsquerdo, inferiorEsquerdo, superiorDireito, inferiorDireito };
}

function gerarQuadradoInferiorEsquerdo(lat, lng, largura, altura) {
    const superiorEsquerdo = { lat: lat, lng: lng - largura };
    const inferiorEsquerdo = { lat: lat - altura, lng: lng - largura };
    const superiorDireito = { lat: lat, lng: lng };
    const inferiorDireito = { lat: lat - altura, lng: lng };

    return { superiorEsquerdo, inferiorEsquerdo, superiorDireito, inferiorDireito };
}

function gerarQuadradoInferiorDireito(lat, lng, largura, altura) {
    const superiorEsquerdo = { lat: lat - altura, lng: lng };
    const inferiorEsquerdo = { lat: lat, lng: lng };
    const superiorDireito = { lat: lat - altura, lng: lng + largura };
    const inferiorDireito = { lat: lat, lng: lng + largura };

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
                zoom: 12
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
function adicionarMarcador(map, position, label) {
    new google.maps.Marker({
        position: position,
        map: map,
        label: label,
        draggable: false,
    });
}
function adicionarQuadrantes(map, coordenadaCentral) {
    const larguraQuadrante = 0.05;
    const alturaQuadrante = 0.05;

    const quadradoSuperiorEsquerdo = gerarQuadradoSuperiorEsquerdo(coordenadaCentral.lat(), coordenadaCentral.lng(), larguraQuadrante, alturaQuadrante);
    const quadradoSuperiorDireito = gerarQuadradoSuperiorDireito(coordenadaCentral.lat(), coordenadaCentral.lng(), larguraQuadrante, alturaQuadrante);
    const quadradoInferiorEsquerdo = gerarQuadradoInferiorEsquerdo(coordenadaCentral.lat(), coordenadaCentral.lng(), larguraQuadrante, alturaQuadrante);
    const quadradoInferiorDireito = gerarQuadradoInferiorDireito(coordenadaCentral.lat(), coordenadaCentral.lng(), larguraQuadrante, alturaQuadrante);

    // Desestruturando os pontos corretos para cada quadrante
    const { superiorEsquerdo: pontoSE1, inferiorEsquerdo: pontoIE1, superiorDireito: pontoSD1, inferiorDireito: pontoID1 } = quadradoSuperiorEsquerdo;
    const { superiorEsquerdo: pontoSE2, inferiorEsquerdo: pontoIE2, superiorDireito: pontoSD2, inferiorDireito: pontoID2 } = quadradoSuperiorDireito;
    const { superiorEsquerdo: pontoSE3, inferiorEsquerdo: pontoIE3, superiorDireito: pontoSD3, inferiorDireito: pontoID3 } = quadradoInferiorEsquerdo;
    const { superiorEsquerdo: pontoSE4, inferiorEsquerdo: pontoIE4, superiorDireito: pontoSD4, inferiorDireito: pontoID4 } = quadradoInferiorDireito;

    adicionarPoligono(map, pontoSE1, pontoIE1, pontoID1, pontoSD1, '#FF0000');
    adicionarPoligono(map, pontoIE2, pontoSE2, pontoSD2, pontoID2, '#00FF00');
    adicionarPoligono(map, pontoSD3, pontoID3, pontoIE3, pontoSE3, '#0000FF');
    adicionarPoligono(map, pontoIE4, pontoSE4, pontoSD4, pontoID4, '#FFFF00');

    const pontoMedioNE = {
        lat: (pontoSE1.lat + pontoSD1.lat + pontoIE1.lat + pontoID1.lat) / 4,
        lng: (pontoSE1.lng + pontoSD1.lng + pontoIE1.lng + pontoID1.lng) / 4
    };
    const pontoMedioNW = {
        lat: (pontoSE2.lat + pontoSD2.lat + pontoIE2.lat + pontoID2.lat) / 4,
        lng: (pontoSE2.lng + pontoSD2.lng + pontoIE2.lng + pontoID2.lng) / 4
    };
    const pontoMedioSW = {
        lat: (pontoSE3.lat + pontoSD3.lat + pontoIE3.lat + pontoID3.lat) / 4,
        lng: (pontoSE3.lng + pontoSD3.lng + pontoIE3.lng + pontoID3.lng) / 4
    };
    const pontoMedioSE = {
        lat: (pontoSE4.lat + pontoSD4.lat + pontoIE4.lat + pontoID4.lat) / 4,
        lng: (pontoSE4.lng + pontoSD4.lng + pontoIE4.lng + pontoID4.lng) / 4
    };

    // Adicionar marcadores
    adicionarMarcador(map, pontoMedioNE, "NE");
    adicionarMarcador(map, pontoMedioNW, "NW");
    adicionarMarcador(map, pontoMedioSW, "SW");
    adicionarMarcador(map, pontoMedioSE, "SE");
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
