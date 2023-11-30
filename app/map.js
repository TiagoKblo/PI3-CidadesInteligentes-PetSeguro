let animalInfoDiv;
let animalIcon;

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

            // Carregue e exiba os polígonos do GeoJSON
            loadGeoJson(map);

            // Adicione marcadores de animais perdidos
            loadLostPetsMarkers(map);
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

// Função para carregar marcadores de animais perdidos no mapa
function loadLostPetsMarkers(map) {
    const lostPetsData = [
        {
            name: 'Cachorro Perdido',
            type: 'Cachorro',
            color: 'Marrom',
            coordinates: { lat: -22.439, lng: -46.830 }
        },
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

    // Ícone do animal com tamanho menor (por exemplo, 10x10)
    const animalIconSize = new google.maps.Size(25, 25);

    // Crie um objeto de ícone para o animal com a propriedade scaledSize definida
    animalIcon = {
        url: '/imagens/icone-pata.png',
        scaledSize: animalIconSize
    };

    lostPetsData.forEach(function (animal) {
        const marker = new google.maps.Marker({
            position: animal.coordinates,
            map: map,
            title: animal.name,
            icon: animalIcon
        });

        marker.addListener('click', function () {
            showAnimalInfo(animal);
        });
    });
}

function showAnimalInfo(info) {
    document.getElementById('animal-name').innerText = info.name;
    document.getElementById('animal-type').innerText = info.type;
    document.getElementById('animal-color').innerText = info.color;
    // Adicione mais campos conforme necessário
}
