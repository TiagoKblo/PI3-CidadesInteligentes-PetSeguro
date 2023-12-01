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
    const inferiorEsquerdo = { lat: lat - altura, lng: lng - largura };
    const superiorDireito = { lat: lat - altura, lng: lng + largura };
    const inferiorDireito = { lat: lat - altura, lng: lng };

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
    const larguraQuadrante = 0.02;
    const alturaQuadrante = 0.02;

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
    adicionarPoligono(map, pontoID4, pontoSD4, pontoSE4, pontoIE4, '#FFFF00');
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
